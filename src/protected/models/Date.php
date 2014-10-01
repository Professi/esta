<?php

/* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
/**
 * Dies ist das Model für Elternsprechtage.
 */

/** The followings are the available columns in table 'date':
 * @property integer $id
 * @property string $title
 * @property string $date
 * @property string $begin
 * @property string $end
 * @property string $lockAt
 * @property integer $durationPerAppointment
 * The followings are the available model relations:
 * @property Group[] $groups
 * @property Appointment[] $appointments
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
            array('lockAt', 'date', 'format' => self::getDateTimeFormat()),
            array('date', 'date', 'format' => Yii::app()->locale->getDateFormat(Date::getDateFormat())),
            array('begin, end', 'date', 'format' => 'H:m'),
            array('durationPerAppointment', 'date', 'format' => 'm'),
            array('date, begin, end, durationPerAppointment,id,groups,title,lockAt', 'safe'),
        );
    }

    /**
     * Relationen ( Appointments HAS_MANY )
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'groups' => array(self::MANY_MANY, 'Group', 'date_has_group(date_id,group_id)'),
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
            'date' => Yii::t('app', 'Datum'),
            'begin' => Yii::t('app', 'Anfang'),
            'end' => Yii::t('app', 'Ende'),
            'durationPerAppointment' => Yii::t('app', 'Dauer eines Termins'),
            'lockAt' => Yii::t('app', 'Letzte Buchung'),
            'groups' => Yii::t('app', 'Gruppen'),
            'title' => Yii::t('app', 'Titel'),
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
        $criteria->compare('durationPerAppointment', $this->durationPerAppointment, true);
        $criteria->compare('title', $this->title, true);
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
        if (parent::validate($attributes, $clearErrors)) {
            if (strtotime($this->end) <= strtotime($this->begin)) {
                $rc = false;
                $this->addError('end', Yii::t('app', 'Das Ende darf nicht vor dem Beginn liegen.'));
            }
            if (time() >= strtotime($this->date)) {
                $rc = false;
                $this->addError('date', Yii::t('app', 'Datum liegt in der Vergangenheit'));
            }
            if (!is_numeric((strtotime($this->end) - strtotime($this->begin)) / 60 / $this->durationPerAppointment)) {
                $rc = false;
                $this->addError('durationPerAppointment', Yii::t('app', 'Leider ist es anhand Ihrer Angaben nicht möglich immer gleichlange Termine zu erstellen.'));
            }
            if (Date::parseDateTime($this->date, $this->begin, true) < Date::parseDateTime($this->lockAt)) {
                $rc = false;
                $this->addError('lockAt', Yii::t('app', 'Die Sperrfrist muss vor oder auf dem Anfang liegen.'));
            }
        } else {
            $rc = false;
        }
        if ($rc) {
            $this->lockAt = strtotime($this->lockAt);
        }
        return $rc;
    }

    public static function parseDateTime($date, $begin = false, $simple = false) {
        return CDateTimeParser::parse($date . ($begin != false ? ' ' . $begin : ''), ($simple ? self::getSimpleDateTimeFormat() : self::getDateTimeFormat()));
    }

    public static function getDateTimeFormat() {
        return Yii::app()->locale->getDateFormat(Date::getDateFormat()) . ' ' .
                Yii::app()->locale->getTimeFormat('short');
    }

    public static function getSimpleDateTimeFormat() {
        return Yii::app()->locale->getDateFormat(Date::getDateFormat()) . ' ' . 'H:m';
    }

     private static function getDateFormat() {
        return Yii::app()->language == 'de' ? 'medium' : 'short';
    }
    
    /**
     * Erstellt neue DateTimes entsprechend der Elternsprechtagszeiten
     * @return boolean parent::afterSave();
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function afterSave() {
        if ($this->isNewRecord) {
            $diff = (strtotime($this->end) - strtotime($this->begin)) / 60;
            $i = 0;
            while ($diff >= $this->durationPerAppointment) {
                $datetime = new DateAndTime;
                $datetime->date_id = $this->getPrimaryKey();
                $datetime->time = date("H:i", (strtotime($this->begin) + ($this->durationPerAppointment * $i) * 60));
                ++$i;
                $diff -= $this->durationPerAppointment;
                $datetime->save();
            }
            if (Yii::app()->params['allowGroups'] && !empty($this->groups)) {
                foreach ($this->groups as $group) {
                    $this->createDateHasGroup($group);
                }
            }
        } else {
            if (Yii::app()->params['allowGroups']) {
                DateHasGroup::model()->deleteAllByAttributes(array('date_id' => $this->id));
                if (!empty($this->groups)) {
                    foreach ($this->groups as $group) {
                        if (DateHasGroup::model()->countByAttributes(array('date_id' => $this->id, 'group_id' => $group)) == '0') {
                            $this->createDateHasGroup($group);
                        }
                    }
                }
            }
        }
        return parent::afterSave();
    }

    /**
     * Creates a group for this date with group_id
     * @param integer $group
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function createDateHasGroup($group) {
        $dateHasGroup = new DateHasGroup();
        $dateHasGroup->date_id = $this->getPrimaryKey();
        $dateHasGroup->group_id = $group;
        $dateHasGroup->save();
    }

    /**
     * bevor der Elternsprechtag gelöscht wird werden alle DateAndTimes gelöscht
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return type
     */
    public function beforeDelete() {
        $a_dateTimes = DateAndTime::model()->findAllByAttributes(array('date_id' => $this->id));
        if (!empty($a_dateTimes)) {
            foreach ($a_dateTimes as $dateTime) {
                Appointment::model()->deleteAllByAttributes(array('dateAndTime_id' => $dateTime->id));
                $dateTime->delete();
            }
        }
        if (!empty($this->groups)) {
            DateHasGroup::model()->deleteAllByAttributes(array('date_id' => $this->id));
        }

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

    /**
     * Prüft ob eine Gruppe null ist und wenn nicht wird der Gruppenname zurückgegeben
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param Group $group
     * @return String
     */
    private function getGroupname($group) {
        $rc = '';
        if (!is_null($group)) {
            $rc = $group->groupname;
        }
        return $rc;
    }

    /**
     * Liefert alle Gruppennamen in einem String
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return string
     */
    public function getGroupnames() {
        $rc = "";
        $first = true;
        if (!empty($this->groups)) {
            foreach ($this->groups as $group) {
                if ($first) {
                    $rc .= $this->getGroupname($group);
                    $first = false;
                } else {
                    $rc .= "," . $this->getGroupname($group);
                }
            }
        }
        return $rc;
    }

    /**
     * Criteria to get Date with Groups
     * @param integer $dateMax
     * @return \CDbCriteria
     */
    public static function criteriaForDateWithGroups($dateMax) {
        $criteria = new CDbCriteria();
        $criteria->with = array('groups');
        $criteria->together = true;
        $criteria->limit = $dateMax;
        $criteria->order = 'date ASC';
        $groups = Yii::app()->user->getGroups();
        $params = array();
        if (!empty($groups) && is_array($groups)) {
            $i = 0;
            foreach ($groups as $group) {
                $criteria->addCondition('groups.id =:group' . $i, 'OR');
                $params[':group' . $i] = $group->id;
                $i++;
            }
        }
        $criteria->addCondition('groups.id IS NULL', 'OR');
        $criteria->addCondition('date >=:date', 'AND');
        $params[':date'] = date('Y-m-d', time());
        $criteria->params = $params;
        return $criteria;
    }

    protected function beforeValidate() {
        $rc = parent::beforeValidate();
        if (!empty($this->date)) {
            $this->date = Yii::app()->dateFormatter->formatDateTime($this->date, Date::getDateFormat(), null);
        }
        if (!empty($this->lockAt)) {
            $this->lockAt = Yii::app()->dateFormatter->formatDateTime($this->lockAt, Date::getDateFormat(), "short");
        }
        return $rc;
    }

}
