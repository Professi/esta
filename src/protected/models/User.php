<?php

/**   Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 *   This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $activationKey
 * @property integer $createtime
 * @property string $firstname
 * @property integer $state
 * @property string $lastname
 * @property string $email
 * @property string $title
 *
 * The followings are the available model relations:
 * @property Appointment[] $appointments
 * @property ParentChild[] $parentChildren
 * @property UserRole[] $userRoles
 */
class User extends CActiveRecord {

    /**
     * @todo in private Attribute ändern und entsprechende getter und Setter erstellen
     */
    public $password_repeat = null;
    public $pwdChanged = false;
    public $role = null;
    public $roleName = null;
    public $stateName = null;
    public $verifyCode = null;
    public $tan = null;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('password, firstname, lastname, email', 'required'),
            array('email', "unique"),
            array('state', 'numerical', 'integerOnly' => true),
            array('firstname, lastname, email', 'length', 'max' => 45),
            array('password', 'length', 'max' => 128, 'min' => 8),
            array('tan', 'length',
                'min' => Yii::app()->params['tanSize'],
                'max' => Yii::app()->params['tanSize'],),
            array('tan', 'numerical', 'integerOnly' => TRUE,
                'allowEmpty' => !$this->isNewRecord || !Yii::app()->user->isGuest
            ),
            array('password', 'compare', "on" => "insert"),
            array('password_repeat', 'safe'), //allow bulk assignment
            array('verifyCode', 'captcha', 'allowEmpty' => !Yii::app()->user->isGuest || !$this->isNewRecord || !CCaptcha::checkRequirements()),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, firstname, state, lastname, email, role,roleName,stateName', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'appointments' => array(self::HAS_MANY, 'Appointment', 'user_id'),
            'parentChildren' => array(self::HAS_MANY, 'ParentChild', 'user_id'),
            'userRoles' => array(self::HAS_ONE, 'UserRole', 'user_id'),
        );
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return string encrypted and salted password with sha512
     */
    public static function encryptPassword($password, $salt) {
        $saltedPw = $salt . $password;
        return hash('sha512', $saltedPw);
    }

    public function setAttributes($attributes, $safe = true) {
        foreach ($attributes as $name => $value) {
            $this->setAttribute($name, $value);
        }
        return true;
    }

    public function setAttribute($name, $value) {
        if ($name == "password") {
            $this->pwdChanged = true;
        }
        parent::setAttribute($name, $value);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Benutzername',
            'password' => 'Passwort',
            'password_repeat' => 'Passwort wiederholen',
            'firstname' => 'Vorname',
            'state' => 'Status',
            'stateName' => 'Status',
            'lastname' => 'Nachname',
            'email' => 'E-Mail',
            'createtime' => 'Registrierungsdatum',
            'role' => 'Rolle',
            'roleName' => 'Rolle',
            'verifyCode' => 'Sicherheitscode',
            'title' => 'Titel',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria();
        $criteria->compare('firstname', $this->firstname, true);
        $criteria->compare('id', $this->id, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('state', $this->state);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('stateName', $this->stateName, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 20),
        ));
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return \CActiveDataProvider
     * Erstellt CActiveDataProvider mit CDbCriteria mit Suche nach Lehrerbenutzern 
     */
    public function searchTeacher() {
        $this->role = 2;
        return new CActiveDataProvider($this, array(
            'criteria' => self::searchCriteriaTeacherAutoComplete(),
            'pagination' => array('pageSize' => 20),
        ));
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return \CDbCriteria
     * Suche für die Autovervollständigung bei getTeacher()
     * 
     */
    public function searchCriteriaTeacherAutoComplete() {
        $criteria = new CDbCriteria;
        $match = addcslashes(ucfirst($this->lastname), '%_');
        $criteria->addCondition('lastname LIKE :match');
        $criteria->params = array(':match' => "$match%");
        $criteria->compare('state', $this->state, true);
        $criteria->with = array('userRoles');
        $criteria->select = 'title,firstname,lastname,id';
        $criteria->addCondition('userRoles.role_id="' . $this->role . '"');
        $criteria->limit = 10;
        return $criteria;
    }

    public static function deleteAllCriteria() {
        $criteria = new CDbCriteria();
        $criteria->with = array('userRoles');
        $criteria->addCondition('userRoles.role_id="2"', "OR");
        $criteria->addCondition('userRoles.role_id="3"', "OR");
        $criteria->select = 'id';
        return $criteria;
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array gibt für das Attribut createtime den aktuellen Timestamp zurück
     * 
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
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean Rückgabewert der Methode afterSave() CActiveRecord
     * weist einem neuen Nutzer automatisch die Rolle "Eltern" zu
     */
    public function afterSave() {
        if ($this->isNewRecord) {
            if (!Yii::app()->user->isAdmin()) {
                $tan = Tan::model()->findByAttributes(array('tan' => $this->tan));
                $tan->used = true;
                $tan->update();
            }
            $userRole = New UserRole();
            $userRole->user_id = $this->id;
            if (Yii::app()->user->isGuest) {
                $userRole->role_id = Role::model()->findByAttributes(array('title' => 'Eltern'))->id;
            } else {
                $userRole->role_id = Role::model()->findByAttributes(array('id' => $this->role))->id;
            }
            $userRole->save();
        } else {
            $userRole = UserRole::model()->findByAttributes(array('user_id' => $this->id));
            $userRole->role_id = $this->role;
            $userRole->save();
        }

        return parent::afterSave();
    }

    /**
     * löscht den UserRole Eintrag + ElternKind Verknüpfung + Kinder
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean Rückgabewert der Elternklassemethoden
     */
    public function beforeDelete() {
        $userRole = UserRole::model()->findByAttributes(array('user_id' => $this->id));
        $userRole->delete();
        $a_appointment = Appointment::model()->findAllByAttributes(array('user_id' => $this->id));
        for ($x = 0; $x < count($a_appointment); $x++) {
            $a_appointment[$x]->delete();
        }
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
        return parent::beforeDelete();
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean Rückgabewert der parent methode
     *  verschlüsselt das Passwort und generiert einen Aktivierungsschlüssel, setzt die E-Mail Adresse als Username fest
     */
    public function beforeSave() {
        if ($this->isNewRecord) {
            if (Yii::app()->user->isGuest) {
                $this->state = 0;
            }
            $this->activationKey = self::generateActivationKey();
            $this->username = $this->email;
            $this->lastname = ucfirst($this->lastname);
            $this->firstname = ucfirst($this->firstname);
            $this->password = $this->encryptPassword($this->password, Yii::app()->params["salt"]);
        } else if (!$this->isNewRecord && $this->password == User::model()->findByAttributes(array('id' => $this->id, 'password' => $this->password))) {
            
        } else if (!$this->isNewRecord && $this->password == "dummyPassworddummyPassword") {
            $this->password = User::model()->findByAttributes(array('id' => $this->id))->password;
        } else {
            $this->password = $this->encryptPassword($this->password, Yii::app()->params["salt"]);
        }
        return parent::beforeSave();
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * Generiert einen Aktivierungsschlüssel und speichert diesen im aktuellen Objekt
     */
    public function generateActivationKey() {
        return sha1(mt_rand(10000, 99999) . time() . $this->email);
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return string 0=NichtAktiv 1=Aktiv 2=Gesperrt
     */
    public function getStateName() {
        switch ($this->state) {
            case 0:
                $this->stateName = 'Nicht aktiv';
                break;
            case 1:
                $this->stateName = 'Aktiv';
                break;
            case 2:
                $this->stateName = 'Gesperrt';
                break;
            default:
                $this->stateName = $this->state;
        }
        return $this->stateName;
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param integer $stateId Status ID des Users
     */
    static public function getFormattedState($state) {
        switch ($state) {
            case '0':
                echo 'Nicht aktiv';
                break;
            case '1':
                echo 'Aktiv';
                break;
            case '2':
                echo 'Gesperrt';
                break;
        }
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param integer $role Rollen ID des Users
     *  0 = Admin 1=Verwaltung 2=Lehrer 3= Eltern
     */
    static public function getFormattedRole($role) {
        $role = Role::model()->findByAttributes(array('id' => $role));
        echo $role->title;
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     * Führt zunächst die Elternmethode beforeValidate() aus und 
     * prüft wenn diese true zurückgibt und es keiner neuer Eintrag ist ob die TAN schon benutzt wurde 
     */
    public function beforeValidate() {
        $rc = parent::beforeValidate();
        if ($rc && Yii::app()->user->isGuest && $this->isNewRecord) {
            $tan = Tan::model()->findByAttributes(array('tan' => $this->tan));
            if ($tan !== null) {
                if ($tan->used) {
                    $this->addError('tan', 'Leider wurde Ihre TAN schon benutzt.');
                }
            } else {
                $this->addError('tan', 'Leider konnte die eingegebene TAN nicht identifiziert werden.');
            }
        }
        return $rc;
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param integer $userId Benutzer ID
     * @param integer $roleId Rollen ID
     * @return boolean
     * gibt true zurück wenn der gegebene Benutzer die entsprechende ROlle hat
     */
    public static function hasRole($userId, $roleId) {
        $rc = false;
        if (is_int($userId) && is_int($roleId) && UserRole::model()->countByAttributes(
                        array('user_id' => $userId, 'role_id' => $roleId)) == 1) {
            $rc = true;
        }
        return $rc;
    }

}