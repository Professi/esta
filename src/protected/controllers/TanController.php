<?php

class TanController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
//            array('allow',
//                'actions' => array('create', 'update'),
//                'roles' => array('2'),
//            ),
            array('allow',
                'actions' => array('admin', 'genTans'),
                'roles' => array('1'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Tan;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Tan'])) {
            $model->attributes = $_POST['Tan'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->tan));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionGenTans() {
        $model = new Tan();
        if (isset($_POST['Tan']) && Yii::app()->session['isTanGen'] != 1) {
            $model->attributes = $_POST['Tan'];
            if ($model->validate()) {
                Yii::app()->session['isTanGen'] = 1;
                $dataProvider = new CArrayDataProvider(self::generateTan($model->tan_count), array('pagination' => array('pageSize' => Yii::app()->params['maxTanGen'])));
                $this->render('showGenTans', array('dataProvider' => $dataProvider));
            } else {
                $this->render('formGenTans', array('model' => $model));
            }
        } else {
            if (isset(Yii::app()->session['isTanGen'])) {
                unset(Yii::app()->session['isTanGen']);
            }
            $this->render('formGenTans', array('model' => $model));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Tan'])) {
            $model->attributes = $_POST['Tan'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->tan));
        }

        $this->render('update', array(
            'model' => $model,
        ));
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
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Tan');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Tan('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Tan']))
            $model->attributes = $_GET['Tan'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Tan the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Tan::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Tan $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'tan-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function generateTan($count) {
        $a_rc = array();
        for ($i = 0; $i < $count; ++$i) {
            $tan = new Tan;
            $sTan = "";
            for ($x = 0; $x < Yii::app()->params['tanSize']; ++$x) {
                $sTan .= rand(0, 9);
            }
            $tan->tan = $sTan;
            $tan->used = false;
            $tan->tan_count = 1;
            if (strlen($tan->tan) == Yii::app()->params['tanSize'] && Tan::model()->countByAttributes(array('tan' => $tan->tan)) == 0) {
                if ($tan->save()) {
                    $tan->id = $i;
                    $a_rc[] = $tan;
                }
            } else {
                --$i;
            }
        }
        return $a_rc;
    }

}
