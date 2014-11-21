<?php

/**
 * Dies ist die Controller Klasse vom Model Date.
 */
/* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
                'roles' => array(MANAGEMENT),
            ),
            array('allow',
                'roles' => array(ADMIN)),
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
        echo CJSON::encode($dataProvider->searchFormattedArrayDateAndTime($term));
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
        $model = new Date();
        $a_disabled = '';
        $timeLabel = '';
        $dateLabel = '';
        if (isset($_POST['Date'])) {
            $model->attributes = $_POST['Date'];
            $this->setPostAttributes($model, $oldDate);
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('create', array(
            'model' => $model,
            'a_disabled' => $a_disabled,
            'timeLabel' => $timeLabel,
            'dateLabel' => $dateLabel,
        ));
    }

    private function setPostAttributes($model, &$oldDate) {
        if (Yii::app()->params['allowGroups'] && isset($_POST['Date']['groups'])) {
            $model->groups = $_POST['Date']['groups'];
        }
        if (isset($_POST['Date']['title'])) {
            $model->title = $_POST['Date']['title'];
        }
        if (isset($_POST['Date']['lockAt'])) {
            $model->lockAt = $_POST['Date']['lockAt'];
        }
        if (isset($_POST['Date']['date'])) {
            $oldDate = $model->date;
            $model->date = $_POST['Date']['date'];
        }
    }

    private function checkDiff($model, $oldDate) {
        if ($oldDate != null) {
            $newDate = Yii::app()->dateFormatter->formatDateTime(strtotime($model->date), "short", null);
            if ($newDate != $oldDate) {
                $mailAdrs = $this->collectMailAdrs($model);
                $mailObj = new Mail();
                foreach ($mailAdrs as $mail) {
                    $mailObj->sendDateChangeMail($mail, $oldDate, $newDate);
                }
            }
        }
    }

    private function collectMailAdrs($model) {
        $times = DateAndTime::model()->findAllByAttributes(array('date_id' => $model->id));
        $criteria = new CDbCriteria();
        $i = 0;
        foreach ($times as $val) {
            $criteria->addCondition('dateAndTime_id=:id' . $i, 'OR');
            $criteria->params[':id' . $i] = $val->id;
            $i++;
        }
        $criteria->with = 'parentchild';
        $criteria->select = 'id';
        $apps = Appointment::model()->findAll($criteria);
        $x = 0;
        $userIds = array();
        foreach ($apps as $app) {
            $userIds[] = $app->parentchild->user_id;
        }
        $userIds = array_unique($userIds);
        $mailAdrs = array();
        foreach ($userIds as $id) {
            $mailAdrs[] = User::model()->findByPk($id, array('select' => 'email'))->email;
        }
        return $mailAdrs;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->setScenario('update');
        $model->date = Yii::app()->dateFormatter->formatDateTime(strtotime($model->date), "short", null);
        $model->begin = Yii::app()->dateFormatter->format('H:mm', $model->begin);
        $model->end = Yii::app()->dateFormatter->format('H:mm', $model->end);
        $a_disabled = array('disabled' => 'disabled');
        $a_lockAtLabel = explode(' ', Yii::app()->dateFormatter->format(Yii::app()->locale->getDateFormat('short') . ' ' . 'H:mm', $model->lockAt));
        $dateLabel = $a_lockAtLabel[0];
        $timeLabel = $a_lockAtLabel[1];
        $model->lockAt = $dateLabel . ' ' . $timeLabel;
        if (isset($_POST['Date'])) {
            $oldDate = null;
            $this->setPostAttributes($model, $oldDate);
            if ($model->save(true, array('lockAt', 'groups', 'title', 'date'))) {
                $this->checkDiff($model, $oldDate);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('update', array(
            'model' => $model,
            'a_disabled' => $a_disabled,
            'a_lockAtLabel' => $a_lockAtLabel,
            'dateLabel' => $dateLabel,
            'timeLabel' => $timeLabel,
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
        if (isset($_GET['Date'])) {
            $model->attributes = $_GET['Date'];
        }
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
        if ($model === null) {
            $this->throwFourNullFour();
        }
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

    public function actionDateHasGroupAdmin() {
        $model = new DateHasGroup('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DateHasGroup'])) {
            $model->attributes = $_GET['DateHasGroup'];
        }
        $this->renderPartial('dateHasGroupAdmin', array(
            'model' => $model), false, true);
    }

}
