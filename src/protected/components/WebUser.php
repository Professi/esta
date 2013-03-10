<?php

/**
 *
 * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
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

    public function checkAccessRole($operation1, $operation2) {
        if (empty($this->id)) {
            return false;
        }
        return ($operation1 === $this->getState('role') || $operation2 == $this->getState('role'));
    }

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
