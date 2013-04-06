<?php

/**
 * Model für verfügbare Zeiten an einem Elternsprechtag
 */

/** The followings are the available columns in table 'dateAndTime':
 * @property integer $id
 * @property string $time
 * @property integer $date_id
 *
 * The followings are the available model relations:
 * @property Appointment[] $appointments
 * @property Date $date
 */
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

class DateAndTime extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DateTime the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Tabellenname
     * @return string the associated database table name
     */
    public function tableName() {
        return 'dateAndTime';
    }

    /**
     * Regeln für Validierung
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('date_id', 'required'),
            array('date_id', 'numerical', 'integerOnly' => true),
            array('time', 'length', 'max' => 45),
            array('id, time, date_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Relationen ( Appointments HAS_MANY , Date BELONGS_TO)
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'appointments' => array(self::HAS_MANY, 'Appointment', 'dateAndTime_id'),
            'date' => array(self::BELONGS_TO, 'Date', 'date_id'),
        );
    }

    /**
     * Attributlabels
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'time' => 'Zeit',
            'date_id' => 'Datum',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('date_id', $this->date_id);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Gibt Suchkriterien von DateAndTime zurück
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return CDbCriteria Suchkriterien für Autocomplete
     */
    public function searchDateAndTime() {
        $criteria = new CDbCriteria;
        $match = addcslashes($this->time, '%_');
        $criteria->addCondition('time LIKE :match');
        $criteria->params = array(':match' => "$match%");
        $criteria->with = array('date');
        $criteria->select = '*';
        $criteria->limit = 10;
        return $criteria;
    }
    
    /**
     * 
     * Löscht alle Termine von einem DateAndTime
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     */
    public function beforeDelete() {
        $rc = false;
        if(parent::beforeDelete()) {
            Appointment::model()->deleteAllByAttributes(array('dateAndTime_id'=>  $this->id));
            $rc = true;
        }
        return $rc;
    }

}