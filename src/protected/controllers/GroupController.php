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
                'actions' => array('search'),
                'roles' => array('1'),
            ),
            array('allow',
                'actions' => array('create', 'delete', 'admin', 'search', 'view', 'update'),
                'roles' => array('0'),
            ),
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

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Date the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Group::model()->findByPk($id);
        if ($model === null)
            $this->throwFourNullFour();
        return $model;
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

}

?>
