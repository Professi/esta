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
 */
class UserHasRoom extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user_has_room';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('user_id, room_id, date_id', 'required'),
            array('id, user_id, room_id, date_id', 'numerical', 'integerOnly' => true),
            array('user_id', 'exist', 'attributeName' => 'id', 'className' => 'User'),
            array('room_id', 'exist', 'attributeName' => 'id', 'className' => 'Room'),
            array('date_id', 'validateDateAndRoom'),
            array('id, user_id, room_id, date_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
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
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => Yii::t('app', 'Lehrer'),
            'room_id' => Yii::t('app', 'Raum'),
            'date_id' => Yii::t('app', 'Elternsprechtag'),
        );
    }

    public function validateDateAndRoom($attribute, $params)
    {
        $u = UserHasRoom::model()->findByAttributes(array('date_id' => $this->date_id, 'room_id' => $this->room_id));
        if (is_null($u) || ($u->user_id == $this->user_id && $u->date_id == $this->date_id)) {
            return true;
        }
        $this->addError('room_id', Yii::t('app', 'Raum wurde an diesem Elternsprechtag bereits vergeben'));
        return false;
    }

    public function altSearch()
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('room', 'date');
        $criteria->together = true;
        $criteria->compare('user_id', $this->user_id, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => array(
                    'dateAndTime_id' => CSort::SORT_ASC,
                ),
                'multiSort' => true,
            )
        ));
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('room', 'user' => array('select' => array('id', 'firstname', 'lastname')));
        $criteria->together = true;
        if ($this->room_id != '') {
            $criteria->compare('room.name', $this->room_id, true);
        }
        $criteria->compare('date_id', $this->date_id, false);
        $criteria->compare('user.lastname', ucfirst($this->user_id), true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => array(
                    'user.lastname' => CSort::SORT_ASC,
                    'dateAndTime_id' => CSort::SORT_ASC,
                ),
                'multiSort' => true,
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserHasRoom the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
