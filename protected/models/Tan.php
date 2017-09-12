<?php

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

/**
 * This is the model class for table "tan".
 * The followings are the available columns in table 'tan':
 * @property integer $tan
 * @property boolean $used
 * The followings are the available model relations:
 * @property Group $group
 * @property DateTime generatedOn
 * @property User generatedBy
 */
class Tan extends CActiveRecord
{
    public $childFirstname;
    public $childLastname;

    /** @var integer Anzahl der TANs die generiert werden sollen */
    public $tan_count = 0;

    /**
     *
     * @var integer ID
     */
    public $id = 0;
    public $group_id = null;
    public $used_by_user_id = null;
    public $generatedOn = null;
    public $generatedBy_id = null;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Tan the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Tabellenname in der Datenbank
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tan';
    }

    public function behaviors()
    {
        $r = array();
        if ($this->isNewRecord) {
            $r = array(
                'CTimestampBehavior' => array(
                    'class' => 'zii.behaviors.CTimestampBehavior',
                    'createAttribute' => 'generatedOn'
            ));
        }
        return $r;
    }

    /**
     * Validierungsregeln
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('tan_count', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => Yii::app()->params['maxTanGen'], 'allowEmpty' => !self::allowParents()),
            array('tan', 'required'),
            array('childFirstname, childLastname', 'length', 'min' => 1, 'allowEmpty' => self::allowParents()),
            array('tan_count,tan,used,group_id,group', 'safe'),
        );
    }

    /**
     * Keine Relationen, liefert ein leeres Array
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
            'child' => array(self::BELONGS_TO, 'Child', 'child_id'),
            'used_by_user' => array(self::BELONGS_TO, 'User', 'used_by_user_id'),
            'generatedBy' => array(self::BELONGS_TO, 'User', 'generatedBy_id'),
        );
    }

    public static function allowParents()
    {
        return Yii::app()->params['allowParentsToManageChilds'];
    }

    /**
     * Attributlabels
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'tan' => 'TAN',
            'used' => Yii::t('app', 'Benutzt'),
            'tan_count' => Yii::t('app', 'Anzahl'),
            'group_id' => Yii::t('app', 'Gruppe'),
            'group' => Yii::t('app', 'Gruppe'),
            'child' => Yii::t('app', 'Schüler'),
            'childFirstname' => Yii::t('app', 'Vorname'),
            'childLastname' => Yii::t('app', 'Nachname'),
            'used_by_user' => Yii::t('app', 'Erziehungsberechtigter'),
            'generatedBy' => Yii::t('app', 'Erzeuger'),
        );
    }

    /**
     * Individuelle Suchcriteria für View
     * @return \CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('tan', $this->tan, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 20),
        ));
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function beforeValidate()
    {
        $rc = parent::beforeValidate();
        if (Yii::app()->params['allowGroups'] && $this->group_id != null) {
            $this->group = Group::model()->findByPk((int) $this->group_id);
        }
        if ($rc && !Yii::app()->params['allowParentsToManageChilds'] &&
                $this->child_id == null) {
            $this->createChild();
        }
        return $rc;
    }

    private function createChild($save = true)
    {
        $child = new Child();
        $child->firstname = $this->childFirstname;
        $child->lastname = $this->childLastname;
        if ($save) {
            $child->save();
        }
        $this->child = $child;
        $this->child_id = $this->child->getPrimaryKey();
    }

    /**
     * Generiert eine Tan
     */
    public function generateTan($save = true)
    {
        if (!self::allowParents()) {
            $this->createChild($save);
        }
        $this->randNumber();
        $this->used = false;
        $this->generatedBy_id = Yii::app()->user->getId();
        if ($save) {
            $this->insert();
        }
    }

    private function randNumber()
    {
        do {
            $sTan = '';
            for ($x = 0; $x < Yii::app()->params['tanSize']; ++$x) {
                $sTan .= rand(0, 9);
            }
            if (Tan::model()->countByAttributes(array('tan' => $sTan)) == 0) {
                $this->tan = $sTan;
                return;
            }
        } while (true);
    }
}
