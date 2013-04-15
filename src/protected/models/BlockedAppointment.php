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
class BlockedAppointment extends CActiveRecord {

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
        return 'blockedAppointment';
    }

    public function rules() {
        return array(
            array('dateAndTime_id,user_id,reason', 'required'),
            array('user_id', 'exist', 'className' => 'UserRole'),
            //     array('user_id','exist'),
            array('reason', 'length', 'min' => Yii::app()->params['lengthReasonAppointmentBlocked']),
            array('dateAndTime_id, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function countUsedDateAndTimes() {
        $crit = new CDbCriteria();
        $crit->with = 'dateAndTime';
        $crit->addCondition('user_id=' . $this->user_id, 'AND');
        $crit->addCondition('dateAndTime.date_id=' . $this->dateAndTime->date_id, 'AND');
        return $crit;
    }

    public function relations() {
        return array(
            'dateAndTime' => array(self::BELONGS_TO, 'DateAndTime', 'dateAndTime_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * Prüft ob der Benutzer ein Lehrer ist, prüft ob nicht bereits zuviele Termine geblockt wurden.
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param mixed $attributes
     * @param boolean $clearErrors
     * @return boolean
     */
    public function validate($attributes = null, $clearErrors = true) {
        $rc = false;
        if (parent::validate($attributes, $clearErrors)) {
            if (UserRole::model()->countByAttributes(array('user_id' => $this->user_id, 'role_id' => 2)) < 1) {
                $this->addError('user_id', 'Kein Lehrer.');
            } else if (Yii::app()->params['allowBlockingAppointments']) {
                if (BlockedAppointment::model()->count($this->countUsedDateAndTimes()) >=
                        Yii::app()->params['appointmentBlocksPerDate'] && Yii::app()->checkAccessNotAdmin('2')) {
                    $this->addError('dateAndTime_id', 'Zuviele Termine berereits geblockt. Maximum liegt bei '
                            . Yii::app()->params['appointmentBlocksPerDate'] . ' pro Elternsprechtag.');
                } else if(Yii::app()->user->checkAccessNotAdmin('2') && Yii::app()->params['allowBlockingOnlyForManagement']) {
                   Yii::app()->user->setFlash('failMsg','Nur die Verwaltung kann Termine blockieren.');
                } 
                else {
                    $rc = true;
                }
            }
        }
        return $rc;
    }

    /**
     * Suchmethode
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return \CActiveDataProvider
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->with = array('user', 'dateAndTime');
        $criteria->together = true;
        $criteria->compare('id', $this->id);
        $criteria->compare('reason', $this->reason, true);
        $criteria->compare('dateAndTime.time', $this->dateAndTime_id, true);
        $criteria->compare('user.lastname', $this->user_id, true);
        $sort = new CSort;
        $sort->attributes = array(
            'defaultOrder' => 'dateAndTime.id DESC',
            'dateAndTime_id' => array(
                'asc' => 'dateAndTime.id',
                'desc' => 'dateAndTime.id desc'),
            'user_id' => array(
                'asc' => 'user.id',
                'desc' => 'user.id desc'),
            'reason' => array(
                'asc' => 'reason',
                'desc' => 'reason desc'),
        );
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 10),
            'sort' => $sort,
        ));
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'Lehrer',
            'dateAndTime_id' => 'Termin',
            'reason' => 'Grund',
        );
    }

}

?>
