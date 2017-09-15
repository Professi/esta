<?php

/** The followings are the available columns in table 'date':
 * @property integer $id
 * The followings are the available model relations:
 * @property Group $group
 * @property User $user
  /* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
class UserHasGroup extends CActiveRecord
{
    public $userrole;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Date the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Tabellenname
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user_has_group';
    }

    /**
     * Regeln für Validierung
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('user_id,group_id', 'required'),
            array('user_id', 'exist', 'attributeName' => 'id', 'className' => 'User'),
            array('group_id', 'exist', 'attributeName' => 'id', 'className' => 'Group'),
            array('user_id,group_id', 'numerical', 'integerOnly' => true),
        );
    }

    /**
     * Relationen mit Appointment, User und Child
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
        );
    }

    /**
     * Attributlabels
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user' => Yii::t('app', 'Benutzer'),
            'group' => Yii::t('app', 'Gruppe'),
        );
    }

    /**
     * Search method for UserHasGroup
     * @return \CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('group', 'user');
        $criteria->together = true;
        $criteria->compare('group', $this->group, true);
        $criteria->compare('user', $this->user, true);
        $criteria->compare('userrole', $this->userrole, false);
        $sort = new CSort();
        $sort->defaultOrder = 'user.role desc';
        $sort->attributes = array(
            'userrole' => array(
                'asc' => 'user.role',
                'desc' => 'user.role desc'),
            'group' => array(
                'asc' => 'group.groupname',
                'desc' => 'group.groupname desc'),
            'user' => array(
                'asc' => 'user.lastname',
                'desc' => 'user.lastname desc'),
        );
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }
}
