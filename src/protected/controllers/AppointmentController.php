<?php

/**
 * Dies ist die Controller Klasse von Model Appointment.Stellt die Controller Actions des Appointments Models zur Verfügung.
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
                'actions' => array('create', 'index', 'view', 'getTeacher', 'makeAppointment', 'delete'),
                'roles' => array('3'),
            ),
            array('allow', //for teachers
                'actions' => array('index', 'delete', 'createBlockApp', 'DeleteBlockApp'),
                'roles' => array('2')
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'view', 'create', 'update', 'getteacherappointments', 'createBlockApp', 'DeleteBlockApp'),
                'roles' => array('0', '1'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionCreateBlockApp() {
        $model = new BlockedAppointment();
        $model->unsetAttributes();
        if (isset($_POST['BlockedAppointment'])) {
            $model->setAttributes($_POST['BlockedAppointment']);
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Termin erfolgreich geblockt.');
                if (Yii::app()->user->checkAccessNotAdmin('2')) {
                    $this->redirect(array('index'));
                } else {
                    $this->redirect(array('admin'));
                }
            }
        }
        $this->render('createBlockApp', array('model' => $model));
    }

    public function actionDeleteBlockApp($id, $teacherId = null) {
        if ($teacherId == null && Yii::app()->user->checkAccessNotAdmin('2')) {
            $model = BlockedAppointment::model()->findByAttributes(array('id' => $id, 'user_id' => Yii::app()->user->getId()));
        } else if (Yii::app()->user->checkAccess('1')) {
            $model = BlockedAppointment::model()->findByPk($id);
        } else {
            $this->throwFourNullThree();
        }
        if ($model != null && $model->delete()) {
            Yii::app()->user->setFlash('success', 'Blockierung erfolgreich gelöscht.');
        } else {
            Yii::app()->user->setFlash('failMsg', 'Fehler bei dem Löschen.');
        }
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
            if (strlen($_GET['letter']) <= 2) {
                $model->lastname = $_GET['letter'];
            }
        }
        $this->render('getTeacher', array(
            'dataProvider' => $model,
        ));
    }

    /**
     * die Action makeAppointment rendert das View um Termine zu vereinbaren
     * @param integer $teacher LehrerID
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
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
        $model = $this->loadModel($id);
        if ($this->loadModel($id)->delete()) {
            if (!Yii::app()->user->checkAccessNotAdmin('3')) {
                $mail = new Mail;
                $mail->sendAppointmentDeleted($model->parentChild->user->email, $model->user, $model->dateAndTime->time, $model->parentChild->child, $model->dateAndTime->date->date);
            }
            Yii::app()->user->setFlash('success', 'Termin erfolgreich entfernt.');
            if (Yii::app()->user->checkAccess('1')) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            } else {
                $this->redirect('index.php?r=/appointment/index');
            }
        }
    }

    /**
     * Terminübersicht für Lehrer/Eltern, haben jeweils ein View
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function actionIndex() {
        if (Yii::app()->user->checkAccessNotAdmin('2')) {
            $dataProvider = new Appointment('customSearch');
            $dataProvider->user_id = Yii::app()->user->getId();
            $this->render('indexTeacher', array(
                'dataProvider' => $dataProvider->customSearch()
            ));
        } else if (Yii::app()->user->checkAccessNotAdmin('3')) {
            $this->render('index', array(
                'dataProvider' => Appointment::getAllAppointments(),
            ));
        } else {
            $this->throwFourNullThree();
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Appointment('search');
        $blockedApp = new BlockedAppointment();
        $model->unsetAttributes();
        $blockedApp->unsetAttributes();
        if (isset($_GET['Appointment'])) {
            $model->attributes = $_GET['Appointment'];
        }
        if (isset($_GET['BlockedAppointment'])) {
            $blockedApp->attributes = $_GET['BlockedAppointment'];
        }
        $this->render('admin', array(
            'model' => $model, 'blockedApp' => $blockedApp,
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
            $this->throwFourNullFour();
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
    public function getDatesWithTimes($dateMax, $mergeDates = false) {
        $a_groupOfDateAndTimes = array();
        if (is_int($dateMax)) {
            /**
             * @todo Prüfung einbauen, dass nur Elternsprechtage angezeigt werden, die in der Zukunft liegen
             */
            $a_dates = Date::model()->findAll(array('limit' => $dateMax, 'order' => 'date ASC'));
            if (!$mergeDates) {
                foreach ($a_dates as $record) {
                    $a_groupOfDateAndTimes[] = DateAndTime::model()->findAllByAttributes(array('date_id' => $record->id));
                }
            } else if ($mergeDates) {
                foreach ($a_dates as $key => $record) {
                    $a_tempDateAndTimes = DateAndTime::model()->findAllByAttributes(array('date_id' => $record->id));
                    foreach ($a_tempDateAndTimes as $innerKey => $value) {
                        $a_tempDateAndTimes[$innerKey]['date'] = date(Yii::app()->params['dateFormat'], strtotime($a_dates[$key]->date));
                        $a_tempDateAndTimes[$innerKey]['time'] = date(Yii::app()->params['timeFormat'], strtotime($a_tempDateAndTimes[$innerKey]['time']));
                    }
                    $a_groupOfDateAndTimes = array_merge($a_groupOfDateAndTimes, $a_tempDateAndTimes);
                }
            }
        }
        return $a_groupOfDateAndTimes;
    }

    /**
     * Prüft ob ein Termin bereits belegt ist
     * @param integer $teacher User_ID des Lehrers
     * @param integer $dateAndTimeId ID des dateAndTime
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array Gibt BELEGT,0 oder Verfügbar,1 zurück,
     */
    public function isAppointmentAvailable($teacher, $dateAndTimeId) {
        $rc = array("BELEGT", 0);
        $check = false;
        if (Appointment::model()->countByAttributes(array('user_id' => $teacher,
                    'dateAndTime_id' => $dateAndTimeId)) == '0') {
            $check = true;
        }
        if ($check && Yii::app()->params['allowBlockingAppointments'] &&
                BlockedAppointment::model()->countByAttributes(array('user_id' => $teacher,
                    'dateAndTime_id' => $dateAndTimeId)) != '0') {
            if (Yii::app()->user->checkAccess('1')) {
                $rc = array("BLOCKIERT", 0);
            }
            $check = false;
        }
        if ($check) {
            $rc = array("VERF&Uuml;GBAR", 1);
        }
        return $rc;
    }

    /**
     * Generiert den Inhalt der Terminvereinbarung für die Rolle Eltern 
     * @todo Verkürzen oder in mehrere Methoden aufteilen
     * @author David Mock <dumock@gmail.com>
     * @param array $a_dates Array welches die nächsten Elternsprechtagstermine enthält
     * @param array $a_tabs Array mit den Tabellen, die die Termine anzeigen
     * @param string $select_content Das select-Element welches die id für den zu buchenden Termin an den Server überträgt.
     * @param object $model Das model der aktuellen Ansicht
     * @param integer $appointmentId 
     */
    public function createMakeAppointmentContent($a_dates, &$a_tabs, &$selectContent, $teacherId, $appointmentId = -1) {
        $tabsUiId = 0; //id der tabellen, wichtig für Javascriptfunktionen aus custom.js
        $selectContent = '<select id="form_dateAndTime" name="Appointment[dateAndTime_id]">';
        foreach ($a_dates as $a_day) {
            $tabsUiId++;
            $tabsName = date(Yii::app()->params['dateFormat'], strtotime($a_day[0]->date->date));
            $tabsContent = '<div style="display:none;" id="date-ui-id-' . $tabsUiId . '">' . $tabsName . '</div>'; //verstecktes Element für Javascriptfunktionen aus custom.js
            $tabsContent .= '<table><thead><th class="table-text" width="40%">Uhrzeit</th><th class="table-text" width="60%">Termin</th></thead><tbody>';
            $selectContent .= '<optgroup label="' . $tabsName . '">';
            $datesUiId = 0; //id der einzelnen Zeiten, wichtig für Javascriptfunktionen aus custom.js
            foreach ($a_day as $key => $a_times) {
                $datesUiId++;
                $a_times = $this->isAppointmentAvailable($teacherId, $a_day[$key]->id); //Array in dem gespeichert wird ob ein Termin Belegt oder Frei ist.
                $tabsContent .= '<tr><td id="time-ui-id-' . $tabsUiId . '_' . $datesUiId . '" class="table-text">' . date(Yii::app()->params['timeFormat'], strtotime($a_day[$key]->time)) . '</td>';
                $selectContent .= '<option value="' . $a_day[$key]->id . '"';
                if ($a_times[1]) { //Termin verfügbar
                    $tabsContent .= '<td id="ui-id-' . $tabsUiId . '_' . $datesUiId . '" class="avaiable table-text">' . $a_times[0] . '</td>';
                } else {
                    $tabsContent .= '<td class="occupied table-text">' . $a_times[0] . '</td>';
                    $selectContent .= ' disabled ';
                    if ($a_day[$key]->id == $appointmentId) {
                        $selectContent = str_replace(' disabled ', ' ', $selectContent);
                        $selectContent .= ' selected ';
                    }
                }
                $tabsContent .= '</tr>';
                $selectContent .= '>' . $tabsName . " - " . date(Yii::app()->params['timeFormat'], strtotime($a_day[$key]->time)) . '</option>';
            }
            $selectContent .= '</optgroup>';
            $tabsContent .= '</tbody></table>';
            $a_tabs[$tabsName] = $tabsContent;
            if ($tabsUiId == 3) { //Magic Number aus makeAppointment.php nach 3 Elternsprechtagen wird die Schleife verlassen. 
                break;
            }
        }
        $selectContent .= '</select>';
    }

    /**
     * @todo Beschreibung
     * @author David Mock <dumock@gmail.com>
     * @param type $teacherId
     */
    public function actionGetTeacherAppointments($teacherId, $name) {
        header('Content-type: application/json');
        $selectContent = CHtml::dropDownList($name, '', CHtml::listData($this->getDatesWithTimes(3, true), 'id', 'time', 'date'));
        echo CJSON::encode($selectContent);
        Yii::app()->end();
    }

    /**
     * Suche fuer Elternkindverknuepfungen anhand von  dem Namen des 
     * Erziehungsberechtigten, optimierte Ausgabe für appointment/create
     * @param string $term Nachname des Elternteils
     * @param integer $id Falls bei einem Update schon ein Kind ausgewählt wurde
     * @author David Mock <dumock@gmail.com>
     */
    public function createChildrenSelect($term, $id = -1) {
        $dataProvider = new ParentChild();
        $dataProvider->unsetAttributes();
        $criteria = $dataProvider->searchParentChild($term);
        $selectContent = '<select name="Appointment[parent_child_id]">';
        $a_data = ParentChild::model()->findAll($criteria);
        foreach ($a_data as $record) {
            $selectContent .= '<option value="' . $record->id . '" ';
            if ($record->id == $id) {
                $selectContent .= 'selected';
            }
            $selectContent .= '>' . $record->child->firstname . " " . $record->child->lastname . '</option>';
        }
        if (empty($a_data)) {
            $selectContent .= '<option>Keine Kinder vorhanden, bitte fügen Sie mindestens ein Kind hinzu bevor Sie fortfahren</option>';
        }
        $selectContent .='</select>';
        return $selectContent;
    }

}
