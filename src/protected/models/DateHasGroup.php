<?php

/**
 * Dies ist das Model für Date Has Group.
 */

/** The followings are the available columns in table 'date':
 * @property integer $id
 * The followings are the available model relations:
 * @property Group $group
 * @property Date $date 
  /* Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
class DateHasGroup extends CActiveRecord {

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
        return 'date_has_group';
    }

    /**
     * Regeln für Validierung
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('date_id,group_id', 'required'),
            array('date_id', 'exist', 'attributeName' => 'id', 'className' => 'Date'),
            array('group_id', 'exist', 'attributeName' => 'id', 'className' => 'Group'),
            array('date_id,group_id', 'numerical', 'integerOnly' => true),
        );
    }

    /**
     * Relationen mit Appointment, User und Child
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'date' => array(self::BELONGS_TO, 'Date', 'date_id'),
            'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
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
            'group' => 'Gruppe',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
//        $criteria->with = array('group', 'date');
//                $criteria->select = array('*');
//        $criteria->together = true;
        $criteria->compare('group', $this->group, true);
        $criteria->compare('date', $this->date, true);
        $sort = new CSort();
        $sort->attributes = array(
            'defaultOrder' => 'id ASC',
            'id' => array(
                'asc' => 'id',
                'desc' => 'id desc'),
            'group_id' => array(
                'asc' => 'group.groupname',
                'desc' => 'group.groupname desc'),
            'date' => array(
                'asc' => 'date.date',
                'desc' => 'date.date desc'),
        );
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

}

?>
