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
    public $used_by_user_id = null;
    public $childFirstname;
    public $childLastname;

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
        return array(
            array('tan_count', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => Yii::app()->params['maxTanGen'], 'allowEmpty' => !self::allowParents()),
            array('childFirstname,childLastname', 'length', 'min' => 1, 'allowEmpty' => self::allowParents()),
            array('tan, used,group_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * Keine Relationen, liefert ein leeres Array
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
            'child' => array(self::BELONGS_TO, 'Child', 'child_id'),
            'used_by_user' => array(self::BELONGS_TO, 'User', 'used_by_user_id'),
        );
    }

    public static function allowParents() {
        return Yii::app()->params['allowParentsToManageChilds'];
    }

    /**
     * Attributlabels
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'tan' => 'TAN',
            'used' => 'Benutzt',
            'tan_count' => 'Anzahl',
            'group_id' => 'Gruppe',
            'group' => 'Gruppe',
            'child' => 'Schüler',
            'childFirstname' => 'Vorname',
            'childLastname' => 'Nachname',
            'used_by_user' => 'Erziehungsberechtigter',
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

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de> 
     * @return type
     */
    public function beforeSave() {
        $rc = parent::beforeSave();
        if ($rc) {
            if (Yii::app()->params['allowGroups']) {
                $this->isIntElseNull($this->group_id);
            }
        }
        return $rc;
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de> 
     */
    public function beforeValidate() {
        $rc = parent::beforeValidate();
        if ($rc && !Yii::app()->params['allowParentsToManageChilds'] &&
                $this->child_id == null) {
            $this->createChild();
        }
        return $rc;
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de> 
     * @param null $var
     */
    private function isIntElseNull(&$var) {
        if ($var != null && !is_int($var)) {
            $var = null;
        }
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de> 
     * @return type
     */
    private function createChild($save = true) {
        $child = new Child();
        $child->firstname = $this->childFirstname;
        $child->lastname = $this->childLastname;
        if ($save && $child->save()) {
            $this->child = $child;
            $this->child_id = $child->getPrimaryKey();
        } else {
            $this->child = $child;
        }
    }

    /**
     * Generiert n-TANs
     * @param integer $count Anzahl der zu generierenden TAN's
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function generateTan($save = true) {
        if (!self::allowParents()) {
            $this->createChild($save);
        }
        $this->tan = $this->randNumber();
        $this->used = false;
        if($save) {
        $this->insert();
        }
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de> 
     * @return string
     */
    private function randNumber() {
        $break = true;
        do {
            $sTan = '';
            for ($x = 0; $x < Yii::app()->params['tanSize']; ++$x) {
                $sTan .= rand(0, 9);
            }
            if (strlen($sTan) == Yii::app()->params['tanSize'] && Tan::model()->countByAttributes(array('tan' => $sTan)) == '0') {
                $this->tan = $sTan;
                $break = false;
            }
        } while ($break);
        return $sTan;
    }

}