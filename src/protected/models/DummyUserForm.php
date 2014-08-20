<?php

/* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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

class DummyUserForm extends CFormModel {

    public $username;
    public $firstname;
    public $lastname;
    public $state;
    public $role;

    /**
     * validation rules
     * @return array
     */
    public function rules() {
        return array(
            array('firstname,lastname', 'required'),
        );
    }

    /**
     * validation rules
     * @return array
     */
    public function attributeLabels() {
        return array(
            'username' => Yii::t('app', 'Benutzername'),
            'firstname' => Yii::t('app', 'Vorname'),
            'lastname' => Yii::t('app', 'Nachname'),
            'state' => Yii::t('app', 'Status'),
            'role' => Yii::t('app', 'Rolle'),
        );
    }

    /**
     * inserts dummy user with firstname and lastname
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function insert() {
        $user = new User();
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->state = 0;
        $user->role = 3;
        $user->password = 0;
        $this->username = substr($this->lastname, 0, 3) . substr($this->firstname, 0, 3);
        $counter = 0;
        $user->username = $this->username;
        while (User::model()->countByAttributes(array('username' => $this->username)) > 0) {
            $counter++;
            $this->username = $user->username . $counter;
        }
        $user->username = $this->username;
        if ($user->insert()) {
            Yii::app()->user->setFlash('success', Yii::t('app', 'Pseudobenutzer erstellt.'));
        }
    }
}

?>
