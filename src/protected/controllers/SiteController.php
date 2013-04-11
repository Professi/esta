<?php

/**
 * SiteController für Forms/Static Pages ohne echtes Datenmodell
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
class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * action um (fast) alle Daten der Anwendung zu löschen
     * @throws CHttpException
     */
    public function actionDeleteAll() {
        if (Yii::app()->user->checkAccess('0')) {
            $model = new DeleteAllForm();
            if (isset($_POST['DeleteAllForm'])) {
                $model->setAttributes($_POST['DeleteAllForm']);
                if ($model->validate()) {
                    $model->delete();
                }
            }
            $this->render('deleteAll', array('model' => $model));
        } else {
            $this->throwFourNullThree();
        }
    }

    public function actionConfig() {
        if ((Yii::app()->user->checkAccess('0') && Yii::app()->params['installed']) || !Yii::app()->params['installed']) {
            $model = new ConfigForm();
            $optionsMails = (isset($model->mailsActivated)&& $model->mailsActivated === 0)? array('options'=>array('disabled'=>true)):'';
            $optionsBans = (isset($model->banUsers)&& $model->banUsers === 0)? array('options'=>array('disabled'=>true)):'';;
            $optionsBlocks = (isset($model->allowBlockingAppointments)&& $model->allowBlockingAppointments === 0)? array('options'=>array('disabled'=>true)):'';;
            if (isset($_POST['ConfigForm'])) {
                $createAdminUser = false;
                $file = Yii::app()->basePath . '/config/params.inc';
                $model->attributes = $_POST['ConfigForm'];
                if ($model->validate()) {
                    if (Yii::app()->params['installed'] == 0) {
                        $createAdminUser = true;
                    }
                    $model->installed = 1;
                    $str = base64_encode(serialize($model->attributes));
                    file_put_contents($file, $str);
                    if ($createAdminUser) {
                        $user = new User();
                        $user->email = $model->adminEmail;
                        $user->username = $user->email;
                        $user->firstname = 'admin';
                        $user->lastname = 'admin';
                        $user->state = 1;
                        $user->role = 0;
                        if (Yii::app()->params['randomTeacherPassword']) {
                            $passGen = new PasswordGenerator();
                            $user->password = $passGen->generate();
                        } else {
                            $user->password = Yii::app()->params['defaultTeacherPassword'];
                        }
                        $password = $user->password;
                        $user->password_repeat = $user->password;
                        if ($user->save() && Yii::app()->params['randomTeacherPassword']) {
                            $mail = new Mail();
                            $mail->sendRandomUserPassword($user->email, $password);
                        }
                        $msg = "Konfiguration aktualisiert. Außerdem wurde ein Administratorkonto erstellt. Ihr Benutzerkontenname lautet: "
                                . $user->email . " Ihr Passwort lautet:" . $password;
                        if ($model->randomTeacherPassword) {
                            $msg .= " .Sollten Sie nun eine Bestätigungsemail erhalten, wurde die Anwendung erfolgreich konfiguriert.";
                        }
                        Yii::app()->user->setFlash('success', $msg);
                    } else {
                        Yii::app()->user->setFlash('success', 'Konfiguration aktualisiert.');
                    }
                }
            } $this->render('config', array(
                                'model' => $model,
                                'optionsBans' => $optionsBans,
                                'optionsBlocks' => $optionsBlocks,
                                'optionsMails' => $optionsMails,
                            ));
        } else {
            $this->throwFourNullThree();
        }
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        //	$this->render('index');
        self::actionLogin();
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $mail = new Mail;
                $mail->sendMail($subject, $model->body, Yii::app()->params['adminEmail'], $model->email, $name);
                Yii::app()->user->setFlash('contact', 'Vielen Dank dass Sie uns kontaktieren. Wir werden Ihnen so schnell wie möglich antworten.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Zeigt die Login Seite an
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function actionLogin() {
        if (Yii::app()->user->isGuest) {
            $model = new LoginForm;
            if (isset($_POST['LoginForm'])) {
                $model->attributes = $_POST['LoginForm'];
                if ($model->validate() && $model->authenticate()) {
                    if (!Yii::app()->user->isAdmin()) {
                        if (Yii::app()->user->checkAccess('1')) {
                            $this->redirect('index.php?r=/Appointment/admin');
                        }
                        $this->redirect('index.php?r=/Appointment/Index');
                    } else {
                        $this->redirect('index.php?r=/Date/admin');
                    }
                }
            }
            $this->render('login', array('model' => $model));
        } else {
            $this->redirect('index.php?r=User/account');
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}
