<?php
/**
 * Dies ist die Controller Klasse vom Model Date.
 */
/* Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
class DateController extends Controller {

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
                'actions' => array('create', 'delete', 'admin', 'search','view','update'),
                'roles' => array('0'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    /**
     * Suchaction für das Autocomplete für die Verwaltung um Termine einzutragen
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param string $term
     * 
     */
    public function actionSearch($term) {
        $dataProvider = new DateAndTime();
        $dataProvider->unsetAttributes();
        $dataProvider->time = $term;
        $criteria = $dataProvider->searchDateAndTime();
        $a_rc = array();
        $a_data = DateAndTime::model()->findAll($criteria);
        foreach ($a_data as $record) {
            $a_rc[] = array('label' => date('d.m.Y', strtotime($record->date->date)) . " "
                . date('H:i', strtotime($record->time))
                , 'value' => $record->id);
        }
        echo CJSON::encode($a_rc);
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
        $model = new Date;
        if (isset($_POST['Date'])) {
            $model->attributes = $_POST['Date'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
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
     //   $model->date = date('d.m.Y', strtotime($model->date));
        if (isset($_POST['Date'])) {
            $model->attributes = $_POST['Date'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
        $dataProvider = new CActiveDataProvider('Date');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Date('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Date']))
            $model->attributes = $_GET['Date'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Date the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Date::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
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
    
    /**
     * Convert PHP date() style dateFormat to the equivalent jQuery UI datepicker string
     * <http://snipplr.com/view/41329/>
     * @param string $dateString string der konvertiert werden soll.
     */
    function dateStringToDatepickerFormat($dateString)
    {
	$pattern = array(
 
		//day
		'd',		//day of the month
		'j',		//3 letter name of the day
		'l',		//full name of the day
		'z',		//day of the year
 
		//month
		'F',		//Month name full
		'M',		//Month name short
		'n',		//numeric month no leading zeros
		'm',		//numeric month leading zeros
 
		//year
		'Y', 		//full numeric year
		'y'		//numeric year: 2 digit
	);
	$replace = array(
		'dd','d','DD','o',
		'MM','M','m','mm',
		'yy','y'
	);
	foreach($pattern as &$p)
	{
		$p = '/'.$p.'/';
	}
	return preg_replace($pattern,$replace,$dateString);
    }

}
