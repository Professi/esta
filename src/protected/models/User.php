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
 * Dies ist die Modelklasse für Tabelle "user".
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $activationKey
 * @property integer $createtime
 * @property string $firstname
 * @property integer $state
 * @property integer $role
 * @property string $lastname
 * @property string $email
 * @property string $title
 * @property integer $lastLogin
 * @property integer $badLogins
 * @property integer $bannedUntil
 *
 * The followings are the available model relations:
 * @property Appointment[] $appointments
 * @property ParentChild[] $parentChildren
 * @property Group[] $groups
 * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
 */
class User extends CActiveRecord {

    /** @var string  Passwortwiederholung */
    public $password_repeat = null;

    /** @var string Rollenname */
    public $roleName = null;

    /** @var string StatusName */
    public $stateName = null;

    /** @var string Sicherheitscode */
    public $verifyCode = null;

    /** @var string TAN Nummer bei Registrierung */
    public $tan = null;

    /** @var array Array mit den Rollennamen */
    public $groupIds = null;
    public $updateGroups = false;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Tabellenname
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * Regeln für die Validierung
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('firstname, lastname', 'required'),
            array('email', 'length', 'min' => 1, 'on' => array('update'), 'allowEmpty' =>
                empty($this->password) && empty($this->email) &&
                !$this->isNewRecord && $this->state == 0 && $this->role == 3),
            array('email', 'required', 'except' => array('update')),
            array('email', "unique"),
            array('email', 'email'),
            array('state', 'numerical', 'integerOnly' => true),
            array('firstname, lastname, email', 'length', 'max' => 45),
            array('password', 'length', 'max' => 64, 'min' => 8, 'on' => array('insert')),
            array('password', 'length', 'max' => 256, 'min' => 8,
                'on' => array('update', 'insert'),
                'allowEmpty' => strlen($this->password) == 0 && !Yii::app()->user->isGuest),
            array('tan', 'length',
                'min' => Yii::app()->params['tanSize'],
                'max' => Yii::app()->params['tanSize'],),
            array('tan', 'numerical', 'integerOnly' => TRUE,
                'allowEmpty' => !$this->isNewRecord || !Yii::app()->user->isGuest
            ),
            array('password', 'compare', "on" => array("insert", "update"), 'compareAttribute' => 'password_repeat'),
            array('verifyCode', 'captcha', 'allowEmpty' => !Yii::app()->user->isGuest || !$this->isNewRecord || !CCaptcha::checkRequirements()),
            array('id, username, firstname, state, lastname, email, role, stateName, title, groupIds, password_repeat', 'safe'),
            array('groups', 'safe', 'on' => 'update'),
        );
    }

    /**
     * Relationen ( Appointments HAS_MANY , parentChildren HAS_MANY, role HAS_ONE )
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'appointments' => array(self::HAS_MANY, 'Appointment', 'user_id'),
            'parentchildren' => array(self::HAS_MANY, 'ParentChild', 'user_id'),
            'childcount' => array(self::STAT, 'ParentChild', 'user_id'),
            'groupcount' => array(self::STAT, 'UserHasGroup', 'user_id'),
            'groups' => array(self::MANY_MANY, 'Group', "user_has_group(user_id,group_id)"),
        );
    }

    /**
     * Verschlüsselt ein Passwort mit Applikationssalt mit Hilfe des CPasswordHelpers
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param string $password Zu salzendes Passwort
     * @return string password
     */
    public function encryptPassword($password) {
        return CPasswordHelper::hashPassword($password, Yii::app()->params['hashCost']);
    }

    /**
     * verifys Password with CPasswordHelper
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param string $password
     * @return boolean
     */
    public function verifyPassword($password) {
        $rc = false;
        if (CPasswordHelper::verifyPassword($password, $this->password)) {
            $rc = true;
        }
        return $rc;
    }

    /**
     * Attributlabels
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => Yii::t('app', 'Benutzername'),
            'password' => Yii::t('app', 'Passwort'),
            'password_repeat' => Yii::t('app', 'Passwort wiederholen'),
            'firstname' => Yii::t('app', 'Vorname'),
            'state' => Yii::t('app', 'Status'),
            'stateName' => Yii::t('app', 'Status'),
            'lastname' => Yii::t('app', 'Nachname'),
            'email' => Yii::t('app', 'E-Mail'),
            'createtime' => Yii::t('app', 'Registrierungsdatum'),
            'verifyCode' => Yii::t('app', 'Sicherheitscode'),
            'title' => Yii::t('app', 'Titel'),
            'groups' => Yii::t('app', 'Gruppen'),
            'badLogins' => Yii::t('app', 'Ungültige Anmeldeversuche'),
            'role' => Yii::t('app', 'Benutzerrolle'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();
        $criteria->compare('firstname', $this->firstname, true);
        $criteria->compare('lastname', $this->lastname, true);
        $criteria->compare('id', $this->id, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('state', $this->state);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('role', $this->role);
        $sort = new CSort;
        $sort->attributes = array(
            'defaultOrder' => 'id ASC',
            'id' => array(
                'asc' => 'id',
                'desc' => 'id desc'),
            'username' => array(
                'asc' => 'username',
                'desc' => 'username desc'),
            'firstname' => array(
                'asc' => 'firstname',
                'desc' => 'firstname desc'),
            'lastname' => array(
                'asc' => 'lastname',
                'desc' => 'lastname desc'),
            'title' => array(
                'asc' => 'title',
                'desc' => 'title desc'),
            'state' => array(
                'asc' => 'state',
                'desc' => 'state desc'),
            'role' => array(
                'asc' => 'role',
                'desc' => 'role desc'),
        );
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 20),
            'sort' => $sort,
        ));
    }

    /**
     * Erstellt CActiveDataProvider mit CDbCriteria mit Suche nach Lehrerbenutzern 
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return \CActiveDataProvider
     */
    public function searchTeacher() {
        $this->role = 2;
        return new CActiveDataProvider($this, array(
            'criteria' => $this->searchCriteriaTeacherAutoComplete(),
            'pagination' => array('pageSize' => 20),
        ));
    }

    /**
     * Suche für die Autovervollständigung bei getTeacher()
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return \CDbCriteria
     * 
     */
    public function searchCriteriaTeacherAutoComplete() {
        $criteria = new CDbCriteria;
        if (Yii::app()->params['allowGroups'] && is_array($this->groups)) {
            $criteria->together = true;
            $criteria->with[] = 'groups';
            $i = 0;
            foreach ($this->groups as $group) {
                $criteria->addCondition('groups.id =:group' . $i, 'OR');
                $criteria->params[':group' . $i] = $group->id;
                $i++;
            }
        }
        $match = addcslashes(ucfirst($this->lastname), '%_');
        $criteria->addCondition('lastname LIKE :match');
        $criteria->params[':match'] = "$match%";
        $criteria->params[':role'] = $this->role;
        $criteria->compare('state', $this->state, false);
        $criteria->select = 'title,firstname,lastname,id';
        $criteria->addCondition('role=:role');
        $criteria->limit = 10;
        return $criteria;
    }

    /**
     * Suchkriterien um alle User mit UserRollen zu löschen
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @deprecated since version 1.2
     * @return \CDbCriteria 
     */
    public static function deleteAllCriteria() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('role=:role1', "OR");
        $criteria->addCondition('role=:role2', "OR");
        $criteria->params = array(':role1' => 2, ':role2' => 3);
        $criteria->select = 'id';
        return $criteria;
    }

    /**
     * Loescht Benutzer mit einer bestimmten Rolle
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param integer $role
     */
    public function deleteUsersWithRole($role) {
        if (is_int($role)) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('role=:role');
            $criteria->params = array(':role' => $role);
            $criteria->select = 'id';
            $a_delete = User::model()->findAll($criteria);
            foreach ($a_delete as $record) {
                $record->delete();
            }
        }
    }

    /**
     * Erstellt automatisch für createtime einen Timestamp
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array gibt für das Attribut createtime den aktuellen Timestamp zurück
     */
    public function behaviors() {
        if ($this->isNewRecord) {
            return array(
                'CTimestampBehavior' => array(
                    'class' => 'zii.behaviors.CTimestampBehavior',
                    'createAttribute' => 'createtime',
                )
            );
        } else {
            return array();
        }
    }

    /**
     * updates a tan, sets used to true and used_by_user_id = this user_id
     * @param Tan $tan
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    private function updateTan($tan = '') {
        if (!Yii::app()->user->checkAccess(MANAGEMENT)) {
            if ($tan == '') {
                $tan = Tan::model()->findByAttributes(array('tan' => $this->tan));
            }
            $tan->used = true;
            $tan->used_by_user_id = $this->getPrimaryKey();
            $tan->update();
        }
    }

    /**
     * basics for working user account, updates tan and creates userHasGroup
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean 
     */
    private function saveNewRecord() {
        $this->updateTan();
        if (Yii::app()->params['allowGroups'] && !empty($this->groupIds)) {
            foreach ($this->groupIds as $group) {
                $this->createUserHasGroup($group);
            }
        }
    }

    /**
     * saves a already existing user entry
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    private function saveExistingRecord() {
        if (Yii::app()->params['allowGroups'] && $this->updateGroups) {
            UserHasGroup::model()->deleteAllByAttributes(array('user_id' => $this->id));
            if (!empty($this->groupIds)) {
                foreach ($this->groupIds as $group) {
                    if (UserHasGroup::model()->countByAttributes(array('user_id' => $this->id, 'group_id' => $group)) == '0') {
                        $this->createUserHasGroup($group);
                    }
                }
            }
        }
    }

    /**
     * if new record it Invokes saveNewRecord() , else saveExistingRecord
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     */
    public function afterSave() {
        if ($this->isNewRecord) {
            $rc = $this->saveNewRecord();
        } else {
            $this->saveExistingRecord();
        }
        return parent::afterSave();
    }

    /**
     * löscht ElternKind Verknüpfung + Kinder
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean Rückgabewert der Elternklassemethoden
     */
    public function beforeDelete() {
        BlockedAppointment::model()->deleteAllByAttributes(array('user_id' => $this->id));
        $a_appointment = Appointment::model()->findAllByAttributes(array('user_id' => $this->id));
        for ($x = 0; $x < count($a_appointment); $x++) {
            $a_appointment[$x]->delete();
        }
        $this->deleteParentChilds();
        if (Yii::app()->params['allowGroups'] && !empty($this->groups)) {
            UserHasGroup::model()->deleteAllByAttributes(array('user_id' => $this->id));
        }
        return parent::beforeDelete();
    }

    /**
     * deletes all parentChilds which linked to this user
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    private function deleteParentChilds() {
        $a_parentChild = ParentChild::model()->findAllByAttributes(array('user_id' => $this->id));
        for ($i = 0; $i < count($a_parentChild); $i++) {
            $a_appointment = Appointment::model()->findAllByAttributes(array('parent_child_id' => $a_parentChild[$i]->id));
            for ($x = 0; $x < count($a_appointment); $x++) {
                $a_appointment[$x]->delete();
            }
            $childId = $a_parentChild[$i]->child_id;
            ParentChild::model()->deleteByPk($a_parentChild[$i]->id);
            Child::model()->deleteByPk($childId);
        }
    }

    /**
     *  verschlüsselt das Passwort und generiert einen Aktivierungsschlüssel, setzt die E-Mail Adresse als Username fest
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean Rückgabewert der parent methode
     */
    public function beforeSave() {
        if ($this->isNewRecord) {
            if (Yii::app()->user->isGuest) {
                $this->state = 0;
                $this->role = 3;
            }
            $this->activationKey = self::generateActivationKey();
            if (empty($this->username) && !empty($this->email)) {
                $this->username = $this->email;
            }
            $this->lastname = ucfirst($this->lastname);
            $this->firstname = ucfirst($this->firstname);
        }
        if (strlen($this->password) < 60 && strlen($this->password) > 0) {
            $this->password = $this->encryptPassword($this->password);
        } else if (!$this->isNewRecord) {
            $this->password = User::model()->findByPk($this->id)->password;
        }
        return parent::beforeSave();
    }

    /**
     * Generiert einen Aktivierungsschlüssel und speichert diesen im aktuellen Objekt
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function generateActivationKey() {
        return sha1(mt_rand(10000, 99999) . time() . $this->email);
    }

    /**
     * Setzt den StateName und gibt ihn zurück
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return string 0=NichtAktiv 1=Aktiv 2=Gesperrt
     */
    public function getStateName($state = null) {
        if(is_numeric($state) && array_key_exists($state, self::getStateNameAndValue())) {
            $stateName = self::getStateNameAndValue()[$state]['name'];
        } else {
            $stateName = $this->state;
        }
        if ($state == null) {
            $this->stateName = $stateName;
        }
        return $stateName;
    }

    /**
     * Gibt den Status als String aus ( echo )
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param integer $state Status ID des Users
     */
    public function getFormattedState($state) {
        echo $this->getStateName($state);
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * returns array with state Id and name
     * @return array
     */
    public static function getStateNameAndValue() {
        return array(array('value' => '0', 'name' => Yii::t('app', 'Nicht aktiv')), array('value' => '1', 'name' => Yii::t('app', 'Aktiv')), array('value' => '2', 'name' => Yii::t('app', 'Gesperrt')));
    }

    /**
     * Gibt Rolle als String aus ( echo )
     *  0 = Admin 1=Verwaltung 2=Lehrer 3= Eltern
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param integer $role Rollen ID des Users
     */
    static public function getFormattedRole($role) {
        return self::getRoles()[$role]['name'];
    }

    static public function getRoles() {
        return array(array('value' => 0, 'name' => Yii::t('app', 'Administrator')), array('value' => 1, 'name' => Yii::t('app', 'Verwalter')), array('value' => 2, 'name' => Yii::t('app', 'Lehrer')), array('value' => 3, 'name' => Yii::t('app', 'Eltern')));
    }

    /**
     * Prüft ob eine Gruppe null ist und wenn nicht wird der Gruppenname zurückgegeben
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param Group $group
     * @return String
     */
    private function getGroupname($group) {
        $rc = '';
        if (!is_null($group)) {
            $rc = $group->groupname;
        }
        return $rc;
    }

    /**
     * Liefert alle Gruppennamen in einem String
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return string
     */
    public function getGroupnames() {
        $rc = "";
        $first = true;
        if (!empty($this->groups)) {
            foreach ($this->groups as $group) {
                if ($first) {
                    $first = false;
                    $rc .= $this->getGroupname($group);
                } else {
                    $rc .= "," . $this->getGroupname($group);
                }
            }
        }
        return $rc;
    }

    /**
     * Führt zunächst die Elternmethode beforeValidate() aus und 
     * prüft wenn diese true zurückgibt und es keiner neuer Eintrag ist ob die TAN schon benutzt wurde 
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     */
    public function validate($attributes = null, $clearErrors = true) {
        parent::validate($attributes, $clearErrors);
        $rc = parent::validate($attributes, $clearErrors);
        $params['{attribute}'] = $this->getAttributeLabel('password');
        if ($this->getError('password') == Yii::t('yii', '{attribute} must be repeated exactly.', $params)) {
            $this->addError('password_repeat', Yii::t('app', 'Passwörter stimmen nicht überein.'));
        }
        if ($rc && Yii::app()->user->isGuest && $this->isNewRecord) {
            $rc = $this->addWithTanNewGroup($this->tan);
        }
        return $rc;
    }

    /**
     * Mit einer TAN wird der Benutzer zu einer Gruppe hinzugefügt
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param type $tanNo
     * @return boolean
     */
    public function addWithTanNewGroup(&$errorMsg = "") {
        $rc = true;
        $tan = Tan::model()->findByAttributes(array('tan' => $this->tan));
        if ($tan !== null) {
            if ($tan->used) {
                $errorMsg = Yii::t('app', 'Leider wurde Ihre TAN schon benutzt.');
                $rc = false;
            } else {
                if (Yii::app()->params['allowGroups'] && $tan->group != null && is_int($tan->group_id)) {
                    $errorMsg = $this->addUserHasGroup($tan);
                    if (empty($errorMsg)) {
                        $this->updateTan($tan);
                    }
                }
                $this->addParentChildWithTan($tan);
            }
        } else {
            if (Yii::app()->user->isGuest()) {
                $errorMsg = Yii::t('app', 'Leider konnte die eingegebene TAN nicht identifiziert werden.');
                $rc = false;
            }
        }
        if (!$rc) {
            $this->addError('tan', $errorMsg);
        }
        return $rc;
    }

    /**
     * creates new parentChild Link for this user with a TAN
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param Tan $tan
     */
    private function addParentChildWithTan(&$tan) {
        if ($tan->child != null) {
            $pc = $this->createParentChild($this->id, $tan->child->id);
            if ($pc->save()) {
                $flash = '';
                if (Yii::app()->user->hasFlash('success')) {
                    $flash = Yii::app()->user->getFlash('success') . "<br>";
                }
                Yii::app()->user->setFlash('success', Yii::t('app', 'Schüler hinzugefügt.') . $flash);
            }
        }
    }

    /**
     * adds userHasGroup for this user
     * @param Tan $tan
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return string
     */
    private function addUserHasGroup($tan) {
        $errorMsg = '';
        if (!UserHasGroup::model()->countByAttributes(array('user_id' => $this->id, 'group_id' => $tan->group_id)) > '0') {
            $this->createUserHasGroup($tan->group_id);
            Yii::app()->user->setFlash('success', Yii::t('app', 'Sie wurden erfolgreich der Gruppe hinzugefügt.'));
            Yii::app()->user->setGroups($this->groups);
        } else {
            $errorMsg = Yii::t('app', 'Sie wurden bereits der Gruppe die bei dieser TAN hinterlegt ist, zugewiesen.');
        }
        return $errorMsg;
    }

    /**
     * Erstellt einen Datensatz in UserHasGroup
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param UserHasGroup $group
     */
    public function createUserHasGroup($group) {
        $userHasGroup = new UserHasGroup();
        $userHasGroup->user_id = $this->getPrimaryKey();
        $userHasGroup->group_id = $group;
        $userHasGroup->save();
    }

    /**
     * gibt true zurück wenn der gegebene Benutzer die entsprechende Rolle hat
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param integer $userId Benutzer ID
     * @param integer $roleId Rollen ID
     * @return boolean
     */
    public static function hasRole($userId, $roleId) {
        $rc = false;
        if (is_int($userId) && is_int($roleId) && User::model()->countByAttributes(
                        array('id' => $userId, 'role' => $roleId)) == 1) {
            $rc = true;
        }
        return $rc;
    }

    /**
     * Setzt diverse Attribute
     * @param type $email Email
     * @param type $firstname Vorname
     * @param type $lastname Nachname
     * @param type $state Status
     * @param type $role Rolle
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function setSomeAttributes($email, $firstname, $lastname, $state, $role) {
        $this->email = $email;
        $this->username = $this->email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->state = $state;
        $this->role = $role;
    }

    /**
     * Verwendet entweder das Standardpasswort oder den Passwortgenerator
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return string Klartextpasswort zur Anzeige
     */
    public function generatePassword() {
        if (Yii::app()->params['randomTeacherPassword']) {
            $passGen = new PasswordGenerator();
            $this->password = $passGen->generate();
        } else {
            $this->password = Yii::app()->params['defaultTeacherPassword'];
        }
        $password = $this->password;
        $this->password_repeat = $this->password;
        if ($this->save() && Yii::app()->params['randomTeacherPassword'] && Yii::app()->params['mailsActivated']) {
            $mail = new Mail();
            $mail->sendRandomUserPassword($this->email, $password);
        }
        return $password;
    }

    /**
     * Gibt ein Array zurück welches die Rollen beinhaltet, mit denen Administration/Verwaltung Benutzer verändern können
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array
     */
    public function getRolePermission() {
        $rc = null;
        if (Yii::app()->user->checkAccess(ADMIN)) {
            $rc = array('3' => Yii::t('app', 'Eltern'), '2' => Yii::t('app', 'Lehrer'), '1' => Yii::t('app', 'Verwaltung'), '0' => Yii::t('app', 'Administrator'));
        } else if (Yii::app()->user->checkAccessNotAdmin(MANAGEMENT) && $this->id == Yii::app()->user->getId()) {
            $rc = array('3' => Yii::t('app', 'Eltern'), '2' => Yii::t('app', 'Lehrer'), '1' => Yii::t('app', 'Verwaltung'));
        } else {
            $rc = array('3' => Yii::t('app', 'Eltern'), '2' => Yii::t('app', 'Lehrer'));
        }
        return $rc;
    }

    /**
     * creates new ParentChild and returns it
     * @param integer $user_id
     * @param integer $child_id
     * @return \ParentChild
     */
    public function createParentChild($user_id, $child_id) {
        $pc = new ParentChild();
        $pc->child_id = $child_id;
        $pc->user_id = $user_id;
        return $pc;
    }
    
    /**
     * Name of the User with Title
     * @return string 
     */
    public function getDisplayName() {
        return (empty($this->title)) 
            ? "{$this->firstname} {$this->lastname}"
            : "{$this->title} {$this->firstname} {$this->lastname}";
    }

}
