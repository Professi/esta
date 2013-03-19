<?php
/**
 * Dies ist die Controller Klasse von Model Appointment.
 */
/* * Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
 * Stellt die Controller Actions des Appointments Models zur Verfügung.
 */
class AppointmentController extends Controller {

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
            'accessControl',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'index', 'view', 'getTeacher', 'makeAppointment'),
                'roles' => array('3'),
            ),
            array('allow', //for teachers
                'actions' => array('index'),
                'roles' => array('2')
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'view', 'create'),
                'roles' => array('0', '1'),
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
        $model = new Appointment;
        if (isset($_POST['Appointment'])) {
            $model->attributes = $_POST['Appointment'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Prüft ob per GET ein Buchstabe übergeben wurde wenn dies der Fall ist
     * wird die entsprechende Suchanfrage gesendet und rendert das GridView
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function actionGetTeacher() {
        $model = new User('searchTeacher');
        $model->unsetAttributes();
        $model->state = 1;
        if (isset($_GET['letter']) && strlen($_GET['letter']) <= 2) {
            $search = array('ae', 'oe', 'ue');
            $replace = array('Ä', 'Ö', 'Ü');
            $letter = str_replace($search, $replace, $_GET['letter']);
            print_r($letter);
            if (strlen($letter) <= 2) {
                $model->lastname = $letter;
            }
        }
        $this->render('getTeacher', array(
            'dataProvider' => $model,
        ));
    }

    /**
     * die Action makeAppointment rendert das View um Termine zu vereinbaren
     * @param integer $teacher LehrerID
     */
    public function actionMakeAppointment($teacher) {
        $model = new Appointment;
        $model->unsetAttributes();
        $model->user_id = $teacher;
        if (isset($_POST['Appointment'])) {
            $model->attributes = $_POST['Appointment'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Ihr Termin wurde erfolgreich gebucht.');
                $this->redirect(array('index'));
            }
        }
        $this->render('makeAppointment', array('model' => $model));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['Appointment'])) {
            $model->attributes = $_POST['Appointment'];
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
     * Terminübersicht für Lehrer/Eltern, haben jeweils ein View
     */
    public function actionIndex() {
        if (Yii::app()->user->checkAccess('2') && !Yii::app()->user->isAdmin()) {
            $dataProvider = new Appointment('customSearch');
            $dataProvider->user_id = Yii::app()->user->getId();
            $this->render('indexTeacher', array(
                'dataProvider' => $dataProvider->customSearch()
            ));
        } else {
            $criteria = new CDbCriteria();
            $pC = ParentChild::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->getId()));
            foreach ( $pC as $record) {
                $criteria->addCondition(array('parent_child_id'=>$record->id), 'OR');
            }
            $dataProvider = new CActiveDataProvider('Appointment', array(
                'criteria' => $criteria));
            $this->render('index', array(
                'dataProvider' => $dataProvider,
            ));
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Appointment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Appointment']))
            $model->attributes = $_GET['Appointment'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Appointment the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Appointment::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Appointment $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'appointment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Liefert die Kindernamen mit ParentChild ID
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param integer $userId Benutzer ID des Users
     * @return array Mehrdimensionales Array, jedes Array enthält die Felder label und Value
     */
    public function getChilds($userId) {
        $a_rc = array();
        $a_data = ParentChild::model()->findAllByAttributes(array('user_id' => $userId));
        foreach ($a_data as $record) {
            $a_rc[] = array('label' => $record->child->firstname . " " . $record->child->lastname, 'value' => $record->id);
        }
        return $a_rc;
    }

    /**
     * Liefert das Datum mit DateAndTime
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param integer $dateMax Maximal Anzahl der Elternsprechtage für die DateAndTimes gefunden werden sollen
     * @return array Enthält Arrays welche n-DateAndTimes enthalten
     */
    public function getDatesWithTimes($dateMax) {
        $a_groupOfDateAndTimes = array();
        if (is_int($dateMax)) {
            $a_dates = Date::model()->findAll('', array('LIMIT ' . $dateMax));
            foreach ($a_dates as $record) {
                $a_groupOfDateAndTimes[] = DateAndTime::model()->findAllByAttributes(array('date_id' => $record->id));
            }
        }
        return $a_groupOfDateAndTimes;
    }

    /**
     * Prüft ob ein Termin bereits belegt ist
     * @param integer $teacher User_ID des Lehrers
     * @param integer $dateAndTimeId ID des dateAndTime
     * @return array Gibt BELEGT,0 oder Verfügbar,1 zurück,
     */
    public function isAppointmentAvailable($teacher, $dateAndTimeId) {
        $rc = array("BELEGT", 0);
        if (Appointment::model()->countByAttributes(array('user_id' => $teacher, 'dateAndTime_id' => $dateAndTimeId)) == '0') {
            $rc = array("VERF&Uuml;gbar", 1);
        }
        return $rc;
    }

}
