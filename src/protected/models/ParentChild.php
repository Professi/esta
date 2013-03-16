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
 * This is the model class for table "parent_child".
 *
 * The followings are the available columns in table 'parent_child':
 * @property integer $id
 * @property integer $user_id
 * @property integer $child_id
 *
 * The followings are the available model relations:
 * @property Appointment[] $appointments
 * @property User $user
 * @property Child $child
 */
class ParentChild extends CActiveRecord {

    public $childFirstName;
    public $childLastName;

    /**
     * 
     * 
     * @return boolean Return der Elternmethode
     */
    
    public function beforeDelete() {
        $rc = false;
       if(Yii::app()->user->checkAccess('3') && !Yii::app()->user->isAdmin()) {
           if(ParentChild::model()->countByAttributes(array('user_id'=> Yii::app()->user->getId()) > 1)) {
               $rc = parent::beforeDelete();
           }
       }
        return $rc;
    }

    /**
     * @author Christan Ehringfeld <c.ehringfeld@t-online.de>
     * Prueft ob ein Benutzer die Rolle 3 hat und ob er nicht Admin ist. 
     * Falls er dies erfüllt, wird seine eigene Userid eingefügt.
     * @return boolean Return der Elternmethode
     * 
     * 
     */
    public function beforeValidate() {
        if(Yii::app()->user->checkAccess('3') && !Yii::app()->user->isAdmin()) {
            $this->user_id = Yii::app()->user->getId();
        }
        return parent::beforeValidate();
    }

        /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean parent::beforeSave()
     * 
     */
    public function beforeSave() {
        $child = Child::model()->findByAttributes(array('firstname' => $this->childFirstName, 'lastname' => $this->childLastName));
        if($child === NULL) {
            $child = new Child;
            $child->firstname = $this->childFirstName;
            $child->lastname = $this->childLastName;
            $child->save();
           $child->id = Child::model()->findByAttributes(array('firstname'=>  $this->childFirstName, 'lastname' => $this->childLastName))->id; 
        }
        $this->child_id = $child->id;
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ParentChild the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'parent_child';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('childFirstName, childLastName', 'required'),
            array('child_id', 'numerical', 'integerOnly' => true),
            array('user_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, child_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'appointments' => array(self::HAS_MANY, 'Appointment', 'parent_child_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'child' => array(self::BELONGS_TO, 'Child', 'child_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'Benutzer',
            'child_id' => 'Kind',
            'childFirstName' => 'Vorname Ihres Kindes',
            'childLastName' => 'Nachname Ihres Kindes',
            'class' => 'Klasse',
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
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('child_id', $this->child_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}