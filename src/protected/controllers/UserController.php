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
                'actions' => array('create'),
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
        self::sendMail("c.ehringfeld@t-online.de", "ESTA-BWS", "ESTA-BWS", "testESTA", "Dies ist eine Testmessage");
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
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
                Yii::app()->user->setFlash("success", "Benutzer wurde erstellt.");
                if (Yii::app()->user->checkAccess(1)) {
                    $this->redirect(array('user/admin'));
                } else {
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

    public static function sendMail($to, $from, $name, $subject, $message) {
//        $mail = Yii::app()->Smtpmail;
//        $mail->SetFrom($from, $name);
//        $mail->Subject = $subject;
//        $mail->MsgHTML($message);
//        $mail->AddAddress($to, "");
//       //   public function Connect($host, $port = 0, $tval = 30) {
//        echo $mail->Connect("h1963533.stratoserver.net");
//        echo $mail->Connect("localhost");
//        if (!$mail->Send()) {
//            echo "Mailversandfehler: " . $mail->ErrorInfo;
//        } else {
//            echo "Mail verschickt!";
//        }
        $mail = new PHPMailer();

        //Absenderadresse der Email setzen
        $mail->From = "est@h1963533.stratoserver.net";

        //Name des Abenders setzen
        $mail->FromName = "EST";

        //Empfängeradresse setzen
        $mail->AddAddress("c.ehringfeld@t-online.de");

        //Betreff der Email setzen
        $mail->Subject = "Die erste Mail";

        //Text der EMail setzen
        $mail->Body = "Hallo! \n\n Dies ist die erste Email mit PHPMailer!";

        //EMail senden und überprüfen ob sie versandt wurde
        if (!$mail->Send()) {
            //$mail->Send() liefert FALSE zurück: Es ist ein Fehler aufgetreten
            echo "Die Email konnte nicht gesendet werden";
            echo "Fehler: " . $mail->ErrorInfo;
        } else {
            //$mail->Send() liefert TRUE zurück: Die Email ist unterwegs
            echo "Die Email wurde versandt.";
        }
    }

}
