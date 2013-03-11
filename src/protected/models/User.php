<?php

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
 *
 * The followings are the available model relations:
 * @property Appointment[] $appointments
 * @property ParentChild[] $parentChildren
 * @property UserRole[] $userRoles
 */
class User extends CActiveRecord {

    public $password_repeat = null;
    public $pwdChanged = false;
    public $role = null;
    public $roleName = null;
    public $stateName = null;
    public $oldPw = null;

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
            array('password', 'compare', "on" => "insert"),
            array('password_repeat', 'safe'), //allow bulk assignment 
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
     * @return encrypted and salted password with sha512
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
            'state' => 'Status ID',
            'stateName' => 'Status',
            'lastname' => 'Nachname',
            'email' => 'E-Mail',
            'createtime' => 'Registrierungsdatum',
            'role' => 'RollenID',
            'roleName' => 'Rolle'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('firstname', $this->firstname, true);
        $criteria->compare('state', $this->state);
        $criteria->compare('lastname', $this->lastname, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('stateName', $this->stateName, true);
        $criteria->compare('roleName', $this->roleName, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 20),
        ));
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
            $userRole = New UserRole();
            $userRole->user_id = $this->id;
            if (Yii::app()->user->isGuest) {
                $userRole->role_id = Role::model()->findByAttributes(array('title' => 'Eltern'))->id;
            } else {
                $userRole->role_id = Role::model()->findByAttributes(array('id' => $this->role))->id;
            }
            $userRole->save();
        }
        return parent::afterSave();
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean Rückgabewert der Elternklassemethoden
     * löscht den UserRole Eintrag
     */
    public function beforeDelete() {
        $userRole = UserRole::model()->findByAttributes(array('user_id' => $this->id));
        $userRole->delete();
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
            $this->activationKey = sha1(mt_rand(10000, 99999) . time() . $this->email);
            $this->username = $this->email;
            $this->password = $this->encryptPassword($this->password, Yii::app()->params["salt"]);
        } else if (!$this->isNewRecord && $this->password == $this->oldPw) {
        } else {
            $this->password = $this->encryptPassword($this->password, Yii::app()->params["salt"]);
        }
        return parent::beforeSave();
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param integer $stateId Status ID des Users
     * @return string 0=NichtAktiv 1=Aktiv 2=Gesperrt
     */
    public function getStateName() {
        switch ($this->state) {
            case '0':
                $this->stateName = 'Nicht aktiv';
                break;
            case '1':
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

}