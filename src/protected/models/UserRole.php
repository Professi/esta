<?php

/**
 * This is the model class for table "user_role".
 */

/** The followings are the available columns in table 'user_role':
 * @property integer $id
 * @property string $role_id
 * @property string $user_id
 *
 * The followings are the available model relations:
 * @property Role $role
 * @property User $user
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
class UserRole extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserRole the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Tabellenname in der Datenbank
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_role';
    }

    /**
     * Regeln für Validierung
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('role_id, user_id', 'required'),
            array('role_id, user_id', 'length', 'max' => 11),
            array('id, role_id, user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Relationen mit anderen Models / DB Tabellen
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'role' => array(self::BELONGS_TO, 'Role', 'role_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * Attributlabels
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'role_id' => Yii::t('app', 'RollenID'),
            'user_id' => Yii::t('app', 'BenutzerID'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('role_id', $this->role_id, true);
        $criteria->compare('user_id', $this->user_id, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}