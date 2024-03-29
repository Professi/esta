<?php

/**
 * Dies ist die Controller Klasse von Model Appointment.Stellt die Controller Actions des Appointments Models zur Verfügung.
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
class AppointmentController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * Filter
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'index', 'view', 'getTeacher', 'makeAppointment', 'delete', 'exportIcs'),
                'roles' => array(PARENTS),
            ),
            array('allow', //for teachers
                'actions' => array('index', 'delete', 'create', 'createBlockApp', 'DeleteBlockApp',
                    'getteacherappointmentsajax', 'getselectchildrenajax', 'overview', 'exportIcs'),
                'roles' => array(TEACHER)
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'view', 'create', 'update',
                    'createBlockApp', 'DeleteBlockApp', 'generatePlans',
                    'getteacherappointmentsajax', 'getselectchildrenajax',
                    'overview', 'createBlockDay'
                ),
                'roles' => array(ADMIN, MANAGEMENT),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * @param User $user
     * @return string
     */
    private function teacherLabel($user)
    {
        return $user->title . " " . $user->firstname . " " . $user->lastname;
    }

    /**
     * getsInforatmionWith TeacherID
     * @param BlockedAppointment $model
     * @return type
     */
    private function getInformationWithTeacherId(&$id = '')
    {
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
    public function actionCreateBlockApp()
    {
        if (Yii::app()->params['allowBlockingAppointments'] &&
            !(Yii::app()->user->checkAccessNotAdmin(TEACHER) &&
            Yii::app()->params['allowBlockingOnlyForManagement'])) {
            $this->blockAppointment();
        } else {
            $this->throwFourNullThree();
        }
    }

    protected function blockAppointment()
    {
        $model = new BlockedAppointment();
        $model->unsetAttributes();
        $appId = '';
        $teacherLabel = $this->getInformationWithTeacherId($appId);
        if (Yii::app()->user->isTeacher()) {
            $model->user_id = Yii::app()->user->getId();
        }
        if (isset($_POST['BlockedAppointment'])) {
            $teacherLabel = $this->saveBlockAppointment($model, $teacherLabel);
        }
        $this->render('createBlockApp', array('model' => $model, 'teacherLabel' => $teacherLabel));
    }

    protected function saveBlockAppointment($model, $teacherLabel)
    {
        $model->setAttributes($_POST['BlockedAppointment']);
        if (!empty($model->attributes['user_id'])) {
            $t = User::model()->findByPk($model->attributes['user_id']);
            $teacherLabel = $this->teacherLabel($t);
        }
        if ($model->save()) {
            Yii::app()->user->setFlash('success', Yii::t('app', 'Termin erfolgreich geblockt.'));
            $this->redirect(Yii::app()->user->isTeacher() ? array('index') : array('admin'));
        }
        return $teacherLabel;
    }

    /**
     * deletes BlockedAppointment
     * @param integer $id
     * @param integer $teacherId
     */
    public function actionDeleteBlockApp($id, $teacherId = null)
    {
        if (!empty($id)) {
            if ($teacherId == null && Yii::app()->user->isTeacher()) {
                $model = BlockedAppointment::model()->findByAttributes(array('id' => $id, 'user_id' => Yii::app()->user->getId()));
            } elseif (Yii::app()->user->checkAccess(MANAGEMENT)) {
                $model = BlockedAppointment::model()->findByPk($id);
            } else {
                $this->throwFourNullThree();
            }
            if ($model != null && $model->delete()) {
                Yii::app()->user->setFlash('success', Yii::t('app', 'Blockierung erfolgreich gelöscht.'));
            } else {
                Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Fehler bei dem Löschen.'));
            }
        } else {
            $this->throwFourNullNull();
        }
    }

    /**
     * Block all dateAndTimes for a teacher on a specific date.
     * There must be a better way to do this, alas I have no time to find it
     */
    public function actionCreateBlockDay()
    {
        if (!(Yii::app()->params['allowBlockingAppointments']) || !(Yii::app()->user->isAdmin() || Yii::app()->user->isManager())) {
            $this->throwFourNullNull();
        }
        if (isset($_POST['BlockedAppointment']) && isset($_POST['BlockedAppointment']['user_id']) && isset($_POST['BlockedAppointment']['reason']) && !empty($_POST['BlockedAppointment']['user_id']) && !empty($_POST['BlockedAppointment']['reason'])) {
            $this->saveBlockedAppointments();
        } else {
            $this->actionCreateBlockApp();
        }
        $this->redirect(array('admin'));
    }

    private function saveBlockedAppointments()
    {
        $dateAndTime = DateAndTime::model()->findByPk($_POST['BlockedAppointment']['dateAndTime_id']);
        $date = $dateAndTime->date;
        $userId = $_POST['BlockedAppointment']['user_id'];
        $reason = $_POST['BlockedAppointment']['reason'];
        foreach ($date->dateAndTimes as $dateAndTime) {
            $model = new BlockedAppointment();
            $model->unsetAttributes();
            $model->setAttributes([
                'dateAndTime_id' => $dateAndTime->id,
                'user_id' => $userId,
                'reason' => $reason
            ]);
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('app', 'Termin erfolgreich geblockt.'));
            }
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * builds with parentId a label for parents
     * @return string
     */
    private function getParentLabel()
    {
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
    public function actionCreate()
    {
        $model = new Appointment;
        if (Yii::app()->user->isTeacher() && !Yii::app()->params['teacherAllowBlockTeacherApps'] && Yii::app()->params['allowTeachersToCreateAppointments']) {
            $model->user_id = Yii::app()->user->getId();
        }
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
            if ($model->save()) {
                $this->redirect(Yii::app()->user->isTeacher() ?
                        array('appointment/index') : array('view', 'id' => $model->id));
            }
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
    public function actionGetTeacher()
    {
        $model = new User('searchTeacher');
        $model->unsetAttributes();
        $model->state = 1;
        $model->groups = Yii::app()->user->getGroups();
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
     * @param array $array
     * @return string
     */
    private function getColumnCount(&$array)
    {
        $columnCount = '';
        switch (count($array)) {
            case 1:
                $columnCount = 'small-12';
                break;
            case 2:
                $columnCount = 'small-6';
                break;
            case 3:
                $columnCount = 'small-4';
                break;
            default:
                $columnCount = 'small-12';
                break;
        }
        return $columnCount;
    }

    /**
     * die Action makeAppointment rendert das View um Termine zu vereinbaren
     * @param integer $teacher LehrerID
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function actionMakeAppointment($teacher)
    {
        $model = new Appointment;
        $model->unsetAttributes();
        if (is_numeric($teacher)) {
            $this->checkForBadRequest($teacher);
            $model->user_id = $teacher;
            $postDate = '';
            $postTime = '';
            $dates = $this->getDatesWithTimes($this->getMaxParentsDays()); //Magic Number: nur die nächsten 3 Elternsprechtage werden geladen.
            if (isset($_POST['Appointment'])) {
                $model->attributes = $_POST['Appointment'];
                if (!empty($model->attributes['dateAndTime_id'])) {
                    $postDate = Yii::app()->dateFormatter->formatDateTime(strtotime($model->dateandtime->date->date), "short", null);
                    $postTime = Yii::app()->dateFormatter->formatDateTime(strtotime($model->dateandtime->time), null, "short");
                }
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Ihr Termin wurde erfolgreich gebucht.'));
                    $mail = new Mail();
                    if(Yii::app()->params['teacherInfoMail']) {
                        $mail->sendAppointmentBooked($model->user->email, $model->parentchild->user, $model->dateandtime->time, $model->parentchild->child, $model->dateandtime->date->date);#
                    }
                    $this->redirect(array('index'));
                }
            }
            $this->render('makeAppointment', array(
                'model' => $model,
                'dates' => $dates,
                'columnCount' => $this->getColumnCount($dates),
                'postDate' => $postDate,
                'postTime' => $postTime,
            ));
        } else {
            $this->throwFourNullThree();
        }
    }

    private function getMaxParentsDays()
    {
        return 3;
    }

    private function checkForBadRequest($teacher)
    {
        if (Yii::app()->params['allowGroups'] && Yii::app()->user->checkAccess('3')) {
            $badRequest = true;
            $userGroups = Yii::app()->user->getGroups();
            $teacherGroups = UserHasGroup::model()->findAllByAttributes(array('user_id' => $teacher));
            if (empty($teacherGroups)) {
                $badRequest = false;
            } else {
                $badRequest = $this->frictionUserTeacherGroup($userGroups, $teacherGroups, $badRequest);
            }
            if ($badRequest) {
                $this->throwFourNullThree();
            }
        }
    }

    protected function frictionUserTeacherGroup($userGroups, $teacherGroups, $badRequest)
    {
        if (is_array($userGroups) && is_array($teacherGroups)) {
            foreach ($teacherGroups as $group) {
                foreach ($userGroups as $userGroup) {
                    if ($group->group->id == $userGroup->id) {
                        $badRequest = false;
                        break;
                    }
                }
            }
        }
        return $badRequest;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $parentLabel = $model->parentchild->user->firstname . " " . $model->parentchild->user->lastname;
        $teacherLabel = $model->user->title . " " . $model->user->firstname . " " . $model->user->lastname;
        if (isset($_POST['Appointment'])) {
            $model->attributes = $_POST['Appointment'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
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
    public function actionDelete($id)
    {
        if (!empty($id)) {
            $model = $this->loadModel($id);
            if ($model->delete()) {
                $mail = new Mail();
                $mail->sendAppointmentDeleted($model->parentchild->user->email, $model->user, $model->dateandtime->time, $model->parentchild->child, $model->dateandtime->date->date, Yii::app()->params['teacherInfoMail']);
                Yii::app()->user->setFlash('success', Yii::t('app', 'Termin erfolgreich entfernt.'));
                if (Yii::app()->user->checkAccess(MANAGEMENT)) {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                } else {
                    $this->redirect(array('appointment/index'));
                }
            }
        }
    }

    /**
     * Terminübersicht für Lehrer/Eltern, haben jeweils ein View
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function actionIndex()
    {
        if (Yii::app()->user->checkAccessNotAdmin(TEACHER)) {
            $appSearch = new Appointment('customSearch');
            $appSearch->user_id = Yii::app()->user->getId();
           
            $blockedApp = new BlockedAppointment();
            $blockedApp->unsetAttributes();
            $dates = Date::model()->findAll();
            $rooms = new UserHasRoom('altSearch');
            $rooms->user_id = Yii::app()->user->getId();
            $dataProvider = $appSearch->customSearch();
            $dataProvider->pagination = false;
            $arr = array('dataProvider' => $dataProvider,
                'rooms' => $rooms->altSearch(),
                'dates' => $dates);
            if (Yii::app()->params['allowBlockingAppointments']) {
                $arr['blockedApp'] = $blockedApp->search();
            }
            $this->render('indexTeacher', $arr);
        } else if (Yii::app()->user->isParent()) {
            $no_children = ParentChild::model()->countByAttributes(
                    array('user_id' => Yii::app()->user->getId())
                ) == '0' ? true : false;
            $dataProvider = Appointment::getAllAppointments();
            $dataProvider->pagination = false;
            $this->render('index', array(
                'dataProvider' => $dataProvider,
                'no_children' => $no_children,
            ));
        } else {
            $this->throwFourNullThree();
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
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
            'model' => $model,
            'blockedApp' => $blockedApp,
            'dates' => Date::simpleSelect2ListData(),
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Appointment the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Appointment::model()->findByPk($id);
        if ($model === null) {
            $this->throwFourNullFour();
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Appointment $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
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
    public function getChilds($userId)
    {
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
     * @param boolean $mergeDates
     * @param string $date 'Y-m-d' Tag an dem gesucht werden soll. Default ist time()
     * @return array Enthält Arrays welche n-DateAndTimes enthalten
     */
    public function getDatesWithTimes($dateMax, $mergeDates = false)
    {
        $a_groupOfDateAndTimes = array();
        if (!empty($dateMax)) {
            if (Yii::app()->params['allowGroups'] && Yii::app()->user->isParent()) {
                //Verwaltung kann trotzdem noch Termine an anderen Tagen für diesen Benutzer buchen
                $a_dates = Date::model()->findAll(Date::criteriaForDateWithGroups($dateMax));
            } else {
                $a_dates = Date::model()->findAll(array('limit' => $dateMax, 'order' => 'date ASC', 'condition' => 'date >=:date', 'params' => array(':date' => date('Y-m-d', time()))));
            }
            if (!$mergeDates) {
                foreach ($a_dates as $record) {
                    $a_groupOfDateAndTimes[] = DateAndTime::model()->findAllByAttributes(array('date_id' => $record->id));
                }
            } elseif ($mergeDates) {
                foreach ($a_dates as $key => $record) {
                    $a_tempDateAndTimes = DateAndTime::model()->findAllByAttributes(array('date_id' => $record->id));
                    foreach ($a_tempDateAndTimes as $innerKey => $value) {
                        $a_tempDateAndTimes[$innerKey]['date'] = Yii::app()->dateFormatter->formatDateTime(strtotime($a_dates[$key]->date), "short", null);
                        $a_tempDateAndTimes[$innerKey]['time'] = Yii::app()->dateFormatter->formatDateTime(strtotime($a_tempDateAndTimes[$innerKey]['time']), null, "short");
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
     * @param boolean $overrideAccess gibt BLOCKIERT zurück auch wenn kein Admin
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array Gibt BELEGT,0 oder Verfügbar,1 zurück,
     */
    public function isAppointmentAvailable($teacher, $dateAndTimeId, $overrideAccess = false)
    {
        $rc = array(Yii::t('app', "BELEGT"), false);
        $check = false;
        if (Appointment::model()->countByAttributes(array('user_id' => $teacher,
                'dateAndTime_id' => $dateAndTimeId)) == '0') {
            $check = true;
        }
        if ($check && Yii::app()->params['allowBlockingAppointments'] &&
            BlockedAppointment::model()->countByAttributes(array('user_id' => $teacher,
                'dateAndTime_id' => $dateAndTimeId)) != '0') {
            if (Yii::app()->user->checkAccess('1') || $overrideAccess) {
                $rc = array(Yii::t('app', "BLOCKIERT"), false);
            }
            $check = false;
        }
        if ($check) {
            $rc = array(Yii::t('app', "VERFÜGBAR"), true);
        }
        return $rc;
    }

    /**
     * AJAX Methode um die Termine eines bestimmten Lehrers in einem Select Element zu generieren.
     * @author David Mock <dumock@gmail.com>
     * @param int $teacherId Id des Lehrers
     * @param string $classname Name der Klasse des Views für das ein Element erzeugt werden soll
     * echo JSON
     */
    public function actionGetTeacherAppointmentsAjax($teacherId, $classname)
    {
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
    public function createSelectTeacherDates($teacherId, $nameForm, $nameField, $selectedDateAndTime = -1)
    {
        $selectContent = array();
        $a_options = array('prompt' => Yii::t('app', 'Geben Sie einen Lehrernamen ein'));
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
            $a_options = array('options' => $a_optionsDisabledAppointments, 'prompt' => Yii::t('app', 'Wählen Sie einen Termin aus'));
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
    public function createSelectChildren($userId, $nameForm, $nameField, $selectedChild = -1)
    {
        $selectContent = array();
        $a_options = array('prompt' => Yii::t('app', 'Geben Sie einen Elternnamen ein'));
        if (!empty($userId)) {
            $dataProvider = new ParentChild();
            $dataProvider->unsetAttributes();
            $a_parentChild = ParentChild::model()->findAllByAttributes(array('user_id' => $userId), array('with' => array('user', 'child'), 'select' => '*'));
            $selectContent = (empty($a_parentChild)) ? array('prompt' => Yii::t('app', 'Bitte legen Sie mindestens ein Kind an bevor Sie fortfahren')) : CHtml::listData($a_parentChild, 'id', function ($post) {
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
    public function actionGetSelectChildrenAjax($id)
    {
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
    public function fillChildSelect()
    {
        $a_child = $this->getChilds(Yii::app()->user->getId());
        if (empty($a_child)) {
            Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Sie haben keine Kinder eingetragen. Bitte tragen Sie dies nach. Anschließend können Sie einen Termin vereinbaren.'));
        }
        return $a_child;
    }

    /**
     * Generiert einen Link fuer appointment/getTeacher
     * @param string $letter
     * @return string
     */
    public function getTeacherLink($letter)
    {
        return '<a href="index.php?r=appointment/getTeacher&amp;letter=' . $letter . '" class="small teacher button">' . strtoupper($letter) . '</a>';
    }

    /**
     * echo des Strings von getTeacherLink
     * @param string $letter
     */
    public function getTeacherLinkE($letter)
    {
        echo $this->getTeacherLink($letter);
    }

    /**
     * Formatiert den Titel eines Elternsprechtages in makeAppointment.php
     * @author David Mock <dumock@gmail.com>
     * @param string $app der Elternsprechtag
     * return string
     */
    public function formatAppointmentTitle($app, $user = null) {
        $string = Yii::app()->dateFormatter->formatDateTime(strtotime($app->date), "short", null);
        if (!empty($app->title)) {
            $string .= " ({$app->title})";
        }
        if (is_object($user)) {
            $userroom = UserHasRoom::model()->findByAttributes(['date_id' => $app->id, 'user_id' => $user->id]);
            if (!empty($userroom)) {
                $string .= ' - ' . Yii::t('app', 'Raum') . ' ' . $userroom->room->name;
            }
        }
        return $string;
    }

    public function actionOverview($id, $date)
    {
        if (!((Yii::app()->user->isTeacher() && $id === Yii::app()->user->id) || Yii::app()->user->checkAccess(MANAGEMENT))) {
            $this->throwFourNullThree();
        }
        $dateObj = $this->getDate($date);
        $data = $this->generateOverviewData($id, current($this->getDateWithTimes($dateObj)), Appointment::model()->with('parentchild.child', 'parentchild.user')->findAllByAttributes(array('user_id' => $id)), BlockedAppointment::model()->findAllByAttributes(array('user_id' => $id)));
        $teacher = User::model()->findByPk($id);
        $this->render('overview', array('data' => $data,
            'room' => $teacher->getRoom($dateObj->id),
            'teacher' => "{$teacher->title} {$teacher->firstname} {$teacher->lastname}",
            'date' => Yii::app()->dateFormatter->formatDateTime(strtotime($dateObj->date), 'short', null)));
    }

    private function getDate($dateId)
    {
        if (is_numeric($dateId)) {
            return Date::model()->findByPk((int) $dateId);
        }
        $this->throwFourNullNull();
    }

    private function generateOverviewData($id, $dateData, $appointments, $blockedAppointments)
    {
        $data = array();
        if (empty($id) || empty($dateData)) {
            $this->throwFourNullFour();
        }
        foreach ($dateData as $date) {
            $data[] = $this->overviewDataText($id, $date, $appointments, $blockedAppointments);
        }
        return $data;
    }

    private function overviewDataText($id, $date, $appointments, $blockedAppointments)
    {
        $temp = array();
        $time = $this->isAppointmentAvailable($id, $date->id, true);
        $temp['time'] = Yii::app()->dateFormatter->formatDateTime(strtotime($date->time), null, 'short');
        $temp['status'] = $time[0];
        $temp['text'] = '';
        if (!$time[1] && $time[0] !== Yii::t('app', "BLOCKIERT")) {
            $temp['text'] = $this->generateAppointmentText($date, $appointments);
        } elseif (!$time[1] && $time[0] === Yii::t('app', "BLOCKIERT")) {
            $temp['text'] = $this->generateBlockedAppointmentText($date, $blockedAppointments);
        }
        return $temp;
    }

    private function generateAppointmentText($date, $appointments)
    {
        $text = '';
        foreach ($appointments as $appointment) {
            if ($date->id === $appointment->dateAndTime_id) {
                $parent = $appointment->parentchild->user;
                $child = $appointment->parentchild->child;
                $text = "{$parent->title} {$parent->firstname} {$parent->lastname} ({$child->firstname} {$child->lastname})";
            }
        }
        return $text;
    }

    private function generateBlockedAppointmentText($date, $blockedAppointments)
    {
        $text = '';
        foreach ($blockedAppointments as $appointment) {
            if ($date->id === $appointment->dateAndTime_id) {
                $text = $appointment->reason;
            }
        }
        return $text;
    }

    private function getDateWithTimes($date)
    {
        $dateAndTimes = array();
        if (!empty($date)) {
            $dateAndTimes[] = DateAndTime::model()->findAllByAttributes(array('date_id' => $date->id));
        }
        return $dateAndTimes;
    }

    public function actionExportIcs()
    {
        if (!(Yii::app()->user->isTeacher() || Yii::app()->user->isParent())) {
            $this->throwFourNullThree();
        }
        $dates = $this->generateIcsData();
        $ical = "BEGIN:VCALENDAR" . PHP_EOL
            . "VERSION:2.0" . PHP_EOL
            . "PRODID:http://" . Yii::app()->params['schoolWebsiteLink'] . PHP_EOL;
        foreach ($dates as $date) {
            $with = Yii::app()->user->checkAccess('2') ? $date['parent'] : $date['teacher'];

            $dateTime = \DateTime::createFromFormat('Y-m-dH:i:s', $date['date'] . $date['start']);
            $dateTime->setTimezone(new \DateTimeZone('UTC'));
            $dtStart = $dateTime->format('Ymd\THis\Z');
            $dateTime->add(new \DateInterval("PT${date['duration']}M"));
            $dtEnd = $dateTime->format('Ymd\THis\Z');

            $ical .= "BEGIN:VEVENT" . PHP_EOL
                . "UID:" . md5(uniqid(mt_rand(), true)) . "@" . Yii::app()->params['schoolWebsiteLink'] . PHP_EOL
                . "DTSTAMP:" . date('Ymd\THis\Z') . PHP_EOL
                . "DTSTART:" . $dtStart . PHP_EOL
                . "DTEND:" . $dtEnd . PHP_EOL
                . "SUMMARY:" . Yii::t('app', 'Ihr Termin mit {with} für {child}', array('{with}' => $with, '{child}' => $date['child']))
                . PHP_EOL . "END:VEVENT" . PHP_EOL;
        }
        $ical .= "END:VCALENDAR" . PHP_EOL;
        $user = User::model()->findByPk(Yii::app()->user->getId());
        Yii::app()->getRequest()->sendFile($user->lastname . '_' . $user->firstname . '_esta.ics', $ical, 'text/calendar; charset=utf-8');
    }

    private function getAppointments()
    {
        $appointments = array();
        if (Yii::app()->user->checkAccess(TEACHER)) {
            $userId = array('user_id' => Yii::app()->user->id);
            $appointments = Appointment::model()->findAllByAttributes($userId);
        } elseif (Yii::app()->user->checkAccess(PARENTS)) {
            $crit = new CDbCriteria();
            $i = 0;
            foreach (ParentChild::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id)) as $parentChild) {
                $crit->addCondition("parent_child_id = :A{$i}", 'OR');
                $crit->params[":A{$i}"] = $parentChild->id;
                $i++;
            }
            $crit->with = array('parentchild', 'dateandtime.date');
            $appointments = Appointment::model()->findAll($crit);
        }
        return $appointments;
    }

    private function generateIcsData()
    {
        $appointments = $this->getAppointments();
        $dates = array();
        foreach ($appointments as $appointment) {
            $parentChild = $appointment->parentchild;
            $child = $parentChild->child;
            $date = $appointment->dateandtime->date;
            $temp = array(
                'date' => $date->date,
                'start' => $appointment->dateandtime->time,
                'duration' => $appointment->dateandtime->duration,
                //'title' => $date->title,
                'child' => "{$child->firstname} {$child->lastname}",
                'parent' => $parentChild->user->getDisplayName(),
                'teacher' => $appointment->user->getDisplayName()
            );
            $dates[] = $temp;
        }
        return $dates;
    }

    /**
     *
     * @param int $date
     * @param tinyint $emptyPlans
     * @TODO implement group using
     */
    public function actionGeneratePlans($date, $emptyPlans = '1')
    {
        if (!is_numeric($date)) {
            $this->throwFourNullNull();
        }
        $criteria = new CDbCriteria();
        $criteria->order = 'lastname ASC, firstname ASC';
        $teachers = User::model()->findAllByAttributes(array('role' => TEACHER), $criteria);
        $dateObj = $this->getDate($date);
        $dateTimes = $this->getDateWithTimes($dateObj);
        $pages = array();
        set_time_limit(0);
        foreach ($teachers as $teacher) {
            $temp = array();
            $appointments = Appointment::model()->with('parentchild.child', 'parentchild.user')->findAllByAttributes(array('user_id' => $teacher->id));
            $blockedAppointments = BlockedAppointment::model()->findAllByAttributes(array('user_id' => $teacher->id));
            if ($emptyPlans || !empty($appointments) || !empty($blockedAppointments)) {
                $temp['data'] = $this->generateOverviewData($teacher->id, current($dateTimes), $appointments, $blockedAppointments);
                $temp['room'] = $teacher->getRoom($dateObj->id);
                $temp['teacher'] = "{$teacher->title} {$teacher->firstname} {$teacher->lastname}";
                $temp['date'] = Yii::app()->dateFormatter->formatDateTime(strtotime($dateObj->date), 'short', null);
                $pages[] = $temp;
            }
        }
        $this->render('overviewAll', array('pages' => $pages));
    }
}
