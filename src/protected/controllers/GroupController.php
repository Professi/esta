<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
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

}

?>
