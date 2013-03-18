<?php

/**
 * This is the model class for table "date".
 *
 * The followings are the available columns in table 'date':
 * @property integer $id
 * @property string $date
 * @property string $begin
 * @property string $end
 * @property integer $durationPerAppointment
 * The followings are the available model relations:
 * @property Appointment[] $appointments
 */

/**   Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 *   This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
class Date extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Date the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'date';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date, begin, end, durationPerAppointment', 'required'),
            array('durationPerAppointment', 'numerical', 'integerOnly' => true),
            array('date', 'date', 'format'=>'dd.MM.yyyy'),
            array('begin,end','date', 'format'=>'H:m'),
            array('durationPerAppointment','date','format'=>'m'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, date, begin, end, durationPerAppointment', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'appointments' => array(self::HAS_MANY, 'Appointment', 'date_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'date' => 'Datum',
            'begin' => 'Anfang',
            'end' => 'Ende',
            'durationPerAppointment' => 'Dauer eines Termins',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('begin', $this->begin, true);
        $criteria->compare('end', $this->end, true);
        $criteria->compare('durationPerAppointment', $this->durationPerAppointment);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Prüft nach der erfolgreichen Validierung ob das Ende vor dem Anfang liegt.
     * @return boolean
     */
    public function beforeValidate() {
        $rc = parent::afterValidate();
        if ($rc) {
            if (strtotime($this->end) <= strtotime($this->begin)) {
                $rc = false;
                Yii::app()->user->setFlash('failMsg', 'Das Ende darf nicht vor dem Beginn liegen.');
            } else if (!is_int($this->end - $this->begin / $this->durationPerAppointment)) {
                $rc = false;
                Yii::app()->user->setFlash('failMsg', 'Leider ist es anhand Ihrer Angaben nicht möglich immer gleichlange Termine zu erstellen.');
            }
        }
        return $rc;
    }

    public function afterSave() {
        $diff = (strtotime($this->end) - strtotime($this->begin))/60;
        $i = 0;
        while ($diff >= $this->durationPerAppointment) {
           $datetime =  new DateAndTime;
           $datetime->date_id = $this->id;
           $datetime->time = date("H:i",(strtotime($this->begin) + ($this->durationPerAppointment * $i)*60));
           ++$i;
           $diff -= $this->durationPerAppointment;
           $datetime->save();
           
        }
        return parent::afterSave();
    }
    
    public function beforeDelete() {
        DateAndTime::model()->deleteAllByAttributes(array('date_id'=>  $this->id));
        return parent::beforeDelete();
    }

}
