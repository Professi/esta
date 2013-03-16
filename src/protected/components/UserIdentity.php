<?php
/**Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    const ERROR_MSG_USERNAME_INVALID = "Ungültige E-Mail Adresse";
    const ERROR_MSG_PASSWORD_INVALID = "Falsches Passwort";
    const ERROR_MSG_ACCOUNT_NOT_ACTIVATED = "Ihr Benutzerkonto wurde noch nicht aktiviert. Bitte nutzen Sie den Aktivierungslink, der Ihnen per E-Mail zugesandt wurde. Sollten Sie Probleme haben, füllen Sie bitte das Kontaktformular aus. ";
    const ERROR_MSG_ACCOUNT_BANNED = "Ihr Benutzerkonto wurde gesperrt. Bitte wenden Sie sich an die Schulverwaltung.";
    const ERROR_ACCOUNT_NOT_ACTIVATED = 3;
    const ERROR_ACCOUNT_BANNED = 4;

    private $_id;

    /**
     * Authentifiziert einen Benutzer
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return integer gibt einen Fehlercode zurück
     */
    public function authenticate() {
        $user = User::model()->findByAttributes(array('email' => $this->username));
        if ($user === null) { // No user found!
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            $this->errorMessage = self::ERROR_MSG_USERNAME_INVALID;
        } else if ($user->password !== User::encryptPassword($this->password, Yii::app()->params["salt"])) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            $this->errorMessage = self::ERROR_MSG_PASSWORD_INVALID;
        } else {
            if ($user->state == 0) {
                $this->errorCode = self::ERROR_ACCOUNT_NOT_ACTIVATED;
                $this->errorMessage = self::ERROR_MSG_ACCOUNT_NOT_ACTIVATED;
            } else if ($user->state == 2) {
                $this->errorCode = self::ERROR_ACCOUNT_BANNED;
                $this->errorMessage = self::ERROR_MSG_ACCOUNT_BANNED ;
            } else {
                $this->errorCode = self::ERROR_NONE;
                $this->_id = $user->id;
                $userRole = UserRole::model()->findByAttributes(array('user_id' => $this->_id));
                $this->setState('state', $user->state);
                $this->setState('role',  $userRole->role_id);
            }
        }
        return $this->errorCode;
    }
    
    public function getId() {
        return $this->_id;
    }
    
}