<?php

/**
 * Formmodel für die Vergabe eines neuen Passwortes
 * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
 */

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
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class NewPw extends CFormModel {

    /** @var string Passwort */
    public $password;
    /** @var string Passwortwiederholung */
    public $password_repeat;
    /** @var string Aktivierungsschlüssel des Benutzers standardmäßig sha1 */
    public $activationKey;

    /**
     * Regeln fuer die Validierung
     * @return array Regeln
     */
    public function rules() {
        return array(
            array('password','required'),
            array('password', 'length', 'max' => 128, 'min' => 8),
            array('password', 'compare', "on" => "insert"),
            array('password_repeat', 'safe'), //allow bulk assignment 
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'password' => 'Passwort',
            'password_repeat' => 'Passwort wiederholen',
        );
    }

}

?>
