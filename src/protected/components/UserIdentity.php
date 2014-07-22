<?php

/**
 * UserIdentity repräsentiert die Daten die nötig sind um einen Benutzer zu identifizieren.
 */

/**
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
/* * Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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

class UserIdentity extends CUserIdentity {

    const ERROR_MSG_USERNAME_INVALID = "Ungültige E-Mail Adresse";
    const ERROR_MSG_PASSWORD_INVALID = "Falsches Passwort";
    const ERROR_MSG_ACCOUNT_NOT_ACTIVATED = "Ihr Benutzerkonto wurde noch nicht aktiviert. Bitte nutzen Sie den Aktivierungslink, der Ihnen per E-Mail zugesandt wurde. Sollten Sie Probleme haben, füllen Sie bitte das Kontaktformular aus. ";
    const ERROR_MSG_ACCOUNT_BANNED = "Ihr Benutzerkonto wurde gesperrt. Bitte wenden Sie sich an die Schulverwaltung.";
    const ERROR_ACCOUNT_NOT_ACTIVATED = 3;
    const ERROR_ACCOUNT_BANNED = 4;

    /** @var integer ID */
    private $_id;

    /**
     * authenticates a user
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return integer errorcode
     */
    public function authenticate() {
        $user = User::model()->findByAttributes(array('email' => $this->username));
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            $this->errorMessage = self::ERROR_MSG_USERNAME_INVALID;
        } else if ($user->state == 0) {
            $this->errorCode = self::ERROR_ACCOUNT_NOT_ACTIVATED;
            $this->errorMessage = self::ERROR_MSG_ACCOUNT_NOT_ACTIVATED;
        } else if ($user->state == 1 && !$user->verifyPassword($this->password)) {
            $this->invalidPassword($user);
        } else if ($user->state == 2) {
            if (is_null($user->bannedUntil) || $user->bannedUntil == 0) {
                $this->errorCode = self::ERROR_ACCOUNT_BANNED;
                $this->errorMessage = self::ERROR_MSG_ACCOUNT_BANNED;
            } else {
                $time = time();
                if ($user->bannedUntil > $time) {
                    $this->errorCode = self::ERROR_ACCOUNT_BANNED;
                    $this->errorMessage = "Ihr Benutzerkonto ist noch für " . ($user->bannedUntil - $time) . " Sekunden gesperrt";
                } else {
                    $this->unbanUser($user);
                }
            }
        }
        if (empty($this->errorMessage)) {
            $this->login($user);
        }
        return $this->errorCode;
    }

    /**
     * @param User &$user User Objekt
     * entbannt einen Benutzer
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function unbanUser(&$user) {
        $user->state = 1;
        $user->bannedUntil = 0;
        $user->badLogins = 0;
    }

    /**
     * Loggt einen Benutzer ein und aktualisiert lastLogin
     * @param User &$user User Objekt
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function login(&$user) {
        $this->errorCode = self::ERROR_NONE;
        $this->errorMessage = '';
        $this->_id = $user->getPrimaryKey();
        $userRole = UserRole::model()->findByAttributes(array('user_id' => $this->_id));
        $this->setState('state', $user->state);
        $this->setState('role', $userRole->role_id);
        if (Yii::app()->params['allowGroups']) {
            $this->setState('groups', $user->groups);
        }
        $user->lastLogin = time();
        $user->badLogins = 0;
        $user->update();
    }

    /**
     * Fehlermeldungen bei ungültigem Passwort, Zählt Fehllogins und sperrt eventuell den Benutzer
     * @param User &$user User Objekt
     */
    public function invalidPassword(&$user) {
        $this->errorCode = self::ERROR_PASSWORD_INVALID;
        $this->errorMessage = self::ERROR_MSG_PASSWORD_INVALID;
        if (Yii::app()->params['banUsers']) {
            $user->badLogins++;
            if ($user->badLogins == Yii::app()->params['maxAttemptsForLogin']) {
                $user->state = 2;
                $user->bannedUntil = time() + Yii::app()->params['durationTempBans'] * 60;
                $this->errorMessage = "Falsches Passwort! Ihr Benutzerkonto wurde für " . Yii::app()->params['durationTempBans'] . " Minuten gesperrt.";
            } else {
                $this->errorMessage = "Falsches Passwort! Ihnen verbleiben noch " .
                        (Yii::app()->params['maxAttemptsForLogin'] - $user->badLogins) .
                        " Versuche. Sobald alle Versuche aufgebraucht sind, wird ihr Konto temporär gesperrt.";
            }
            $user->update();
        }
    }

    /**
     * Liefert die Benutzer ID
     * @return integer ID
     */
    public function getId() {
        return $this->_id;
    }

}