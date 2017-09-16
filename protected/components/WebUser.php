<?php

/**
 * Repräsentiert den persistenten Status eines Benutzers
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

/**
 * Webuser überschreibt CWebuser und überschreibt u.a. die Methode checkAccess
 * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
 */
class WebUser extends CWebUser
{

    /**
     * Überschreibt eine Yii Methode, welche für die Zugriffsberechtigung
     *  in Controllern verwendet wird (accessRules)
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param string $role RollenID
     * @param mixed $params (opt) Muss gesetzt werden durch Vererbung
     * @return bool Permission granted?
     */
    public function checkAccess($role, $params = array())
    {
        if (!is_numeric($this->id)) {
            return false;
        }
        if ($this->getState('role') == ADMIN) {
            return true;
        }
        return ($role === $this->getState('role'));
    }

    /**
     * Prüft ob ein User eine der beiden Rollen hat
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param integer $role1 Benötigte Rolle
     * @param integer $role2 Benötigte Rolle
     * @return boolean Falls eine Operation mit der UserRolle übereinstimmt gibts true
     */
    public function checkAccessRole($role1, $role2)
    {
        if (!is_numeric($role1)) {
            return false;
        }
        return ($role1 === $this->getState('role') || $role2 === $this->getState('role'));
    }

    /**
     * Prüft ob ein Benutzer der Rolle zugewiesen wurde und ob er nicht Admin ist
     * @param integer $role Rolle die der Benutzer haben sollte
     * @return boolean
     */
    public function checkAccessNotAdmin($role)
    {
        $rc = false;
        if ($this->checkAccess($role) && !$this->isAdmin()) {
            $rc = true;
        }
        return $rc;
    }

    /**
     * ist der Benutzer ein Administrator?
     * @author Christian Ehringfeld <c.ehringfeld@t-online,de>
     * @return boolean selbsterklärend
     */
    public function isAdmin()
    {
        return $this->checkRole(ADMIN);
    }

    /**
     * Methode fuer isGuest
     * @return boolean
     */
    public function isGuest()
    {
        return $this->isGuest;
    }

    public function isManager()
    {
        return $this->checkRole(MANAGEMENT);
    }

    public function isParent()
    {
        return $this->checkRole(PARENTS);
    }

    public function isTeacher()
    {
        return $this->checkRole(TEACHER);
    }
    
    private function checkRole($roleId)
    {
        if (is_numeric($this->id) && $this->getState('role') == $roleId) {
            return true;
        }
        return false;
    }

    /**
     * returns all groups which set as state for the user
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array all user groups
     */
    public function getGroups()
    {
        return $this->getState('groups');
    }

    public function getStateVariable()
    {
        return $this->getState('state');
    }

    private function setDynamicSessionVariables($state, $role, $groups = array())
    {
        $this->setState('state', $state);
        $this->setState('role', $role);
        if (Yii::app()->params['allowGroups']) {
            $this->setState('groups', $groups);
        }
    }

    public function updateSession($user = false)
    {
        if (!$user) {
            $criteria = new CDbCriteria();
            $criteria->select = array('id', 'state', 'email', 'role');
            $criteria->together = false;
            if (Yii::app()->params['allowGroups']) {
                $criteria->together = true;
                $criteria->with = array('groups');
            }
            $user = User::model()->findByPk($this->getId(), $criteria);
        }
        $this->setDynamicSessionVariables($user->state, $user->role, (Yii::app()->params['allowGroups'] ? $user->groups : array()));
    }
}
