<?php

/**
 * UserIdentity repräsentiert die Daten die nötig sind um einen Benutzer zu identifizieren.
 */

/**
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
/* * Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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

class UserIdentity extends CUserIdentity
{
    const ERROR_ACCOUNT_NOT_ACTIVATED = 3;
    const ERROR_ACCOUNT_BANNED = 4;

    /** @var integer ID */
    private $_id;

    /**
     * authenticates a user
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return integer errorcode
     */
    public function authenticate()
    {
        $criteria = new CDbCriteria(array('together'=>false,'with'=>false));
        $user = User::model()->findByAttributes(array('email' => $this->username), $criteria);
        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            $this->errorMessage = Yii::t('app', "Ungültige E-Mail Adresse");
        } elseif ($user->state == NOT_ACTIVE) {
            $this->errorCode = self::ERROR_ACCOUNT_NOT_ACTIVATED;
            $this->errorMessage = Yii::t('app', "Ihr Benutzerkonto wurde noch nicht aktiviert. Bitte nutzen Sie den Aktivierungslink, der Ihnen per E-Mail zugesandt wurde. Sollten Sie Probleme haben, füllen Sie bitte das Kontaktformular aus.");
        } elseif ($user->state == ACTIVE && !$user->verifyPassword($this->password)) {
            $this->invalidPassword($user);
        } elseif ($user->state == BLOCKED) {
            if (empty($user->bannedUntil) || $user->bannedUntil == 0) {
                $this->errorCode = self::ERROR_ACCOUNT_BANNED;
                $this->errorMessage = Yii::t('app', "Ihr Benutzerkonto wurde gesperrt. Bitte wenden Sie sich an die Schulverwaltung.");
            } else {
                $time = time();
                if ($user->bannedUntil > $time) {
                    $this->errorCode = self::ERROR_ACCOUNT_BANNED;
                    $this->errorMessage = Yii::t('app', "Ihr Benutzerkonto ist noch für {sekunden} Sekunden gesperrt.", array('{sekunden}' => ($user->bannedUntil - $time)));
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
    public function unbanUser(&$user)
    {
        $user->state = ACTIVE;
        $user->bannedUntil = 0;
        $user->badLogins = 0;
    }

    /**
     * Loggt einen Benutzer ein und aktualisiert lastLogin
     * @param User &$user User Objekt
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function login(&$user)
    {
        $this->errorCode = self::ERROR_NONE;
        $this->errorMessage = '';
        $this->_id = $user->getPrimaryKey();
        Yii::app()->user->updateSession($user);
        $user->lastLogin = time();
        $user->badLogins = 0;
        $user->update();
    }

    /**
     * Fehlermeldungen bei ungültigem Passwort, Zählt Fehllogins und sperrt eventuell den Benutzer
     * @param User &$user User Objekt
     */
    public function invalidPassword(&$user)
    {
        $this->errorCode = self::ERROR_PASSWORD_INVALID;
        $this->errorMessage = Yii::t('app', "Falsches Passwort");
        if (Yii::app()->params['banUsers']) {
            $user->badLogins = $user->badLogins + 1;
            if ($user->badLogins == Yii::app()->params['maxAttemptsForLogin']) {
                $user->state = BLOCKED;
                $user->bannedUntil = time() + Yii::app()->params['durationTempBans'] * 60;
                $this->errorMessage = Yii::t('app', "Falsches Passwort!") . ' ' . Yii::t('app', "Ihr Benutzerkonto wurde für {n} Minuten gesperrt.", array(Yii::app()->params['durationTempBans']));
            } else {
                $this->errorMessage = Yii::t('app', "Falsches Passwort!") . ' '
                        . Yii::t('app', "n==1#Ihnen verbleibt noch ein Versuch.|n>1#Ihnen verbleiben noch {n} Versuche.", array((Yii::app()->params['maxAttemptsForLogin'] - $user->badLogins))) . ' '
                        . Yii::t('app', "Sobald alle Versuche aufgebraucht sind, wird Ihr Konto temporär gesperrt.");
            }
            $user->update();
        }
    }

    /**
     * Liefert die Benutzer ID
     * @return integer ID
     */
    public function getId()
    {
        return $this->_id;
    }
}
