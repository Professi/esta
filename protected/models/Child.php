<?php

/**
 * Dies ist die Modelklasse fuer Kinder
 */

/**
 * The followings are the available columns in table 'child':
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 *
 * The followings are the available model relations:
 * @property ParentChild[] $parentChildren
 */
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
class Child extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Child the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Tabellenname
     * @return string the associated database table name
     */
    public function tableName() {
        return 'child';
    }

    /**
     * Regeln Validierung
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('firstname, lastname', 'required'),
            array('firstname, lastname', 'length', 'max' => 255),
            array('id, firstname, lastname', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Relation zu ParentChildren
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'parentchildren' => array(self::BELONGS_TO, 'ParentChild', 'child_id'),
        );
    }

    /**
     * Attributlabels
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'firstname' => Yii::t('app', 'Vorname'),
            'lastname' => Yii::t('app', 'Nachname'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('firstname', $this->firstname, true);
        $criteria->compare('lastname', $this->lastname, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}