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
                'actions' => array('admin', 'delete', 'view', 'create', 'update',
                    'createBlockApp', 'DeleteBlockApp',
                    'getteacherappointmentsajax', 'getselectchildrenajax',
                ),
                'roles' => array('0', '1'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * returns teacherLabel
     * @param User $user
     * @return string 
     */
    private function teacherLabel(&$user) {
        return $user->title  . " " . $user->firstname . " " . $user->lastname;
    }

    /**
     * getsInforatmionWith TeacherID
     * @param BlockedAppointment $model
     * @return type
     */
    private function getInformationWithTeacherId(&$id = '') {
        $teacherLabel = '';
        if (isset($_GET['teacherId'])) { //Weiterleitung vom user/view; eventuell auch wenn der Lehrer dann im Menü auf Termin blockieren geht? haha -> möglicher intrusion point siehe #177 ;)
            $teacherValue = $_GET['teacherId'];
            $userTemp = User::model()->findByPk($teacherValue);
            $teacherLabel = $this->teacherLabel($userTemp);
            $id = $teacherValue;
        }
        return $teacherLabel;
    }

    /**
     * action for creating BlockedAppointment
     */
    public function actionCreateBlockApp() {
        if (Yii::app()->params['allowBlockingAppointments'] &&
                !(Yii::app()->user->checkAccessNotAdmin('2') &&
                Yii::app()->params['allowBlockingOnlyForManagement'])) {
            $model = new BlockedAppointment();
            $model->unsetAttributes();
            $appId = '';
            $teacherLabel = $this->getInformationWithTeacherId($appId);
            if (Yii::app()->user->checkAccessRole('2', '-1')) {
                $model->user_id = Yii::app()->user->getId();
            } else {
                $model->user_id = $appId;
            }
            if (isset($_POST['BlockedAppointment'])) {
                $model->setAttributes($_POST['BlockedAppointment']);
                if (!empty($model->attributes['user_id'])) {
                    $teacherLabel = $this->teacherLabel(User::model()->findByPk($model->attributes['user_id']));
                }
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'Termin erfolgreich geblockt.');
                    if (Yii::app()->user->checkAccessNotAdmin('2')) {
                        $this->redirect(array('index'));
                    } else {
                        $this->redirect(array('admin'));
                    }
                }
            }
            $this->render('createBlockApp', array('model' => $model, 'teacherLabel' => $teacherLabel));
        } else {
            $this->throwFourNullThree();
        }
    }

    /**
     * deletes BlockedAppointment
     * @param integer $id
     * @param integer $teacherId
     */
    public function actionDeleteBlockApp($id, $teacherId = null) {
        if (!empty($id)) {
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
        } else {
            $this->throwFourNullNull();
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
     * builds with parentId a label for parents
     * @return string
     */
    private function getParentLabel() {
        $parentLabel = '';
        if (isset($_GET['parentId'])) {
            $parentId = $_GET['parentId'];
            $userTemp = User::model()->findByPk($parentId);
            $parentLabel = $userTemp->firstname . " " . $userTemp->lastname;
        }
        return $parentLabel;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Appointment;
        $parentId = 0;
        $teacherLabel = $this->getInformationWithTeacherId();
        $parentLabel = $this->getParentLabel();
        if (isset($_POST['Appointment'])) {
            $model->attributes = $_POST['Appointment'];
            if (!empty($model->attributes['user_id'])) {
                $teacherLabel = $model->user->title . " " . $model->user->firstname . " " . $model->user->lastname;
            }
            if (!empty($model->attributes['parent_child_id'])) {
                $parentLabel = $model->parentchild->user->firstname . " " . $model->parentchild->user->lastname;
                $parentId = $model->parentchild->user->getPrimaryKey();
            }
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $this->render('create', array(
            'model' => $model,
            'teacherLabel' => $teacherLabel,
            'parentLabel' => $parentLabel,
            'parentId' => $parentId,
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
     * choosing css class for parentsdays
     * @param array $a_tabs
     * @return string
     */
    private function getColumnCount(&$a_tabs) {
        $columnCount = '';
        switch (count($a_tabs)) {
            case 1:
                $columnCount = 'twelve';
                break;
            case 2:
                $columnCount = 'six';
                break;
            case 3:
                $columnCount = 'four';
                break;
            default :
                $columnCount = 'twelve';
                break;
        }
        return $columnCount;
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
        $postDate = '';
        $postTime = '';
        $a_dates = $this->getDatesWithTimes(3); //Magic Number: nur die nächsten 3 Elternsprechtage werden geladen.
        $a_tabs = $this->createMakeAppointmentContent($a_dates, $model->user->id);
        if (isset($_POST['Appointment'])) {
            $model->attributes = $_POST['Appointment'];
            if (!empty($model->attributes['dateAndTime_id'])) {
                $postDate = date(Yii::app()->params['dateFormat'], strtotime($model->dateandtime->date->date));
                $postTime = date(Yii::app()->params['timeFormat'], strtotime($model->dateandtime->time));
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Ihr Termin wurde erfolgreich gebucht.');
                $this->redirect(array('index'));
            }
        }
        $this->render('makeAppointment', array(
            'model' => $model,
            'a_dates' => $a_dates,
            'a_tabs' => $a_tabs,
            'columnCount' => $this->getColumnCount($a_tabs),
            'postDate' => $postDate,
            'postTime' => $postTime,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $parentLabel = $model->parentchild->user->firstname . " " . $model->parentchild->user->lastname;
        $teacherLabel = $model->user->title . " " . $model->user->firstname . " " . $model->user->lastname;
        if (isset($_POST['Appointment'])) {
            $model->attributes = $_POST['Appointment'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $this->render('update', array(
            'model' => $model,
            'teacherLabel' => $teacherLabel,
            'parentLabel' => $parentLabel,
            'parentId' => $model->parentchild->user->id,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (!empty($id)) {
            $model = $this->loadModel($id);
            if ($this->loadModel($id)->delete()) {
                if (!Yii::app()->user->checkAccessNotAdmin('3')) {
                    $mail = new Mail;
                    $mail->sendAppointmentDeleted($model->parentchild->user->email, $model->user, $model->dateandtime->time, $model->parentchild->child, $model->dateandtime->date->date);
                }
                Yii::app()->user->setFlash('success', 'Termin erfolgreich entfernt.');
                if (Yii::app()->user->checkAccess('1')) {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                } else {
                    $this->redirect('index.php?r=/appointment/index');
                }
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
            $blockedApp = new BlockedAppointment();
            $blockedApp->unsetAttributes();
            if (Yii::app()->params['allowBlockingAppointments']) {
                $this->render('indexTeacher', array(
                    'dataProvider' => $dataProvider->customSearch(),
                    'blockedApp' => $blockedApp->search(),
                ));
            } else {
                $this->render('indexTeacher', array(
                    'dataProvider' => $dataProvider->customSearch(),
                ));
            }
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
        if (!empty($dateMax)) {
            if (Yii::app()->params['allowGroups'] && Yii::app()->user->checkAccessNotAdmin('3') && Yii::app()->user->getState('groups') != null) {
                //Verwaltung kann trotzdem noch Termine an anderen Tagen für diesen Benutzer buchen
                $a_dates = Date::model()->findAll(Date::criteriaForDateWithGroups($dateMax));
            } else {
                $a_dates = Date::model()->findAll(array('limit' => $dateMax, 'order' => 'date ASC', 'condition' => 'date >=:date', 'params' => array(':date' => date('Y-m-d', time()))));
            }
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
        if ((Yii::app()->params['allowGroups'] && !Yii::app()->user->getState('group')) || (!Yii::app()->params['allowGroups'] || Yii::app()->user->checkAccessRole('1', '3') || Yii::app()->user->checkAccessRole('0', '2'))) {
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
        }
        return $rc;
    }

    /**
     * Generiert den Inhalt der Terminvereinbarung für die Rolle Eltern 
     * @author David Mock <dumock@gmail.com>
     * @param array $a_dates Array welches die nächsten Elternsprechtagstermine enthält
     * @param integer $teacherId Id des Lehrers
     * @return array Tabelle(n) mit Status der Termine eines Lehrers
     */
    public function createMakeAppointmentContent($a_dates, $teacherId) {
        $a_tabs = array();
        $tabsUiId = 0; //id der tabellen, wichtig für Javascriptfunktionen aus custom.js
        if (!empty($teacherId)) {
            foreach ($a_dates as $a_day) {
                $tabsUiId++;
                $tabsName = date(Yii::app()->params['dateFormat'], strtotime($a_day[0]->date->date));
                if (!empty($a_day[0]->date->title)) {
                    $tabsName .= " (" . $a_day[0]->date->title . ")";
                }
                $tabsContent = '<div style="display:none;" id="date-ui-id-' . $tabsUiId . '">' . $tabsName . '</div>'; //verstecktes Element für Javascriptfunktionen aus custom.js
                $tabsContent .= '<table><thead><th class="table-text" width="40%">Uhrzeit</th><th class="table-text" width="60%">Termin</th></thead><tbody>';
                $datesUiId = 0; //id der einzelnen Zeiten, wichtig für Javascriptfunktionen aus custom.js
                foreach ($a_day as $key => $a_times) {
                    $datesUiId++;
                    $a_times = $this->isAppointmentAvailable($teacherId, $a_day[$key]->id); //Array in dem gespeichert wird ob ein Termin Belegt oder Frei ist.
                    $tabsContent .= '<tr><td id="time-ui-id-' . $tabsUiId . '_' . $datesUiId . '" class="table-text">';
                    $tabsContent .= date(Yii::app()->params['timeFormat'], strtotime($a_day[$key]->time)) . '</td>';
                    $tabsContent .= ($a_times[1]) ? '<td id="ui-id-' . $tabsUiId . '_' . $datesUiId . '" class="avaiable table-text">' . $a_times[0] . '</td>' : '<td class="occupied table-text">' . $a_times[0] . '</td>';
                    $tabsContent .= '</tr>';
                }
                $tabsContent .= '</tbody></table>';
                $tabsContent .= '<div class="panel appointment-lockAt text-center">' . 'Bedenken Sie, dass Termine nur bis zum ';
                $tabsContent .= date(Yii::app()->params['dateTimeFormat'], $a_day[0]->date->lockAt);
                $tabsContent .= ' gebucht werden können.</div>';
                $a_tabs[$tabsName] = $tabsContent;
                if ($tabsUiId == 3) { //Magic Number aus makeAppointment.php nach 3 Elternsprechtagen wird die Schleife verlassen. 
                    break;
                }
            }
        }
        return $a_tabs;
    }

    /**
     * AJAX Methode um die Termine eines bestimmten Lehrers in einem Select Element zu generieren.
     * @author David Mock <dumock@gmail.com>
     * @param int $teacherId Id des Lehrers
     * @param string $classname Name der Klasse des Views für das ein Element erzeugt werden soll
     * echo JSON
     */
    public function actionGetTeacherAppointmentsAjax($teacherId, $classname) {
        header('Content-type: application/json');
        echo CJSON::encode($this->createSelectTeacherDates($teacherId, $classname, 'dateAndTime_id'));
        Yii::app()->end();
    }

    /**
     * Erzeugt mittels CHtml::dropDownList ein Select Element, mit allen Terminen eines Lehrers.
     * @author David Mock <dumock@gmail.com>
     * @param int $teacherId Id des Lehres
     * @param string $nameForm Name der Klasse des Forms zbsp. "Appointment" in Appointment[user_id]
     * @param string $nameField Name des Inputfeldes der Form zbsp. "user_id" in Appointment[user_id]
     * @param int $selectedDateAndTime Ausgewählter Termin, für /update, default = -1
     * @return CHtml::dropDownList
     */
    public function createSelectTeacherDates($teacherId, $nameForm, $nameField, $selectedDateAndTime = -1) {
        $selectContent = array();
        $a_options = array('prompt' => 'Geben Sie einen Lehrernamen ein');
        if (!empty($teacherId)) {
            $a_optionsDisabledAppointments = array();
            $a_appointmentsStateValueLabel = array();
            $selectContent = CHtml::listData($this->getDatesWithTimes(3, true), 'id', 'time', 'date');
            foreach ($selectContent as $a_appointments) {
                foreach ($a_appointments as $key => $value) {
                    $a_appointmentsStateValueLabel[$key]['state'] = $this->isAppointmentAvailable($teacherId, $key);
                    $a_appointmentsStateValueLabel[$key]['label'] = $value;
                    $a_appointmentsStateValueLabel[$key]['value'] = $key;
                    if (!$a_appointmentsStateValueLabel[$key]['state'][1]) {
                        $a_optionsDisabledAppointments[$key] = array('disabled' => true);
                    }
                }
            }
            $a_optionsDisabledAppointments[$selectedDateAndTime] = array('selected' => true);
            $a_options = array('options' => $a_optionsDisabledAppointments, 'prompt' => 'Wählen Sie einen Termin aus');
        }
        return Select2::dropDownList($nameForm . '[' . $nameField . ']', '', $selectContent, $a_options);
    }

    /**
     * Erzeugt mittels CHtml::dropDownList ein Select Element, mit allen Kindern eines Users
     * @author David Mock <dumock@gmail.com>
     * @param int $userId Id des Elternteils
     * @param string $nameForm Name der Klasse des Forms zbsp. "Appointment" in Appointment[user_id]
     * @param string $nameField Name des Inputfeldes der Form zbsp. "user_id" in Appointment[user_id]
     * @param int $selectedChild Ausgewähltes Kind, für /update, default = -1
     * @return CHtml::dropDownList
     */
    public function createSelectChildren($userId, $nameForm, $nameField, $selectedChild = -1) {
        $selectContent = array();
        $a_options = array('prompt' => 'Geben Sie einen Elternnamen ein');
        if (!empty($userId)) {
            $dataProvider = new ParentChild();
            $dataProvider->unsetAttributes();
            $a_parentChild = ParentChild::model()->findAllByAttributes(array('user_id' => $userId), array('with' => array('user', 'child'), 'select' => '*'));
            $selectContent = (empty($a_parentChild)) ? array('prompt' => 'Bitte legen Sie mindestens ein Kind an bevor Sie fortfahren') : CHtml::listData($a_parentChild, 'id', function($post) {
                                return $post->child->firstname . ' ' . $post->child->lastname;
                            });
            $a_optionsInner[$selectedChild] = array('selected' => true);
            $a_options = array('options' => $a_optionsInner);
        }
        return Select2::dropDownList($nameForm . '[' . $nameField . ']', '', $selectContent, $a_options);
    }

    /**
     * AJAX Methode um die Kinder eines bestimmten Users in einem Select Element zu generieren.
     * @param int $id id des Users
     * @author David Mock <dumock@gmail.com>
     * echo JSON
     */
    public function actionGetSelectChildrenAjax($id) {
        if (!empty($id)) {
            header('Content-type: application/json');
            echo CJSON::encode($this->createSelectChildren($id, 'Appointment', 'parent_child_id'));
        }
        Yii::app()->end();
    }

    /**
     * fills a child select
     * @return array
     */
    public function fillChildSelect() {
        $a_child = $this->getChilds(Yii::app()->user->getId());
        if (empty($a_child)) {
            Yii::app()->user->setFlash('failMsg', 'Sie haben keine Kinder eingetragen. Bitte tragen Sie dies nach. Anschließend können Sie einen Termin vereinbaren.');
        }
        return $a_child;
    }

    /**
     * Generiert einen Link fuer appointment/getTeacher
     * @param string $letter
     * @return string
     */
    public function getTeacherLink($letter) {
        return '<a href="index.php?r=appointment/getTeacher&amp;letter=' . $letter . '" class="small teacher button">' . strtoupper($letter) . '</a>';
    }

    /**
     * echo des Strings von getTeacherLink
     * @param string $letter
     */
    public function getTeacherLinkE($letter) {
        echo $this->getTeacherLink($letter);
    }

}
