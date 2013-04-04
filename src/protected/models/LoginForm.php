<?php

/**
 * LoginForm class. LoginForm is the data structure for keeping user login form data. It is used by the 'login' action of 'SiteController'.
 */
/* Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
class LoginForm extends CFormModel {

    /** @var string E-Mail */
    public $email;

    /** @var string Passwort */
    public $password;

    /** @var string Anmeldenamen merken */
    public $rememberMe;
    
    /** @var string Spambotfilter */
    public $text;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('email, password', 'required'),
            array('rememberMe', 'boolean'),
            array('password', 'authenticate'),
            array('text', 'length', 'max'=>0),
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
     * Authentifiziert einen Benutzer
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean Gibt zurück ob ein Benutzer authentifiziert werden konnte
     */
    public function authenticate() {
        $rc = false;
        if (!$this->hasErrors()) {
            $identity = new UserIdentity($this->email, $this->password);
            $identity->authenticate();
            switch ($identity->errorCode) {
                case UserIdentity::ERROR_NONE:
                    $duration = $this->rememberMe ? 3600 * 24 * 7 : 0;
                    Yii::app()->user->login($identity, $duration);
                    $rc = true;
                    break;
                case UserIdentity::ERROR_USERNAME_INVALID:
                    $this->addError('email', UserIdentity::ERROR_MSG_USERNAME_INVALID);
                    break;
                case UserIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError('password', UserIdentity::ERROR_MSG_PASSWORD_INVALID);
                     $this->addError('error', $identity->errorMessage);
                    break;
                default:
                    $this->addError('error', $identity->errorMessage);
            }
        }
        return $rc;
    }

}