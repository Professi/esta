<?php

/**
 * This is the model class for table "tan".
 */

/** The followings are the available columns in table 'tan':
 * @property integer $tan
 * @property boolean $used
 * The followings are the available model relations:
 * @property Group $group
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
class Tan extends CActiveRecord {

    /** @var integer Anzahl der TANs die generiert werden sollen */
    public $tan_count = 0;

    /**
     *
     * @var integer ID 
     */
    public $id = 0;
    public $group_id = null;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Tan the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Tabellenname in der Datenbank
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tan';
    }

    /**
     * Validierungsregeln
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tan_count', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => Yii::app()->params['maxTanGen']),
            array('tan, used', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Keine Relationen, liefert ein leeres Array
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
        );
    }

    /**
     * Attributlabels
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'tan' => 'Tan',
            'used' => 'Benutzt',
            'tan_count' => 'Anzahl',
            'group_id' => 'Gruppe',
            'group' => 'Gruppe',
        );
    }

    /**
     * Individuelle Suchcriteria für View
     * @return \CActiveDataProvider 
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('tan', $this->tan, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 20),
        ));
    }

    public function beforeSave() {
        $rc = parent::beforeSave();
        if ($rc && Yii::app()->params['allowGroups']) {
            if (!is_int($this->group_id)) {
                $this->group_id = null;
            }
        }
        return $rc;
    }

}