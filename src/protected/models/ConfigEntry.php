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

class ConfigEntry extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Date the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public static function createEntry($key,$value) {
        $entry = new ConfigEntry();
        $entry->key = $key;
        $entry->value = $value;
        return $entry;
    }
    
    /**
     * Tabellenname
     * @return string the associated database table name
     */
    public function tableName() {
        return 'configs';
    }

    /**
     * Regeln für Validierung
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('key,value', 'required'),
            array('key,value', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Relationen ( Appointments HAS_MANY )
     * @return array relational rules.
     */
    public function relations() {
        return array();
    }

    /**
     * Attributlabels
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'key' => Yii::t('app', 'Schl&uuml;ssel'),
            'value' => Yii::t('app', 'Wert'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('key', $this->key);
        $criteria->compare('value', $this->value, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

?>