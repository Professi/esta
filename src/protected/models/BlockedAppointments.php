<?php

/* Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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

/** The followings are the available columns in table 'appointment':
 * @property integer $id
 * @property string $reason
 * @property string $user_id
 * @property integer $dateAndTime_id
 *
 * The followings are the available model relations:
 * @property DateAndTime $dateAndTime
 * @property User $user
 * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
 */
class BlockedAppointments extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Appointment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Tabellenname
     * @return string the associated database table name
     */
    public function tableName() {
        return 'blockedAppointments';
    }

    public function rules() {
        return array(
            array('dateAndTime_id,user_id','exist'),
            array('reason','required'),
            array('reason','length','min'=>Yii::app()->params['lengthReasonAppointmentBlocked']),
        );
    }

    public function relations() {
        return array(
            'dateAndTime' => array(self::BELONGS_TO, 'DateAndTime', 'dateAndTime_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }
    
    public function validate($attributes = null, $clearErrors = true) {
        $rc = false;
        if(parent::validate($attributes, $clearErrors)) {
            if($this->user->role == 2) {
                $rc = true;
            } else {
                $this->addError('user_id', 'Kein Lehrer.');
            }
        }
    }

    public function attributeLabels() {
        return array(
            'user_id'=>'Lehrer',
            'dateAndTime_id'=>'Termin',
            'reason'=>'Grund',
        );
    }

}

?>
