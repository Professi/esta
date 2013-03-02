<?php

/**
 * Description of NWebUser
 *
 * @author cehringfeld
 */
class NewWebUser extends CWebUser {

    /**
     * @var boolean whether to enable cookie-based login. Defaults to false.
     */
    public $allowAutoLogin = true;

    /**
     * @var string|array the URL for login. If using array, the first element should be
     * the route to the login action, and the rest name-value pairs are GET parameters
     * to construct the login URL (e.g. array('/site/login')). If this property is null,
     * a 403 HTTP exception will be raised instead.
     * @see CController::createUrl
     */
    public $loginUrl = array('/user/login');

    public function getRole() {
        return $this->getState('__role');
    }

    public function getId() {
        return $this->getState('__id') ? $this->getState('__id') : 0;
    }
/*
    protected function beforeLogin($id, $states, $fromCookie)
    {
        parent::beforeLogin($id, $states, $fromCookie);

        $model = new UserLoginStats();
        $model->attributes = array(
            'user_id' => $id,
            'ip' => ip2long(Yii::app()->request->getUserHostAddress())
        );
        $model->save();

        return true;
    } */
    /*
      protected function afterLogin($fromCookie)
      {
      parent::afterLogin($fromCookie);
      $this->updateSession();
      } */
      public function afterLogin($fromCookie) {
        parent::afterLogin($fromCookie);

        // Mark the user as a superuser if necessary.
        if (Rights::getAuthorizer()->isSuperuser($this->getId()) === true)
            $this->isSuperuser = true;
    }
    
    
    public function updateSession() {
        $user = Yii::app()->getModule('user')->user($this->id);
        $this->name = $user->username;
        $userAttributes = CMap::mergeArray(array(
                    'email' => $user->email,
                    'username' => $user->username,
                    'create_at' => $user->create_at,
                    'lastvisit_at' => $user->lastvisit_at,
                        ), $user->profile->getAttributes());
        foreach ($userAttributes as $attrName => $attrValue) {
            $this->setState($attrName, $attrValue);
        }
    }

    public function model($id = 0) {
        return Yii::app()->getModule('user')->user($id);
    }

    public function user($id = 0) {
        return $this->model($id);
    }

    public function getUserByName($username) {
        return Yii::app()->getModule('user')->getUserByName($username);
    }

    public function getAdmins() {
        return Yii::app()->getModule('user')->getAdmins();
    }

    public function isAdmin() {
        return Yii::app()->getModule('user')->isAdmin();
    }



    /**
     * Performs access check for this user.
     * Overloads the parent method in order to allow superusers access implicitly.
     * @param string $operation the name of the operation that need access check.
     * @param array $params name-value pairs that would be passed to business rules associated
     * with the tasks and roles assigned to the user.
     * @param boolean $allowCaching whether to allow caching the result of access checki.
     * This parameter has been available since version 1.0.5. When this parameter
     * is true (default), if the access check of an operation was performed before,
     * its result will be directly returned when calling this method to check the same operation.
     * If this parameter is false, this method will always call {@link CAuthManager::checkAccess}
     * to obtain the up-to-date access result. Note that this caching is effective
     * only within the same request.
     * @return boolean whether the operations can be performed by this user.
     */
    public function checkAccess($operation, $params = array(), $allowCaching = true) {
        // Allow superusers access implicitly and do CWebUser::checkAccess for others.
        return $this->isSuperuser === true ? true : parent::checkAccess($operation, $params, $allowCaching);
    }

    /**
     * @param boolean $value whether the user is a superuser.
     */
    public function setIsSuperuser($value) {
        $this->setState('Rights_isSuperuser', $value);
    }

    /**
     * @return boolean whether the user is a superuser.
     */
    public function getIsSuperuser() {
        return $this->getState('Rights_isSuperuser');
    }

    /**
     * @param array $value return url.
     */
    public function setRightsReturnUrl($value) {
        $this->setState('Rights_returnUrl', $value);
    }

    /**
     * Returns the URL that the user should be redirected to 
     * after updating an authorization item.
     * @param string $defaultUrl the default return URL in case it was not set previously. If this is null,
     * the application entry URL will be considered as the default return URL.
     * @return string the URL that the user should be redirected to 
     * after updating an authorization item.
     */
    public function getRightsReturnUrl($defaultUrl = null) {
        if (($returnUrl = $this->getState('Rights_returnUrl')) !== null)
            $this->returnUrl = null;

        return $returnUrl !== null ? CHtml::normalizeUrl($returnUrl) : CHtml::normalizeUrl($defaultUrl);
    }

}

?>
