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
 * @property integer $status
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
            array('status', 'numerical', 'integerOnly' => true),
            array('firstname, lastname, email', 'length', 'max' => 45),
            array('password', 'length', 'max' => 128),
            array('password', 'compare', "on" => "insert"),
            array('password_repeat', 'safe'), //allow bulk assignment 
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, firstname, status, lastname, email', 'safe', 'on' => 'search'),
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
            'userRoles' => array(self::HAS_MANY, 'UserRole', 'user_id'),
        );
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return encrypted and salted password with sha512
     * @todo Unbedingt noch ändern in andere Verschlüsselung in Salt!
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
        if ($name == "password")
            $this->pwdChanged = true;
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
            'status' => 'Status',
            'lastname' => 'Nachname',
            'email' => 'E-Mail',
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
        $criteria->compare('status', $this->status);
        $criteria->compare('lastname', $this->lastname, true);
        $criteria->compare('email', $this->email, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'createtime',
            )
        );
    }

 public function beforeSave() {
        if ($this->isNewRecord) {
            if(Yii::app()->user->isGuest) {
                $this->status=0; 
            }
            $this->activationKey = sha1(mt_rand(10000, 99999) . time() . $this->email);
            $this->username = $this->email;
            $this->password = $this->encryptPassword($this->password, Yii::app()->params["salt"]);
        }
        if ($this->pwdChanged&&!$this->isNewRecord) {
            $this->password = $this->encryptPassword($this->password, Yii::app()->params["salt"]);
        }

        return parent::beforeSave();
    }

}