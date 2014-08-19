<?php
/* Copyright (C) 2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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

class GroupController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * Filter
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'roles' => array('1')),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        $this->redirectUrl();
    }

    /**
     * action for deleting usergroup
     * @param integer $id
     */
    public function actionDeleteUserGroup($id) {
        $this->loadModelUserGroup($id)->delete();
        $this->redirectUrl();
    }

    /**
     * action to delete DateGroup
     * @param integer $id
     */
    public function actionDeleteDateGroup($id) {
        $this->loadModelDateGroup($id)->delete();
        $this->redirectUrl();
    }

    /**
     * redirect Url 
     */
    public function redirectUrl() {
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Date the loaded model
     */
    public function loadModel($id) {
        $model = Group::model()->findByPk($id);
        $this->checkModelNull($model);
        return $model;
    }

    /**
     * returns $model for DateHasGroup
     * @param integer $id
     * @return DateHasGroup
     */
    public function loadModelDateGroup($id) {
        $model = DateHasGroup::model()->findByPk($id);
        $this->checkModelNull($model);
        return $model;
    }

    /**
     * returns model for UserHasGroup
     * @param integer $id
     * @return UserHasGroup
     */
    public function loadModelUserGroup($id) {
        $model = UserHasGroup::model()->findByPk($id);
        $this->checkModelNull($model);
        return $model;
    }

    /**
     * checks if model for null 
     * @param Object $model
     */
    public function checkModelNull($model) {
        if ($model == null) {
            $this->throwFourNullFour();
        }
    }

    /**
     * Performs the AJAX validation.
     * @param Date $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'date-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Group;
        if (isset($_POST['Group'])) {
            $model->attributes = $_POST['Group'];
            if ($model->save()) {
                $this->redirect(array('admin'));
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['Group'])) {
            $model->attributes = $_POST['Group'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->render('admin');
    }

    public function actionOverview() {
        $model = new Group('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Group'])) {
            $model->attributes = $_GET['Group'];
        }
        $this->renderPartial('overview', array(
            'model' => $model),false,true);
    }

    /**
     * echo CJSON for groups with their ids over $_GET['ids']
     */
    public function actionGetGroupsByIds() {
        $groups = Group::model()->findAll("id IN (" . $_GET['ids'] . ")");
        $results = array();
        foreach ($groups as $g) {
            $results[] = array(
                'id' => $p->id,
                'text' => $g->groupname
            );
        }
        echo CJSON::encode($results);
        Yii::app()->end();
    }
    
    public function actionAssign() {
        $users = array();
        $groups = array();
        $crit = new CDbCriteria();
        $crit->addCondition('role = :role1', 'OR');
        $crit->addCondition('role = :role2', 'OR');
        $crit->params = array(':role1'=>2,':role2'=>3);
        foreach(User::model()->findAll($crit) as $user) {
            $desc = (empty($user->title)) ? '' : "{$user->title} ";
            $desc .= "{$user->firstname} {$user->lastname}";
            $users[$user->id] = $desc;
        }
        foreach(Group::model()->findAll() as $group) {
            $groups[$group->id] = $group->groupname;
        }
        $this->render('assign', array('groups' => $groups, 'users' => $users));
    }

}

?>
