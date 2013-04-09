<?php

/** Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
class DeleteAllForm extends CFormModel {
    public $tans = false;
    public $appointments = false;
    public $teachers;
    public $dates;
    public $management;
    public $childs;
    public $parents;

    public function rules() {
        return array(
            array('tans,appointments,teachers,dates,management,childs,parents','required'),
        array('tans,appointments,teachers,dates,management,childs,parents','boolean'),
            array('tans,appointments,teachers,dates,management,childs,parents','safe'));
                
    }
    
    public function attributeLabels() {
        return array('tans'=>'Tans',
            'appointments'=>'Termine',
            'teachers'=>'Lehrer',
            'dates'=>'Elternsprechtage',
            'management'=>'Verwaltungsbenutzerkontos',
            'childs'=>'Schüler',
            'parents'=>'Elternkonten',
            );
    }
    
    /**
     * Validiert ob Abhängigkeiten erfüllt sind
     * @param array $attributes
     * @param boolean $clearErrors
     * @return boolean
     */
    public function validate($attributes = null, $clearErrors = true) {
        $rc = true;
        if(parent::validate($attributes, $clearErrors)) {
            if(($this->teachers || $this->dates || $this->parents) && !$this->appointments) {
                $rc = false;
                $this->addError('appointments', 'Sie müssen auch alle Termine löschen.');
            }
            if($this->parents && !$this->childs) {
                $rc = false;
                $this->addError('parents', 'Kinder müssen auch gelöscht werden.');
            }
            
        } else {
            $rc = false;
        }
        return $rc;
    }
    
    /**
     * Loescht entsprechend die Datensätze
     */
    public function delete() {
        if($this->tans) {
            Tan::model()->deleteAll();
        }
        if($this->appointments) {
            Appointment::model()->deleteAll();
            BlockedAppointment::model()->deleteAll();
        }
        if($this->teachers) {
            User::model()->deleteUsersWithRole(2);
        }
        if($this->dates) {
            DateAndTime::model()->deleteAll();
            Date::model()->deleteAll();
        }
        if($this->management) {
            User::model()->deleteUsersWithRole(1);
        }
        if($this->childs) {
            ParentChild::model()->deleteAll();
            Child::model()->deleteAll();
        }
        if($this->parents) {
            User::model()->deleteUsersWithRole(3);
        }
        Yii::app()->user->setFlash('success','Erfolgreich!');
    }
    
    
}
?>
