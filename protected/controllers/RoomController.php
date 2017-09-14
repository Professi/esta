<?php

class RoomController extends Controller {

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
            array('allow',
                'actions' => array('index', 'view', 'assignajaxteacher', 'search'),
                'roles' => array(TEACHER),
            ),
            array('allow',
                'actions' => array('create', 'update', 'delete', 'assignajax', 'search', 'admin', 'assignall', 'deleteUserHasRoom'),
                'roles' => array(MANAGEMENT, ADMIN),
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
        $model = new Room;
        if (isset($_POST['Room'])) {
            $model->attributes = $_POST['Room'];
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
        if (isset($_POST['Room'])) {
            $model->attributes = $_POST['Room'];
            if ($model->save()) {
                $this->redirect(array('admin'));
            }
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
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    public function actionDeleteUserHasRoom($id) {
        $this->loadUserHasRoomModel($id)->delete();
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        #$dataProvider = new CActiveDataProvider('Room');
        if ((Yii::app()->user->isTeacher() && Yii::app()->params['allowTeachersToManageOwnRooms']) || Yii::app()->user->checkAccess(MANAGEMENT)) {
            return $this->render('index', array(
                'dates' => Date::simpleSelect2ListData(),
            ));
        }
        $this->throwFourNullThree();
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Room('search');
        $model->unsetAttributes();  // clear any default values
        $user_rooms = new UserHasRoom('search');
        $user_rooms->unsetAttributes();
        if (isset($_GET['Room'])) {
            $model->attributes = $_GET['Room'];
        }
        $this->render('admin', array(
            'model' => $model,
            'user_rooms' => $user_rooms,
            'dates' => Date::simpleSelect2ListData(),
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Room the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Room::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    public function loadUserHasRoomModel($id) {
        $model = UserHasRoom::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Room $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'room-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSearch($term) {
        $dataProvider = new Room();
        $dataProvider->unsetAttributes();
        $dataProvider->name = $term;
        $criteria = $dataProvider->searchAutocomplete();
        $a_rc = [];
        $a_data = Room::model()->findAll($criteria);
        foreach ($a_data as $record) {
            $a_rc[] = array('label' => $record->name
                , 'value' => $record->id);
        }
        echo CJSON::encode($a_rc);
    }

    public function actionAssignAJAXTeacher($room, $date) {
        return $this->actionAssignAJAX(Yii::app()->user->getId(), $room, $date);
    }

    /**
     * AJAX method to assign rooms to teacher
     * @param string $teacher
     * @param string $room
     * @param string $date
     * @return JSON Array with parameters and success/failure state
     */
    public function actionAssignAJAX($teacher, $room, $date) {
        $obj = new AjaxMessage();
        $obj->status = true;
        if (!empty($room)) {
            if (Yii::app()->user->checkAccessNotAdmin(TEACHER) && $teacher !== Yii::app()->user->id) {
                $this->throwFourNullThree();
            }
            $user = User::model()->findByPk($teacher);
            $existingRoom = $this->getExistingRoom($room, $obj);
            $uhr = $user->getUserHasRoom($date);
            if (!empty($uhr)) {
                $obj = $this->assignUserToRoom($user, $existingRoom, $date, $uhr);
            } else {
                $obj->status = $user->createUserHasRoom($existingRoom->getPrimaryKey(), $date);
                $obj->msg = $obj->status ? Yii::t('app', 'Verknüpfung erfolgreich erstellt.') : Yii::t('app', 'Erstellen der Verknüpfung fehlgeschlagen.');
            }
        } else {
            $obj->status = false;
            $obj->msg = Yii::t('app', 'Kein Raum angegeben.');
        }
        echo CJSON::encode(['room' => $room, 'teacher' => $teacher, 'date' => $date, 'status' => $obj->status, 'msg' => $obj->msg]);
        Yii::app()->end();
    }
    
    protected function getExistingRoom($room, &$obj) {
                    $existingRoom = Room::model()->findByAttributes(array('name' => $room));
            if (empty($existingRoom)) {
                $existingRoom = new Room();
                $existingRoom->name = $room;
                if (!$existingRoom->save()) {
                    $obj->status = false;
                    $obj->msg = Yii::t('app', 'Erstellen des Raumes fehlgeschlagen');
                }
            }
            return $existingRoom;
    }
    
    protected function assignUserToRoom($user,$existingRoom,$date,$uhr) {
                        $newUhr = new UserHasRoom();
                $newUhr->user_id = $user->getPrimaryKey();
                $newUhr->room_id = $existingRoom->getPrimaryKey();
                $newUhr->date_id = $date;
                $obj = new AjaxMessage();
                if ($uhr->delete() || UserHasRoom::model()->count(array('room_id' => $uhr->room_id, 'date_id' => $uhr->date_id)) <= 0) {
                    $obj->status = $newUhr->save();
                    $obj->msg = $obj->status ? Yii::t('app', 'Verknüpfung erfolgreich verändert.') : Yii::t('app', 'Verändern der Verknüpfung fehlgeschlagen.');
                } else {
                    $obj->status = false;
                    $obj->msg = Yii::t('app', 'Verändern der Verknüpfung fehlgeschlagen.');
                }
                return $obj;
    }

    public function actionAssignAll() {
        $this->render('assign_all', array(
            'teachers' => User::model()->findAllByAttributes(['role' => TEACHER], ['select' => 'id,firstname,lastname,title']),
            'dates' => Date::simpleSelect2ListData(),
        ));
    }

}
