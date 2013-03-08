<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {

    public $email;
    public $password;
    public $rememberMe;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('email, password', 'required'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => 'Anmeldenamen merken',
            'email' => 'E-Mail',
            'password' => 'Passwort',
        );
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean Gibt zurück ob ein Benutzer authentisiert werden konnte
     */
    public function authenticate() {
        $rc = false;
        if (!$this->hasErrors()) {  // we only want to authenticate when no input errors
            $identity = new UserIdentity($this->email, $this->password);
            $identity->authenticate();
            switch ($identity->errorCode) {
                case UserIdentity::ERROR_NONE:
                    $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
                    Yii::app()->user->login($identity, $duration);
                    $rc = true;
                    break;
                case UserIdentity::ERROR_USERNAME_INVALID:
                    $this->addError('email', UserIdentity::ERROR_MSG_USERNAME_INVALID);
                    break;
                case UserIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError('password', UserIdentity::ERROR_MSG_PASSWORD_INVALID);
                    break;
                default:
                    $this->addError('error', $identity->errorMessage);
            }
        }

        return $rc;
    }

    
}