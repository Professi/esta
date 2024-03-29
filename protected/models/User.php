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
class User extends CActiveRecord
{

    /** @var string  Passwortwiederholung */
    public $password_repeat = null;

    /** @var string Rollenname */
    public $roleName = null;

    /** @var string StatusName */
    public $stateName = null;

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
        return 'user';
    }

    /**
     * Regeln für die Validierung
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('firstname, lastname,email', 'required'),
            array('email', 'length', 'min' => 1, 'on' => array('update'), 'allowEmpty' =>
                empty($this->password) && empty($this->email) &&
                !$this->isNewRecord && $this->state == 0 && $this->role == 3),
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
            array('tan', 'numerical', 'integerOnly' => true,
                'allowEmpty' => !$this->isNewRecord || !Yii::app()->user->isGuest || (isset(Yii::app()->params['tansActive']) || !Yii::app()->params['tansActive'])
            ),
            array('password', 'compare', "on" => array("insert", "update"), 'compareAttribute' => 'password_repeat'),
            array('id, firstname, state, lastname, email, role, stateName, title, groupIds, password_repeat', 'safe'),
            array('groups,activationKey', 'safe', 'on' => 'update'),
        );
    }

    /**
     * Relationen ( Appointments HAS_MANY , parentChildren HAS_MANY, role HAS_ONE )
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'appointments' => array(self::HAS_MANY, 'Appointment', 'user_id'),
            'parentchildren' => array(self::HAS_MANY, 'ParentChild', 'user_id'),
            'childcount' => array(self::STAT, 'ParentChild', 'user_id'),
            'groupcount' => array(self::STAT, 'UserHasGroup', 'user_id'),
            'groups' => array(self::MANY_MANY, 'Group', 'user_has_group(user_id,group_id)'),
            'rooms' => array(self::MANY_MANY, 'Room', 'user_has_room(user_id,room_id)')
        );
    }

    /**
     * Verschlüsselt ein Passwort mit Applikationssalt mit Hilfe des CPasswordHelpers
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param string $password Zu salzendes Passwort
     * @return string password
     */
    public function encryptPassword($password)
    {
        return CPasswordHelper::hashPassword($password, Yii::app()->params['hashCost']);
    }

    /**
     * verifys Password with CPasswordHelper
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param string $password
     * @return boolean
     */
    public function verifyPassword($password)
    {
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
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'password' => Yii::t('app', 'Passwort'),
            'password_repeat' => Yii::t('app', 'Passwort wiederholen'),
            'firstname' => Yii::t('app', 'Vorname'),
            'state' => Yii::t('app', 'Status'),
            'stateName' => Yii::t('app', 'Status'),
            'lastname' => Yii::t('app', 'Nachname'),
            'lastLogin' => Yii::t('app', 'Zuletzt eingeloggt'),
            'email' => Yii::t('app', 'E-Mail'),
            'createtime' => Yii::t('app', 'Registrierungsdatum'),
            'tan' => Yii::t('app', 'TAN'),
            'title' => Yii::t('app', 'Titel'),
            'groups' => Yii::t('app', 'Gruppen'),
            'badLogins' => Yii::t('app', 'Ungültige Anmeldeversuche'),
            'role' => Yii::t('app', 'Benutzerrolle'),
        );
    }
    
    public function mailTo() {
        return '<a href ="mailto:' . $this->email . '">' . $this->email . '</a>';
        
    }
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('firstname', $this->firstname, true);
        $criteria->compare('lastname', ucfirst($this->lastname), true);
        $criteria->compare('id', $this->id, true);
        $criteria->compare('state', $this->state);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('role', $this->role);
        $sort = new CSort();
        $sort->defaultOrder = 'lastname ASC';
        $sort->multiSort = true;
        $sort->attributes = array(
            'id' => array(
                'asc' => 'id',
                'desc' => 'id desc'),
            'email' => array(
                'asc' => 'email',
                'desc' => 'email desc'),
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
            'lastLogin' => array(
                'asc' => 'lastLogin',
                'desc' => 'lastLogin desc'),
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
    public function searchTeacher()
    {
        $this->role = 2;
        return new CActiveDataProvider($this, array(
            'criteria' => $this->searchCriteriaTeacherAutoComplete(false),
            'pagination' => array('pageSize' => 20),
            'sort' => array(
                'defaultOrder' => 'lastname'),
        ));
    }

    /**
     * Suche für die Autovervollständigung bei getTeacher()
     * @return \CDbCriteria
     *
     */
    public function searchCriteriaTeacherAutoComplete($withOrder = true)
    {
        $criteria = new CDbCriteria;
        if (Yii::app()->params['allowGroups'] && (Yii::app()->user->isTeacher() || Yii::app()->user->isParent())) {
            $criteria->together = true;
            $criteria->with[] = 'groups';
            $i = 0;
            $criteria->addCondition('groups.id IS NULL', 'OR');
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
        $criteria->compare('state', $this->state);
        $criteria->select = 'title,firstname,lastname,id';
        $criteria->addCondition('role=:role');
        if ($withOrder) {
            $criteria->order = "lastname ASC";
        }
        $criteria->limit = 10;
        return $criteria;
    }

    /**
     * Loescht Benutzer mit einer bestimmten Rolle
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param integer $role
     */
    public function deleteUsersWithRole($role)
    {
        if (is_numeric($role)) {
            $a_delete = User::model()->findAllByAttributes(array('role' => $role), array('select' => 'id'));
            foreach ($a_delete as $record) {
                $record->delete();
            }
        }
    }

    /**
     * Erstellt automatisch für createtime einen Timestamp
     * @return array gibt für das Attribut createtime den aktuellen Timestamp zurück
     */
    public function behaviors()
    {
        if ($this->isNewRecord) {
            return array(
                'CTimestampBehavior' => array(
                    'class' => 'zii.behaviors.CTimestampBehavior',
                    'createAttribute' => 'createtime',
                )
            );
        }
        return array();
    }

    /**
     * updates a tan, sets used to true and used_by_user_id = this user_id
     * @param Tan $tan
     */
    private function updateTan($tan = '')
    {
        if (!Yii::app()->user->checkAccess(MANAGEMENT)) {
            if (empty($tan)) {
                $tan = Tan::model()->findByAttributes(array('tan' => $this->tan));
            }
            $tan->used_by_user_id = $this->getPrimaryKey();
            $tan->used_by_user = $this;
            $tan->used = true;
            $tan->update();
        }
    }

    /**
     * basics for working user account, updates tan and creates userHasGroup
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     */
    private function saveNewRecord()
    {
        if (Yii::app()->params['allowGroups'] && !empty($this->groupIds)) {
            foreach ($this->groupIds as $group) {
                $this->createUserHasGroup($group);
            }
        }
    }

    /**
     * saves a already existing user entry
     */
    private function saveExistingRecord()
    {
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
     * @return boolean
     */
    public function afterSave()
    {
        if ($this->isNewRecord) {
            $this->saveNewRecord();
            if (Yii::app()->user->isGuest() && (!isset(Yii::app()->params['tansActive']) || Yii::app()->params['tansActive'])) {
                $this->tanManagement($this->tan);
            }
        } else {
            $this->saveExistingRecord();
        }
        return parent::afterSave();
    }

    /**
     *
     * @param int $date_id
     * @return Room|null
     */
    public function getRoom($date_id)
    {
        $uhr = $this->getUserHasRoom($date_id);
        if (!is_null($uhr)) {
            return $uhr->room;
        }
        return null;
    }

    public function addWithTanNewGroup()
    {
        $this->tanManagement($this->tan);
    }

    public function getUserHasRoom($date_id)
    {
        return UserHasRoom::model()->findByAttributes(array('user_id' => $this->getPrimaryKey(), 'date_id' => $date_id));
    }

    /**
     * löscht ElternKind Verknüpfung + Kinder
     * @return boolean Rückgabewert der Elternklassemethoden
     */
    public function beforeDelete()
    {
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
     */
    private function deleteParentChilds()
    {
        $parentChilds = ParentChild::model()->findAllByAttributes(array('user_id' => $this->id));
        for ($i = 0; $i < count($parentChilds); $i++) {
            $appointments = Appointment::model()->findAllByAttributes(array('parent_child_id' => $parentChilds[$i]->id));
            for ($x = 0; $x < count($appointments); $x++) {
                $appointments[$x]->delete();
            }
            $childId = $parentChilds[$i]->child_id;
            ParentChild::model()->deleteByPk($parentChilds[$i]->id);
            Child::model()->deleteByPk($childId);
        }
    }

    /**
     *  verschlüsselt das Passwort und generiert einen Aktivierungsschlüssel, setzt die E-Mail Adresse als Username fest
     * @return boolean Rückgabewert der parent methode
     */
    public function beforeSave()
    {
        if ($this->isNewRecord) {
            if (Yii::app()->user->isGuest) {
                $this->state = 0;
                $this->role = 3;
            }
            $this->activationKey = self::generateActivationKey();
            $this->lastname = ucfirst($this->lastname);
            $this->firstname = ucfirst($this->firstname);
        }
        if (strlen($this->password) < 60 && strlen($this->password) > 0) {
            $this->password = $this->encryptPassword($this->password);
        } elseif (!$this->isNewRecord) {
            $this->password = User::model()->findByPk($this->id)->password;
        }
        return parent::beforeSave();
    }

    /**
     * Generiert einen Aktivierungsschlüssel und speichert diesen im aktuellen Objekt
     */
    public function generateActivationKey()
    {
        return sha1(mt_rand(10000, 99999) . time() . $this->email);
    }

    /**
     * Setzt den StateName und gibt ihn zurück
     * @return string 0=NichtAktiv 1=Aktiv 2=Gesperrt
     */
    public function getStateName($state = null)
    {
        if (is_numeric($state) && array_key_exists($state, self::getStateNameAndValue())) {
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
     * @param integer $state Status ID des Users
     */
    public function getFormattedState($state)
    {
        echo $this->getStateName($state);
    }

    /**
     * returns array with state Id and name
     * @return array
     */
    public static function getStateNameAndValue()
    {
        return array(array('value' => NOT_ACTIVE, 'name' => Yii::t('app', 'Nicht aktiv')), array('value' => ACTIVE, 'name' => Yii::t('app', 'Aktiv')), array('value' => BLOCKED, 'name' => Yii::t('app', 'Gesperrt')));
    }

    /**
     * Gibt Rolle als String aus ( echo )
     *  0 = Admin 1=Verwaltung 2=Lehrer 3= Eltern
     * @param integer $role Rollen ID des Users
     */
    public static function getFormattedRole($role)
    {
        return self::getRoles()[$role]['name'];
    }

    public static function getRoles()
    {
        return array(array('value' => ADMIN, 'name' => Yii::t('app', 'Administrator')), array('value' => MANAGEMENT, 'name' => Yii::t('app', 'Verwalter')), array('value' => TEACHER, 'name' => Yii::t('app', 'Lehrer')), array('value' => PARENTS, 'name' => Yii::t('app', 'Eltern')));
    }

    /**
     * Prüft ob eine Gruppe null ist und wenn nicht wird der Gruppenname zurückgegeben
     * @param Group $group
     * @return String
     */
    private function getGroupname($group)
    {
        $rc = '';
        if (!is_null($group)) {
            $rc = $group->groupname;
        }
        return $rc;
    }

    /**
     * Liefert alle Gruppennamen in einem String
     * @return string
     */
    public function getGroupnames()
    {
        $rc = "";
        $first = true;
        if (!empty($this->groups)) {
            foreach ($this->groups as $group) {
                if ($first) {
                    $first = false;
                    $rc .= $this->getGroupname($group);
                } else {
                    $rc .= ", " . $this->getGroupname($group);
                }
            }
        }
        return $rc;
    }

    /**
     * Führt zunächst die Elternmethode beforeValidate() aus und
     * prüft wenn diese true zurückgibt und es keiner neuer Eintrag ist ob die TAN schon benutzt wurde
     * @return boolean
     */
    public function validate($attributes = null, $clearErrors = true)
    {
        $rc = parent::validate($attributes, $clearErrors);
        if ($this->hasErrors('password')) {
            $this->addError('password_repeat', Yii::t('app', 'Passwörter stimmen nicht überein.'));
            $rc = false;
        }
        if ($rc && !$this->validateTan()) {
            $rc = false;
        }
        return $rc;
    }

    /**
     * Mit einer TAN wird der Benutzer zu einer Gruppe hinzugefügt
     * @return boolean
     */
    public function validateTan(&$errorMsg = "")
    {
        $rc = true;
        if(isset(Yii::app()->params['tansActive']) || !Yii::app()->params['tansActive']) {
            return $rc;
        }
        $tan = Tan::model()->findByAttributes(array('tan' => $this->tan instanceof Tan ? $this->tan->tan : $this->tan));
        if ($tan !== null) {
            if ($tan->used) {
                $errorMsg = Yii::t('app', 'Leider wurde Ihre TAN schon benutzt.');
                $rc = false;
            } else {
                $this->tan = $tan;
            }
        } else {
            if (Yii::app()->user->isGuest()) {
                $errorMsg = Yii::t('app', 'Leider konnte die eingegebene TAN nicht identifiziert werden.');
                $rc = false;
            }
        }
        if (!$rc) {
            $this->addError('tan', $errorMsg);
        } else {
            $this->tan = $tan;
        }
        return $rc;
    }

    private function tanManagement($tan)
    {
        $ok = true;
        $errorMsg = '';
        if (Yii::app()->params['allowGroups'] && $tan->group != null && is_numeric($tan->group_id)) {
            $errorMsg = $this->addUserHasGroup($tan);
        }
        if (!Yii::app()->params['allowParentsToManageChilds'] && $tan->child_id != null) {
            $ok = $this->addParentChildWithTan($tan);
        }
        if ($ok && empty($errorMsg)) {
            $this->updateTan($tan);
        }
    }

    /**
     * creates new parentChild Link for this user with a TAN
     * @param Tan $tan
     */
    private function addParentChildWithTan(&$tan)
    {
        $rc = false;
        $pc = $this->createParentChild($this->id, $tan->child->id);
        if ($pc->save()) {
            $rc = true;
            $flash = '';
            if (Yii::app()->user->hasFlash('success')) {
                $flash = Yii::app()->user->getFlash('success') . "<br>";
            }
            Yii::app()->user->setFlash('success', Yii::t('app', 'Kind hinzugefügt.') . $flash);
        }
        return $rc;
    }

    /**
     * adds userHasGroup for this user
     * @param Tan $tan
     * @return string
     */
    private function addUserHasGroup($tan)
    {
        $errorMsg = '';
        if (!UserHasGroup::model()->countByAttributes(array('user_id' => $this->id, 'group_id' => $tan->group_id)) > '0') {
            $this->createUserHasGroup($tan->group_id);
            Yii::app()->user->setFlash('success', Yii::t('app', 'Sie wurden erfolgreich der Gruppe hinzugefügt.'));
        } else {
            $errorMsg = Yii::t('app', 'Sie wurden bereits der Gruppe die bei dieser TAN hinterlegt ist, zugewiesen.');
        }
        return $errorMsg;
    }

    /**
     * Erstellt einen Datensatz in UserHasGroup
     * @param int $group
     */
    public function createUserHasGroup($group)
    {
        $userHasGroup = new UserHasGroup();
        $userHasGroup->user_id = $this->getPrimaryKey();
        $userHasGroup->group_id = $group;
        $userHasGroup->save();
    }

    /**
     *
     * @param int $room
     * @param int $date
     */
    public function createUserHasRoom($room, $date)
    {
        $userHasRoom = new UserHasRoom();
        $userHasRoom->user_id = $this->getPrimaryKey();
        $userHasRoom->room_id = $room;
        $userHasRoom->date_id = $date;
        return $userHasRoom->save();
    }

    /**
     * gibt true zurück wenn der gegebene Benutzer die entsprechende Rolle hat
     * @param integer $userId Benutzer ID
     * @param integer $roleId Rollen ID
     * @return boolean
     */
    public static function hasRole($userId, $roleId)
    {
        $rc = false;
        if (is_numeric($userId) && is_numeric($roleId) && User::model()->countByAttributes(
                        array('id' => $userId, 'role' => $roleId)
        ) == 1) {
            $rc = true;
        }
        return $rc;
    }

    public function setSomeAttributes($email, $firstname, $lastname, $state, $role)
    {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->state = $state;
        $this->role = $role;
    }

    /**
     * Verwendet entweder das Standardpasswort oder den Passwortgenerator
     * @return string Klartextpasswort zur Anzeige
     */
    public function generatePassword()
    {
        if (Yii::app()->params['randomTeacherPassword']) {
            $passGen = new PasswordGenerator();
            $this->password = $passGen->generate();
        } else {
            $this->password = Yii::app()->params['defaultTeacherPassword'];
        }
        $password = $this->password;
        $this->password_repeat = $this->password;
        if ($this->save() && Yii::app()->params['randomTeacherPassword']) {
            $mail = new Mail();
            $mail->sendRandomUserPassword($this->email, $password);
        }
        return $password;
    }

    /**
     * Gibt ein Array zurück welches die Rollen beinhaltet, mit denen Administration/Verwaltung Benutzer verändern können
     * @return array
     */
    public function getRolePermission()
    {
        $rc = array(PARENTS => Yii::t('app', 'Eltern'), TEACHER => Yii::t('app', 'Lehrer'));
        if (Yii::app()->user->isAdmin()) {
            $rc[MANAGEMENT] = Yii::t('app', 'Verwaltung');
            $rc[ADMIN] = Yii::t('app', 'Administrator');
        } elseif (Yii::app()->user->isManager() && $this->id == Yii::app()->user->getId()) {
            $rc[MANAGEMENT] = Yii::t('app', 'Verwaltung');
        }
        return $rc;
    }

    /**
     * creates new ParentChild and returns it
     * @param integer $user_id
     * @param integer $child_id
     * @return \ParentChild
     */
    public function createParentChild($user_id, $child_id)
    {
        $pc = new ParentChild();
        $pc->child_id = $child_id;
        $pc->user_id = $user_id;
        return $pc;
    }

    /**
     * Name of the User with Title
     * @return string
     */
    public function getDisplayName()
    {
        return (empty($this->title)) ? "{$this->firstname} {$this->lastname}" : "{$this->title} {$this->firstname} {$this->lastname}";
    }
}
