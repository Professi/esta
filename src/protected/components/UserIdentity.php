<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;
    private $_roleId;
    private $_state;

    /**
     * Authentifiziert einen Benutzer
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean gibt zurück ob ein Benutzer erfolgreich authentifiziert werden konnte.
     * @todo State noch buggy
     */
    public function authenticate() {
        $user = User::model()->findByAttributes(array('email' => $this->username));
        if ($user === null) { // No user found!
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if ($user->password !== User::encryptPassword($this->password, Yii::app()->params["salt"])) { // Invalid password!
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else if ($user->state === 0) {
            $this->errorCode = true;
            $this->errorMessage = "Ihr Benutzerkonto wurde noch nicht aktiviert.";
        } else if ($user->state === 2) {
            $this->errorCode = true;
            $this->errorMessage = "Ihr Benutzerkonto wurde gesperrt.";
        } else {
            $this->errorCode = self::ERROR_NONE;
            $this->_id = $user->id;
            $userRole = UserRole::model()->findByAttributes(array('user_id' => $this->_id));
            $this->_roleId = $userRole->role_id;
            $this->_state = $user->state;
        }
        return !$this->errorCode;
        //broken
    }

    // public function 
    // public const var "ERROR_ACCOUNT_NOT_ACTIVATED"=2;

    public function getId() {
        return $this->_id;
    }

}