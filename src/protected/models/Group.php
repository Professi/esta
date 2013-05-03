<?php

/**
 * Dies ist das Model für Gruppen.
 */

/** The followings are the available columns in table 'date':
 * @property integer $id
 * @property string $groupname
 * The followings are the available model relations:
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

class Group extends CActiveRecord {

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
        return 'group';
    }

    /**
     * Regeln für Validierung
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('groupname', 'required'),
            array('groupname', 'length', 'max' => 10, 'min' => 1),
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
            'groupname' => 'Gruppenname',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('groupname', $this->groupname, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Liefert alle Gruppen zurück
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param integer $max Limit an Gruppen
     * @return array 
     */
    public function getAllGroups($sort = "") {
        $a_result = Group::model()->findAll(array('order'=>'`groupname` '+$sort));
        $a_temp = null;
        if (!empty($a_result)) {
            foreach ($a_result as $object) {
                $a_temp[$object->id] = $object->groupname;
            }
        }
        return $a_temp;
    }

}
?>
