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
 * Die Klasse Appointment ist für die Persistierung von Terminen zuständig.
 * The followings are the available columns in table 'appointment':
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
            array('user_id,dateAndTime_id,parent_child_id', 'length', 'max' => 255),
            array('id, dateAndTime_id, parent_child_id, user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Relationen (dateAndTime, parentChild, user)
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'dateandtime' => array(self::BELONGS_TO, 'DateAndTime', 'dateAndTime_id'),
            'parentchild' => array(self::BELONGS_TO, 'ParentChild', 'parent_child_id'),
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
            'parent_child_id' => Yii::t('app', 'Erziehungsberechtigte/r'),
            'user_id' => Yii::t('app', 'Lehrer'),
            'dateAndTime_id' => Yii::t('app', 'Termin'),
            'time' => Yii::t('app', 'Zeit'),
            'date_id' => Yii::t('app', 'Datum'),
        );
    }

    public static function getAllAppointments() {
        $criteria = new CDbCriteria();
        $criteria->order = '`dateAndTime_id` ASC';
        $pC = ParentChild::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
        if ($pC != null) {
            foreach ($pC as $record) {
                $criteria->addCondition(array('parent_child_id=' . $record->id), 'OR');
            }
        } else {
            $criteria->addCondition(array('parent_child_id' => '"impossible"'));
        }
        return new CActiveDataProvider('Appointment', array(
            'criteria' => $criteria));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->with = array('parentchild' => array('with' => array('user' => array('alias' => 'pc_user', 'select' => array('id', 'firstname', 'lastname')))), 'dateandtime', 'user' => array('select' => array('id', 'firstname', 'lastname')));
        $criteria->together = true;
        if ($this->parent_child_id != '') {
            $criteria->compare('parentchild.user_id', ParentChild::model()->searchParentID($this->parent_child_id), true);
        }
        if ($this->dateAndTime_id != null) {
            $criteria->addCondition('dateandtime.time LIKE time(:time)');
            $criteria->params = array('time' => $this->dateAndTime_id);
        }
        $criteria->compare('user.lastname', $this->user_id, true);
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
        $criteria->addCondition(array('user_id=:user_id'));
        $criteria->params = array(':user_id' => $this->user_id);
        $sort = new CSort;
        $sort->defaultOrder = 'dateAndTime_id desc';
        $sort->attributes = array(
            'dateAndTime_id' => array(
                'asc' => 'dateandtime.id',
                'desc' => 'dateandtime.id desc'),
            'user_id' => array(
                'asc' => 'user.lastname',
                'desc' => 'user.lastname desc'),
            'reason' => array(
                'asc' => 'reason',
                'desc' => 'reason desc'),
        );
        return new CActiveDataProvider($this, array('criteria' => $criteria,
            'sort' => $sort));
    }

    /**
     * Prüft ob ein EST noch gültig ist.
     * @param array $attributes
     * @param boolean $clearErrors
     * @return boolean
     */
    public function validate($attributes = null, $clearErrors = true) {
        $rc = true;
        if (parent::validate($attributes, $clearErrors)) {
            $date = $this->dateandtime->date;
            if (Yii::app()->user->checkAccessNotAdmin(PARENTS)) {
                if ($date->lockAt < time()) {
                    $rc = false;
                    Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Sie können für diesen Tag keine Termine mehr buchen.'));
                }
            } else if (!Yii::app()->user->isGuest() && time() <= $date->date) {
                Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Dieser Elternsprechtag ist bereits vorbei.'));
                $rc = false;
                $this->addError('date', Yii::t('app', 'Elternsprechtag bereits vorrüber.'));
            }
        } else {
            $rc = false;
        }
        return $rc;
    }

    /**
     * Prüft ob der Lehrer vorhanden ist, ob der vermeintlich gewählte Lehrer überhaupt die Rolle hat und prüft ob die Elternkindverknüpfung existiert.
     * Prüft ebenfalls ob bereits ein Termin bei diesem Lehrer besteht
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     */
    public function afterValidate() {
        $rc = parent::afterValidate();
        if ($rc && User::model()->countByAttributes(array('role' => 2, 'id' => $this->user_id)) > 0) {
            $rc = false;
            Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Der ausgewählte Benutzer ist kein Lehrer.'));
        } else if ($rc && Appointment::model()->countByAttributes(array('user_id' => $this->user_id, 'parent_child_id' => $this->parent_child_id)) >= 1) {
            Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Leider haben Sie bereits einen Termin bei diesem Lehrer gebucht. Daher können Sie keinen weiteren buchen.'));
            $rc = false;
        } else if ($rc && ParentChild::model()->countByAttributes(array('id' => $this->parent_child_id)) != '1') {
            $rc = false;
            Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Sie müssen ein Kind angeben.'));
        }
        if ($rc && DateAndTime::model()->countByAttributes(array('dateAndTime_id' => $this->dateAndTime_id)) != '1') {
            $rc = false;
            Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Der angegebene Termin existiert nicht.'));
        }
        if ($rc && ParentChild::model()->countByAttributes(array('parent_child_id' => $this->parent_child_id)) != '1') {
            $rc = false;
            Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Die angegebene Elternkindverknüpfung existiert nicht.'));
        }
        return $rc;
    }

    protected function beforeValidate() {
        if (Yii::app()->user->isTeacher() && !Yii::app()->params['teacherAllowBlockTeacherApps']) {
            $this->user_id = Yii::app()->user->getId();
        }
        return parent::beforeValidate();
    }

    /**
     * Prüft ob die maximal Anzahl von Terminen überschritten wurde und ob der Benutzer bereits zu dieser Uhrzeit einen Termin hat
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     */
    public function beforeSave() {
        $rc = parent::beforeSave();
        if ($rc && Appointment::model()->countByAttributes(array('dateAndTime_id' => $this->dateAndTime_id, 'user_id' => $this->user_id)) > 0) {
            $rc = false;
            if (Yii::app()->user->checkAccess(MANAGEMENT)) {
                $this->addError('dateAndTime_id', Yii::t('app', 'Diese/r Lehrer/in hat bereits zu dieser Uhrzeit einen Termin.'));
            }
        }
        if (!Yii::app()->user->checkAccess(MANAGEMENT) && $rc) {
            if (Appointment::model()->countByAttributes(array('parent_child_id' => $this->parent_child_id)) > Yii::app()->params['maxAppointmentsPerChild']) {
                $rc = false;
                Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Leider konnte Ihr Termin nicht gebucht haben, da Sie die maximale Anzahl von {maxApp} Terminen überschritten haben.', array('{maxApp}' => Yii::app()->params['maxAppointmentsPerChild'])));
                $this->addError('parent_child_id', Yii::t('app', 'Sie haben die maximale Anzahl an Terminen überschritten.'));
            }
        }
        if ($rc && Appointment::model()->countByAttributes(array('user_id' => $this->user_id, 'parent_child_id' => $this->parent_child_id)) >= '1') {
            $rc = false;
            Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Sie können nur einen Termin bei diesem Lehrer pro Kind buchen.'));
        }
        if ($rc && Appointment::model()->count($this->getCriteriaForAppCount()) > 0) {
            $rc = false;
            if (Yii::app()->user->checkAccess(MANAGEMENT)) {
                $this->addError('dateAndTime_id', Yii::t('app', 'Dieser Benutzer hat bereits einen Termin zu dieser Uhrzeit.'));
            } else {
                $this->addError('dateAndTime_id', Yii::t('app', 'Sie haben bereits einen Termin zu dieser Uhrzeit.'));
            }
        }
        if ($rc) {
            Yii::app()->user->setFlash('success', Yii::t('app', 'Ihr Termin wurde erfolgreich gebucht.'));
        } else if (!$rc && !Yii::app()->user->hasFlash('failMsg')) {
            Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Leider konnte ihr Termin nicht gebucht werden.'));
        }
        return $rc;
    }

    private function getCriteriaForAppCount() {
        $crit = new CDbCriteria();
        $crit->with = array('parentchild');
        $crit->compare('parentchild.user_id', $this->parentchild->user->id);
        $crit->compare('dateAndTime_id', $this->dateAndTime_id);
        return $crit;
    }

    /**
     * Prüft ob der Benutzer die Berechtigung zum löschen von dem Termin hat
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     */
    public function beforeDelete() {
        $rc = parent::beforeDelete();
        if ($rc && Yii::app()->user->checkAccessNotAdmin(TEACHER)) {
            if ($this->user_id != Yii::app()->user->getId()) {
                $rc = false;
            }
        } else if ($rc && Yii::app()->user->checkAccessNotAdmin(PARENTS)) {
            if ($this->parentchild->user_id != Yii::app()->user->id) {
                $rc = false;
            }
        }
        if (!$rc) {
            Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Keine Berechtigung um diesen Termin zu löschen.'));
        }
        return $rc;
    }

    /**
     * Nach dem der Termin gelöscht wurde, wird eine Infomail an die Eltern versendet.
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function afterDelete() {
        Yii::trace($this->parentchild->user->email . ' ' . $this->dateandtime->time . ' ' . $this->parentchild->child->firstname . ' ' . $this->dateandtime->date->date, 'application.models.appointment');
        Yii::app()->user->setFlash('success', Yii::t('app', 'Benutzer erfolgreich entfernt.'));
        return parent::afterDelete();
    }

}
