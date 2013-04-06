<?php

/**
 * Dies ist das Model für Elternsprechtage.
 */

/** The followings are the available columns in table 'date':
 * @property integer $id
 * @property string $date
 * @property string $begin
 * @property string $end
 * @property string $lockAt
 * @property integer $durationPerAppointment
 * The followings are the available model relations:
 * @property Appointment[] $appointments
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
     * Tabellenname
     * @return string the associated database table name
     */
    public function tableName() {
        return 'date';
    }

    /**
     * Regeln für Validierung
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('date, begin, end,lockAt,durationPerAppointment', 'required'),
            array('durationPerAppointment', 'numerical', 'integerOnly' => true, 'min' => Yii::app()->params['minLengthPerAppointment']),
            array('date', 'date', 'format' => 'dd.MM.yyyy'),
            array('begin,end,lockAt', 'date', 'format' => 'H:m'),
            array('durationPerAppointment', 'date', 'format' => 'm'),
            array('id, date, begin, end, durationPerAppointment', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Relationen ( Appointments HAS_MANY )
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
     * Attributlabels
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'date' => 'Datum',
            'begin' => 'Anfang',
            'end' => 'Ende',
            'durationPerAppointment' => 'Dauer eines Termins',
            'lockAt'=>'Letzte Buchung',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
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
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     */
    public function validate($attributes = NULL, $clearErrors = true) {
        $rc = true;
        Yii::trace('Aktuelle Zeit: ' . time(), 'application.models.date');
        Yii::trace('Eingegebenes Datum: ' . strtotime($this->date), 'application.models.date');
        if (parent::validate($attributes, $clearErrors)) {
            Yii::trace('Created by User:' . Yii::app()->user->getId(), 'application.models.date');
            if (strtotime($this->end) <= strtotime($this->begin)) {
                $rc = false;
                $this->addError('end', 'Das Ende darf nicht vor dem Beginn liegen.');
            }
            else if (time() >= strtotime($this->date)) {
                $rc = false;
                $this->addError('date', 'Datum liegt in der Vergangenheit');
            } 
            else if (!is_int((strtotime($this->end)) - (strtotime($this->begin)) / 60 / $this->durationPerAppointment)) {
                $rc = false;
                $this->addError('durationPerAppointment', 'Leider ist es anhand Ihrer Angaben nicht möglich immer gleichlange Termine zu erstellen.');
            }
            else if(strtotime($this->begin) < strtotime($this->lockAt)) {
                $rc = false;
                $this->addError('lockAt','Die Sperrfrist muss vor oder auf dem Anfang liegen.');
            }
        } else {
            $rc = false;
        }
        return $rc;
    }

    /**
     * Erstellt neue DateTimes entsprechend der Elternsprechtagszeiten
     * @return boolean parent::afterSave();
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function afterSave() {
        $diff = (strtotime($this->end) - strtotime($this->begin)) / 60;
        $i = 0;
        while ($diff >= $this->durationPerAppointment) {
            $datetime = new DateAndTime;
            $datetime->date_id = $this->id;
            $datetime->time = date("H:i", (strtotime($this->begin) + ($this->durationPerAppointment * $i) * 60));
            ++$i;
            $diff -= $this->durationPerAppointment;
            $datetime->save();
        }
        return parent::afterSave();
    }

    /**
     * bevor der Elternsprechtag gelöscht wird werden alle DateAndTimes gelöscht
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return type
     */
    public function beforeDelete() {
        DateAndTime::model()->deleteAllByAttributes(array('date_id' => $this->id));
        return parent::beforeDelete();
    }

    /**
     * wandelt das Datum von d.m.Y in Y-m-d um
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean parent::beforeSave
     */
    public function beforeSave() {
        $this->date = date('Y-m-d', strtotime($this->date));
        return parent::beforeSave();
    }

}
