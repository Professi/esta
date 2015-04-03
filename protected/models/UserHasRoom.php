<?php

/* Copyright (C) 2015  Christian Ehringfeld, David Mock
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
 * This is the model class for table "user_has_room".
 *
 * The followings are the available columns in table 'user_has_room':
 * @property integer $id
 * @property integer $user_id
 * @property integer $room_id
 * @property integer $date_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Room $room
 * @property Date $date
 * 
 * @author Christian Ehringfeld <c.ehringfeld[at]t-online.de>
 */
class UserHasRoom extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_has_room';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, user_id, room_id', 'required'),
            array('id, user_id, room_id, date_id', 'numerical', 'integerOnly' => true),
            array('user_id', 'exist', 'attributeName' => 'id', 'className' => 'User'),
            array('room_id', 'exist', 'attributeName' => 'id', 'className' => 'Room'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, room_id, date_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'room' => array(self::BELONGS_TO, 'Room', 'room_id'),
            'date' => array(self::BELONGS_TO, 'Date', 'date_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => Yii::t('app', 'User'),
            'room_id' => Yii::t('app', 'Room'),
            'date_id' => Yii::t('app', 'Date'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('room_id', $this->room_id);
        $criteria->compare('date_id', $this->date_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

//    public function search() {
//        $criteria = new CDbCriteria;
//        $criteria->compare('id', $this->id);
//        $criteria->with = array('room', 'user', 'date');
//        $criteria->together = true;
//        $criteria->compare('room', $this->room, true);
//        $criteria->compare('date', $this->date, true);
//        $criteria->compare('user', $this->user, true);
//        $sort = new CSort();
//        $sort->defaultOrder = 'id asc';
//        $sort->attributes = array(
//            'id' => array(
//                'asc' => 'id',
//                'desc' => 'id desc'),
//            'room' => array(
//                'asc' => 'room.name',
//                'desc' => 'room.name desc'),
//            'date' => array(
//                'asc' => 'date.title',
//                'desc' => 'date.title desc'),
//            'user' => array(
//                'asc' => 'user.lastname',
//                'desc' => 'user.lastname desc'),
//        );
//        return new CActiveDataProvider($this, array(
//            'criteria' => $criteria,
//            'sort' => $sort,
//        ));
//    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserHasRoom the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
