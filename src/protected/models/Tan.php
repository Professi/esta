<?php
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
/**
 * This is the model class for table "tan".
 *
 * The followings are the available columns in table 'tan':
 * @property integer $tan
 * @property boolean $used
 */
class Tan extends CActiveRecord {

    public $tan_count = 0;
    public $id = 0;
    
    public function getTanCount() {
        return $this->tan_count;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setTanCount($tanCount) {
        if(is_int($tanCount)) {
            $this->tan_count = $tanCount;
        }
    }
    
    public function setId($id) {
        if(is_int($id)) {
            $this->id = $id;
        }
    } 

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Tan the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tan';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            // array('tan_count', 'required'),
            array('tan_count', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => Yii::app()->params['maxTanGen']),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('tan, used', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'tan' => 'Tan',
            'used' => 'Benutzt',
            'tan_count' => 'Anzahl',
        );
    }

    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('tan', $this->tan, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 20),
        ));
    }

}