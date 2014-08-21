<?php

/**
 * This is the model class for table "parent_child".
 */

/** The followings are the available columns in table 'parent_child':
 * @property integer $id
 * @property integer $user_id
 * @property integer $child_id
 *
 * The followings are the available model relations:
 * @property Appointment[] $appointments
 * @property User $user
 * @property Child $child
 */
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
class ParentChild extends CActiveRecord {

    /** @var string KinderVorname */
    public $childFirstName;

    /** @var string KinderNachname */
    public $childLastName;

    /**
     * 
     * Eltern könnten nur ihre eigenen Verknüpfungen löschen und Admins können diese löschen
     * @author Christan Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean Return der Elternmethode
     */
    public function beforeDelete() {
        $rc = parent::beforeDelete();
        if (Yii::app()->user->checkAccess(MANAGEMENT) || $this->user_id == Yii::app()->user->getId()) {
            if ($rc) {
                Appointment::model()->deleteAllByAttributes(array('parent_child_id' => $this->id));
            }
        } else {
            /** @todo $this->throw... ? */
            throw new CHttpException(403, Yii::t('app', 'Keine Berechtigung.'));
        }
        return $rc;
    }

    /**
     * Prueft ob ein Benutzer die Rolle 3 hat und ob er nicht Admin ist. 
     * Falls er dies erfüllt, wird seine eigene Userid eingefügt.
     * @author Christan Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean Return der Elternmethode
     */
    public function beforeValidate() {
        if (Yii::app()->user->checkAccess(PARENTS) && !Yii::app()->user->isAdmin()) {
            $this->user_id = Yii::app()->user->getId();
        }
        return parent::beforeValidate();
    }

    /**
     * Bevor die Verknüpfung angelegt wird, wird vorher ein Child erzeugt
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean parent::beforeSave()
     */
    public function beforeSave() {
        $rc = parent::beforeSave();
        if ($rc) {
            $childCheck = Child::model()->findByAttributes(array('firstname' => $this->childFirstName, 'lastname' => $this->childLastName), array('select' => 'id'));
            if ($childCheck != null) {
                if (ParentChild::model()->countByAttributes(array('child_id' => $childCheck->id, 'user_id' => $this->user_id)) >= '1') {
                    $rc = false;
                    Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Kind wurde bereits eingetragen.'));
                }
            }
            if ($rc && $this->child_id == null) {
                $child = new Child;
                $child->firstname = ucfirst($this->childFirstName);
                $child->lastname = ucfirst($this->childLastName);
                if ($child->save()) {
                    $child->id = Child::model()->findByAttributes(array('firstname' => $child->firstname, 'lastname' => $child->lastname))->getPrimaryKey();
                    $this->child_id = $child->getPrimaryKey();
                }
            }
        }
        return $rc;
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
     * Tabellenname
     * @return string the associated database table name
     */
    public function tableName() {
        return 'parent_child';
    }

    /**
     * Validierungsregeln
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('user_id', 'required'),
            array('child_id', 'numerical', 'integerOnly' => true),
            array('user_id', 'length', 'max' => 11),
            array('childFirstName, childLastName', 'length', 'min' => 1, 'allowEmpty' => $this->child_id != null),
            array('childFirstName,childLastName,child_id', 'length', 'max' => 255),
            array('id, user_id, child_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Relationen mit Appointment, User und Child
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'appointments' => array(self::HAS_MANY, 'Appointment', 'parent_child_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'child' => array(self::BELONGS_TO, 'Child', 'child_id'),
        );
    }

    /**
     * Attributlabels
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => Yii::t('app', 'Erziehungsberechtigte/r'),
            'child_id' => Yii::t('app', 'Kind'),
            'childFirstName' => Yii::t('app', 'Vorname Ihres Kindes'),
            'childLastName' => Yii::t('app', 'Nachname Ihres Kindes'),
            'class' => Yii::t('app', 'Klasse'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->with = array('user', 'child');
        $criteria->together = true;
        $criteria->compare('id', $this->id);
        $criteria->compare('user.lastname', $this->user_id, true);
        $criteria->compare('child.lastname', $this->child_id, true);
        $sort = new CSort;
        $sort->attributes = array(
            'defaultOrder' => 'user.lastname DESC',
            'user_id' => array(
                'asc' => 'user.lastname',
                'desc' => 'user.lastname desc'),
            'child_id' => array(
                'asc' => 'child.lastname',
                'desc' => 'child.lastname desc'),
        );
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 10),
            'sort' => $sort,
        ));
    }

    /**
     * Gibt Suchkriterien von ParentChild zurück
     * @author Christan Ehringfeld <c.ehringfeld@t-online.de>
     * @return CDbCriteria Suchkriterien für Autocomplete
     * @param string $lastname Nachname eines Erziehungsberechtigten
     */
    public function searchParentChild($lastname, $with = array('user', 'child')) {
        $criteria = new CDbCriteria;
        $match = addcslashes(ucfirst($lastname), '%_');
        $criteria->addCondition('user.lastname LIKE :match');
        $criteria->params = array(':match' => "$match%");
        $criteria->with = $with;
        $criteria->select = '*';
        $criteria->limit = 10;
        return $criteria;
    }

    /**
     * Gibt ein Array mit höchstens 10 IDs zurück, die mit $lastname anfangen
     * @param string $lastname Nachname der zu suchenden Eltern
     * @return array passende IDs
     */
    public function searchParentId($lastname = '') {
        $a_data = $this->findAll($this->searchParentChild($lastname, array('user')));
        foreach ($a_data as $key => $value) {
            $a_data[$key] = $value->user->getPrimaryKey();
        }
        return $a_data;
    }

    /**
     * Prüft ob der angegebene Benutzer überhaupt existiert
     * @author Christan Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean 
     */
    public function afterValidate() {
        $rc = parent::afterValidate();
        if ($rc && User::model()->countByAttributes(array('user_id' => $this->user_id)) != '1') {
            $rc = false;
            $this->addError('user_id', Yii::t('app', 'Der angegebene Benutzer existiert nicht.'));
        }
        if ($rc && ParentChild::model()->countByAttributes(array('user_id' => $this->user_id)) > Yii::app()->params['maxChild'] && Yii::app()->params['allowParentsToManageChilds']) {
            $rc = false;
            $this->addError('child_id', Yii::t('app', 'Maximale Kinderanzahl erreicht.'));
            Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Sie haben die Anzahl der maximal eintragbaren Kinder überschritten.'));
        }
        return $rc;
    }

}