<?php

/**
 *
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
class WebUser extends CWebUser {

    /**
     * Overrides a Yii method that is used for roles in controllers (accessRules).
     *
     * @param string $operation Name of the operation required (here, a role).
     * @param mixed $params (opt) Parameters for this operation, usually the object to access.
     * @return bool Permission granted?
     */
    public function checkAccess($operation, $params = array()) {
        if (empty($this->id)) {
            return false;
        }

        if ($this->getState("role") == 0) {
            return true;   //Admin darf immer alles
        }
        return ($operation === $this->getState('role'));
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param integer $operation1 Benötigte Rolle oder $operation2
     * @param integer $operation2 Benötigte Rolle
     * @return boolean Falls eine Operation mit der UserRolle übereinstimmt gibts true
     */
    public function checkAccessRole($operation1, $operation2) {
        if (empty($this->id)) {
            return false;
        }
        return ($operation1 === $this->getState('role') || $operation2 == $this->getState('role'));
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online,de>
     * @return boolean selbsterklärend
     */
    public function isAdmin() {
        if (empty($this->id)) {
            return false;
        }
        if ($this->getState("role") == 0) {
            return true;   //Admin darf immer alles
        }
    }

}

?>
