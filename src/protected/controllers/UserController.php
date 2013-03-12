<?php

class UserController extends Controller {

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
//            'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('update', 'view'),
                'roles' => array('3', '2'),
            ),
            array('allow',
                'actions' => array('create', 'activate', 'ChangePwd'),
                'users' => array('?'),
            ),
            array('allow',
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
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * Überprüft einen Aktivierungslink und aktiviert gegebenenfalls einen Benutzer.
     */
    public function actionActivate($activationKey) {
        $user = User::model()->findByAttributes(array('activationKey' => $activationKey));
        if ($user !== NULL) {
            if ($user->state == 0) {
                $user->setAttribute('state', 1);
                $user->save();
                Yii::app()->user->setFlash('success', 'Ihr Account wurde erfolgreich aktiviert. Sie können Sich nun einloggen.');
            } else if ($user->state == 1) {
                Yii::app()->user->setFlash('activateFail', 'Ihr Account wurde bereits aktiviert.');
            } else if ($user->state == 2) {
                Yii::app()->user->setFlash('activateFail', 'Ihr Account konnte nicht aktiviert werden, weil er bereits gesperrt wurde. Sollten Sie Fragen haben füllen Sie bitte das Kontaktformular aus.');
            }
        } else {
            Yii::app()->user->setFlash('activateFail', 'Leider konnte Ihr Aktivierungsschlüssel nicht identifiziert werden. Sollten Sie uns kontaktieren wollen, füllen Sie bitte das Kontaktformular aus.');
        }
        $this->render('activate');
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * Dummy Funktion
     * 
     */
    public function actionChangePwd() {
        if (isset($_POST['email'])) {
            $user = User::model()->findByAttributes(array('email' => $_POST['email']));
            if ($user !== null) {
                self::sendMail(Yii::app()->params['fromMail'] . ' Passwort ändern', "Sie haben bei " . Yii::app()->name . ". versucht Ihr Passwort zu ändern. Mit hilfe des folgenden Links können Sie Ihr Passwort ändern:\n "
                        . "http://" . $_SERVER["HTTP_HOST"] . Yii::app()->params['virtualHost'] . "index.php?r=/User/changePwd&activationKey=" . $user->activationKey, $user->email);
                Yii::app()->user->setFlash('success', 'Sie erhalten nun eine Aktivierungsemail mit der Sie dann ein neues Passwort setzen können.');
            } else {
                Yii::app()->user->setFlash('failMsg', 'Leider konnte Ihrer E-Mail Adresse kein Benutzerkonto zugeordnet werden.'); //success  - failMsg
            }
        } else if (isset($_GET['activationKey'])) {
            
        } else {
                    $model = new ChangePwd;
            $this->render('changePassword', array('model' => $model));
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new User;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->setAttributes($_POST['User']);
            if ($model->save()) {

                if (Yii::app()->user->checkAccess(1)) {
                    Yii::app()->user->setFlash("success", "Benutzer wurde erstellt.");
                    $this->redirect(array('user/admin'));
                } else {
                    Yii::app()->user->setFlash('success', "Sie konnten sich erfolgreich registrieren. Sie erhalten nun eine E-Mail mit der Sie Ihren Account aktivieren können.");
                    self::sendMail(Yii::app()->params['fromMail'] . ' Accountaktivierung', "Willkommen bei der " . Yii::app()->name . ". Ihr Accountname lautet: " . $model->email . "\n Bitte aktivieren Sie ihren Account anhand folgendem Links:\n "
                            . "http://" . $_SERVER["HTTP_HOST"] . Yii::app()->params['virtualHost'] . "index.php?r=/User/activate&activationKey=" . $model->activationKey, $model->email);
                    $this->redirect(array('site/login'));
                }
            } else {
                Yii::app()->user->setFlash("error", "Benutzer konnte nicht erstellt werden.");
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
        // Uncomment the following line if AJAX validation is needed
        //  $this->performAjaxValidation($model);
        if (isset($_POST['User'])) {
            $model->setAttributes($_POST['User']);

            if ($model->save()) {
                Yii::app()->user->setFlash("success", "Benutzer wurde aktualisiert.");
                $this->redirect(array('view&id=' . $id), false);
            } else {
                Yii::app()->user->setFlash("error", "Benutzer konnte nicht aktualisiert werden.");
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

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

//    /**
//     * Lists all models.
//     */
//    public function actionIndex() {
//        $dataProvider = new CActiveDataProvider('User');
//        $this->render('index', array(
//            'dataProvider' => $dataProvider,
//        ));
//    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model with Role
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        //lädt die Rolle
        $model->password_repeat = $model->password;
        $model->oldPw = $model->password;
        $model->role = UserRole::model()->findByAttributes(array('user_id' => $id))->role_id;
        switch ($model->state) {
            case 0:
                $model->stateName = "Nicht aktiv";
                break;
            case 1:
                $model->stateName = "Aktiv";
                break;
            case 2:
                $model->stateName = "Gesperrt";
                break;
        }
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionChange() {
        $model = new PasswordChangeForm();
        if (isset($_POST["PasswordChangeForm"])) {
            $attributes = $_POST["PasswordChangeForm"];
            $currentUserId = Yii::app()->user->id;
            $attributes["user_id"] = $currentUserId;
            $model->setAttributes($attributes);
            if ($model->validate()) {
                $user = User::model()->findByPk($currentUserId);
                $user->password = $_POST["PasswordChangeForm"]["password"];
                $user->password_repeat = $_POST["PasswordChangeForm"]["password"];
                Yii::app()->user->setFlash("success", "Passwort wurde geändert.");
                if ($user->save())
                    if (Yii::app()->user->checkAccess(1)) {
                        $this->redirect('User/admin');
                    }
                $this->redirect("User/view&id=" . Yii::app()->user->getId());
            }
        }
        $this->render("change", array("model" => $model));
    }

    public static function sendMail($subject, $message, $to) {
        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
        $mailer->Host = Yii::app()->params['emailHost'];
        $mailer->IsSMTP();
        $mailer->From = Yii::app()->params['fromMailHost'];
        $mailer->AddAddress($to);
        $mailer->FromName = Yii::app()->params['fromMail'];
        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = $subject;
        $mailer->Body = $message;
        $mailer->Send();
    }

}
