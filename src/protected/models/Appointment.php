<?php

/**
 * Die Klasse Appointment ist für die Persistierung von Terminen zuständig.
 */

/** The followings are the available columns in table 'appointment':
 * @property integer $id
 * @property integer $parent_child_id
 * @property string $user_id
 * @property integer $dateAndTime_id
 *
 * The followings are the available model relations:
 * @property DateAndTime $dateAndTime
 * @property ParentChild $parentChild
 * @property User $user
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
class Appointment extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Appointment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Tabellenname
     * @return string the associated database table name
     */
    public function tableName() {
        return 'appointment';
    }

    /**
     * Regeln für die Validierung
     * @return array Regeln
     */
    public function rules() {
        return array(
            array('dateAndTime_id, parent_child_id, user_id', 'required'),
            array('dateAndTime_id, parent_child_id', 'numerical', 'integerOnly' => true),
            array('user_id', 'length', 'max' => 11),
            array('id, dateAndTime_id, parent_child_id, user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Relationen (dateAndTime, parentChild, user)
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'dateAndTime' => array(self::BELONGS_TO, 'DateAndTime', 'dateAndTime_id'),
            'parentChild' => array(self::BELONGS_TO, 'ParentChild', 'parent_child_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * Attributlabels
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'parent_child_id' => 'Eltern',
            'user_id' => 'Lehrer',
            'dateAndTime_id' => 'Datum',
            'time' => 'Zeit',
            'date_id' => 'Datum',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('parent_child_id', $this->parent_child_id);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('dateAndTime_id', $this->dateAndTime_id);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Prüft auf genau die User ID die festgelegt wurde
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return CActiveDataProvider gibt Datensätze mit der user_id aus
     */
    public function customSearch() {
        $criteria = new CDbCriteria();
        $criteria->order = '`dateAndTime_id` ASC';
        $criteria->addCondition(array('user_id=' . $this->user_id));
        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

    /**
     * Prüft ob der Lehrer vorhanden ist, ob der vermeintlich gewählte Lehrer überhaupt die Rolle hat und prüft ob die Elternkindverknüpfung existiert.
     * Prüft ebenfalls ob bereits ein Termin bei diesem Lehrer besteht
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     */
    public function afterValidate() {
        $rc = parent::afterValidate();
        $userRole = UserRole::model()->findByAttributes(array('user_id' => $this->user_id));
        if ($rc && User::model()->countByAttributes(array('id' => $this->user_id)) != 1) {
            $rc = false;
            Yii::app()->user->setFlash('failMsg', 'Sie haben keine gültige Lehrkraft ausgewählt.');
        } else if ($userRole == NULL || $userRole->role_id != 2) {
            $rc = false;
            Yii::app()->user->setFlash('failMsg', 'Der ausgewählte Benutzer ist kein Lehrer.');
        } else if ($rc && Appointment::model()->countByAttributes(array('user_id' => $this->user_id, 'parent_child_id' => $this->parent_child_id)) >= 1) {
            Yii::app()->user->setFlash('failMsg', 'Leider haben Sie bereits einen Termin bei diesem Lehrer gebucht. Daher können Sie keinen weiteren buchen.');
            $rc = false;
        } else if ($rc && ParentChild::model()->countByAttributes(array('id' => $this->parent_child_id)) != '1') {
            $rc = false;
            Yii::app()->user->setFlash('failMsg', 'Sie müssen ein Kind angeben.');
        }

        if ($rc && DateAndTime::model()->countByAttributes(array('dateAndTime_id' => $this->dateAndTime_id)) != '1') {
            $rc = false;
            Yii::app()->user->setFlash('failMsg', 'Der angegebene Termin existiert nicht.');
        }
        if ($rc && ParentChild::model()->countByAttributes(array('parent_child_id' => $this->parent_child_id)) != '1') {
            $rc = false;
            Yii::app()->user->setFlash('failMsg', 'Die angegebene Elternkindverknüpfung existiert nicht.');
        }
        return $rc;
    }

    /**
     * Prüft ob die maximal Anzahl von Terminen überschritten wurde und ob der Benutzer bereits zu dieser Uhrzeit einen Termin hat
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     */
    public function beforeSave() {
        $rc = parent::beforeSave();
        if ($rc && Appointment::model()->countByAttributes(array('dateAndTime_id' => $this->dateAndTime_id)) > 0) {
            $rc = false;
            if (Yii::app()->user->checkAccess('1')) {
                Yii::app()->user->setFlash('failMsg', 'Der Benutzer hat bereits zu dieser Uhrzeit einen Termin gebucht.');
            } else {
                Yii::app()->user->setFlash('failMsg', 'Sie können immer nur einen Termin zur selben Zeit haben.');
            }
        }
        if (!Yii::app()->user->checkAccess('1') && $rc) {
            if (Appointment::model()->countByAttributes(array('parent_child_id' => $this->parent_child_id)) >= Yii::app()->params['maxAppointmentsPerChild']) {
                $rc = false;
                Yii::app()->user->setFlash('failMsg', 'Leider konnte Ihr Termin nicht gebucht haben, da Sie die maximale Anzahl von '
                        . Yii::app()->params['maxAppointmentsPerChild'] . 'überschritten haben.');
                $this->addError('parent_child_id', 'Sie haben die maximal Anzahl von Terminen überschritten.');
            }
        }
        if ($rc && Appointment::model()->countByAttributes(array('user_id' => $this->user_id, 'parent_child_id' => $this->parent_child_id)) >= '1') {
            $rc = false;
            Yii::app()->user->setFlash('failMsg', 'Sie können nur einen Termin bei diesem Lehrer pro Kind buchen.');
        }
        if ($rc) {
            Yii::app()->user->setFlash('success', 'Ihr Termin wurde erfolgreich gebucht.');
        }

        return $rc;
    }

    /**
     * Prüft ob der Benutzer die Berechtigung zum löschen von dem Termin hat
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     */
    public function beforeDelete() {
        $rc = parent::beforeDelete();
        if ($rc && Yii::app()->user->checkAccessNotAdmin('2')) {
            if ($this->user_id != Yii::app()->user->getId()) {
                $rc = false;
            }
        } else if ($rc && Yii::app()->user->checkAccessNotAdmin('3')) {
            if ($this->parentChild->user_id != Yii::app()->user->id) {
                $rc = false;
            }
        }
        if (!$rc) {
            Yii::app()->user->setFlash('failMsg', 'Keine Berechtigung um diesen Termin zu löschen.');
        }
        return $rc;
    }

    /**
     * Nach dem der Termin gelöscht wurde, wird eine Infomail an die Eltern versendet.
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function afterDelete() {
        $rc = parent::afterDelete();
        if ($rc) {
            $mail = new Mail;
            $mail->sendAppointmentDeleted($this->parentChild->user->email, $this->user, $this->dateAndTime->time, $this->parentChild->child, $this->dateAndTime->date->date);
        }
    }

}
