<?php

/**   Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 *   This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
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
                //   'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function actions() {
        return array(
// captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => 1,
            ),);
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('update', 'account', 'search'),
                'roles' => array('3', '2'),
            ),
            array('allow',
                'actions' => array('create', 'activate', 'ChangePwd', 'captcha', 'NewPw'),
                'users' => array('?'),
            ),
            array('allow',
                'roles' => array('0')),
            array('deny',
                'actions' => array('deleteAll'),
                'roles' => array('1')),
            array('allow',
                'roles' => array('1'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * 
     * @param string $term
     * @author Christian Ehringfeld <c.ehringfeld@t-onlined.e>
     * @todo Sinnvolle JSON Ausgabe
     */
    public function actionSearch($role,$term) {
        $dataProvider = new User();
        $dataProvider->unsetAttributes();
        $dataProvider->lastname = $term;
        if(Yii::app()->user->checkAccess('3') && !Yii::app()->user->isAdmin()) {
            $dataProvider->role = 2;
        }
        else if(is_int($role) && $role < 4 && $role >= 0) {
            $dataProvider->role = $role;
        } else {
        $dataProvider->role = 2;
        }
        $criteria = $dataProvider->searchCriteriaTeacherAutoComplete();
        $a_rc = array();
        $a_data = User::model()->findAll($criteria);
        print_r($a_data);
        foreach ($a_data as $record) {
            $a_rc[] = array('label' => $record->title . " "
                . $record->firstname . " " . $record->lastname
                , 'value' => $record->id);
        }
        echo CJSON::encode($a_rc);
    }

    public function actionDeleteAll() {
        Appointment::model()->deleteAll();
        DateAndTime::model()->deleteAll();
        ParentChild::model()->deleteAll();
        Child::model()->deleteAll();
        Date::model()->deleteAll();
        Tan::model()->deleteAll();
        $a_delete = User::model()->findAll(User::deleteAllCriteria());
        foreach ($a_delete as $record) {
            $record->delete();
        }
        Yii::app()->user->setFlash('success', 'Alle Daten gelöscht, einzig die Verwaltungs- und Administrationskonten wurden nicht gelöscht') .
        $this->redirect('index.php?r=user/account');
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
     * rendert das eigene Profilview
     */
    public function actionAccount() {
        $this->render('view', array('model' => $this->loadModel(Yii::app()->user->getId())));
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
                Yii::app()->user->setFlash('failMsg', 'Ihr Account wurde bereits aktiviert.');
            } else if ($user->state == 2) {
                Yii::app()->user->setFlash('failMsg', 'Ihr Account konnte nicht aktiviert werden, weil er bereits gesperrt wurde. Sollten Sie Fragen haben füllen Sie bitte das Kontaktformular aus.');
            }
        } else {
            Yii::app()->user->setFlash('failMsg', 'Leider konnte Ihr Aktivierungsschlüssel nicht identifiziert werden. Sollten Sie uns kontaktieren wollen, füllen Sie bitte das Kontaktformular aus.');
        }
        $this->render('activate');
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * Falls die CSV Datei hochgeladen wurde, wird diese geparsed und sofern eine E-Mail Adresse vorhanden ist eingefügt
     * 
     */
    public function actionImportTeachers() {
        $model = new CsvUpload();
        if (isset($_POST['CsvUpload'])) {
            $model->attributes = $_POST['CsvUpload'];
            if ($model->validate() && !empty($_FILES['CsvUpload']['tmp_name']['file'])) {
                $file = CUploadedFile::getInstance($model, 'file');
                $fp = fopen($file->tempName, 'r');
                if ($fp) {
                    $first = true;
                    do {
                        if (!$first) {
                            if ($line[0] != "Vorname" && !$line[1] != "Nachname" && $line[2] != 'Email') {
                                $model = new User();
                                $model->firstname = self::encodingString($line[1]);
                                $model->lastname = self::encodingString($line[0]);
                                if ($line[2] != NULL) {
                                    $model->email = self::encodingString($line[2]);
                                } else {
                                    $uml = array("Ö" => "Oe", "ö" => "oe", "Ä" => "Ae", "ä" => "ae", "Ü" => "Ue", "ü" => "ue", "ß" => "ss",);
                                    $model->email = strtolower(substr($model->firstname, 0, 1))
                                            . '.' . preg_replace("/\s+/", "", strtolower(strtr($model->lastname, $uml))) . '@'
                                            . Yii::app()->params['teacherMail'];
                                }
                                $model->username = $model->email;
                                $model->title = self::encodingString($line[3]);
                                $model->state = 1;
                                $model->role = 2;
                                $model->password = "DONNERSTAG01";
                                $model->password_repeat = $model->password;
                                $model->save();
                            }
                        } else {
                            $first = false;
                        }
                    } while (($line = fgetcsv($fp, 1000, ";")) != FALSE);
                }
                $this->redirect('index.php?r=/user/admin');
            } else {
                $this->render('importTeacher', array('model' => $model,));
            }
        } else {
            $this->render('importTeacher', array('model' => $model,));
        }
    }

    /**
     * Konvertiert eine Datei in ISO-8859-1 in UTF-8
     * @param string $toEncode
     * @return string
     * 
     */
    static private function encodingString($toEncode) {
        return mb_convert_encoding($toEncode, 'UTF-8', 'ISO-8859-1');
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * Action um ein neues Passwort zu setzen
     */
    public function actionNewPw() {
        $model = new NewPw();
        if (isset($_POST['NewPw'])) {
            $model->setAttributes($_POST['NewPw']);
            if ($model->validate()) {
                $user = User::model()->findByAttributes(array('activationKey' => $_GET['activationKey']));
                if ($user !== NULL) {
                    $user->password = $model->password;
                    $user->generateActivationKey();
                    Yii::app()->user->setFlash('success', 'Ihr Passwort konnte erfolgreich geändert werden. Sie können sich nun mit diesem einloggen.');
                } else {
                    Yii::app()->user->setFlash('success', 'Leider konnte Ihr Passwort aus unerklärlichen Gründen nicht geändert werden.');
                }
            }
            $this->redirect('index.php?r=/site/index');
        } else if (isset($_GET['activationKey'])) {
            $user = User::model()->findByAttributes(array('activationKey' => $_GET['activationKey']));
            if ($user !== NULL) {
                $model->activationKey = $_GET['activationKey'];
                $this->render('pwChangeForm', array('model' => $model));
            } else {
                Yii::app()->user->setFlash('success', 'Leider konnte Ihr Aktivierungsschlüssel nicht wiedererkannt werden.');
                $this->redirect('index.php?r=/site/index');
            }
        }
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * Action um ein neues Passwort anzufordern
     */
    public function actionChangePwd() {
        $model = new ChangePwd;
        if (isset($_POST['ChangePwd'])) {
            $model->attributes = $_POST['ChangePwd'];
            if ($model->validate()) {
                $user = User::model()->findByAttributes(array('email' => $model->email));
                if ($user != null) {
                    if ($user->state == 1) {
                        $user->activationKey = $user->generateActivationKey();
                        $user->password = "dummyPassworddummyPassword";
                        $user->save();
                        self::sendMail(Yii::app()->params['fromMail'] . ' Passwort ändern', "Sie haben bei " . Yii::app()->name . " versucht Ihr Passwort zu ändern. Mit Hilfe des folgenden Links können Sie Ihr Passwort ändern:\n "
                                . "http://" . $_SERVER["HTTP_HOST"] . Yii::app()->params['virtualHost'] . "/index.php?r=/User/NewPw&activationKey=" . $user->activationKey, $user->email, Yii::app()->params['fromMailHost'], Yii::app()->params['fromMail']);
                        Yii::app()->user->setFlash('success', 'Sie erhalten nun eine Aktivierungsemail mit der Sie dann ein neues Passwort setzen können.');
                        $this->redirect('index.php?r=/site/index');
                    } else {
                        Yii::app()->user->setFlash('failMsg', 'Bevor Sie ein neues Passwort anfordern können, muss Ihr Account aktiviert sein.');
                    }
                } else {
                    Yii::app()->user->setFlash('failMsg', 'Leider konnte Ihre E-Mail Adresse nicht im System gefunden werden.'); //success  - failMsg
                    $this->refresh();
                }
            }
        }
        $this->render('changePassword', array('model' => $model));
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
                            . "http://" . $_SERVER["HTTP_HOST"] . Yii::app()->params['virtualHost'] . "index.php?r=/User/activate&activationKey=" . $model->activationKey, $model->email, Yii::app()->params['fromMailHost'], Yii::app()->params['fromMail']);
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
        if (isset($_POST['User'])) {
            $model->setAttributes($_POST['User']);

            if ($model->save()) {
                Yii::app()->user->setFlash("success", "Benutzer wurde aktualisiert.");
                $this->redirect(array('view&id=' . $id), false);
            } else {
                Yii::app()->user->setFlash("error", "Benutzer konnte nicht aktualisiert werden.");
            }
        } else {
            $model->password = "dummyPassworddummyPassword";
            $model->password_repeat = $model->password;
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
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['user'];
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
        $model->password_repeat = $model->password;
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

    /**
     * Versendet eine E-Mail
     * @param string $subject Betreff einer E-Mail
     * @param string $message Nachricht einer E-Mail
     * @param string $to Empfänger der Nachricht
     * @param string $from Absender der Nachricht
     * @param string $fromName Absendername
     */
    public static function sendMail($subject, $message, $to, $from, $fromName) {
        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
        $mailer->Host = Yii::app()->params['emailHost'];
        $mailer->IsSMTP();
        $mailer->From = $from;
        $mailer->AddAddress($to);
        $mailer->FromName = $fromName;
        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = $subject;
        $mailer->Body = $message;
        $mailer->Send();
    }

}
