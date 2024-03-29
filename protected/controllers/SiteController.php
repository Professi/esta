<?php

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

/**
 * SiteController für Forms/Static Pages ohne echtes Datenmodell
 */
class SiteController extends Controller
{

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * action um (fast) alle Daten der Anwendung zu löschen
     * @throws CHttpException
     */
    public function actionDeleteAll()
    {
        if (Yii::app()->user->checkAccess(ADMIN)) {
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
    
    public function actionFaq() {
        //silly js workaround
        $model = new ContactForm;
        $this->render('pages/faq', array('model' => $model));
    }
    

    public function actionSendTestMail()
    {
        if (Yii::app()->user->isAdmin()) {
            $model = new Testmail();
            $model->recipient = Yii::app()->params['adminEmail'];
            if (isset($_POST['Testmail'])) {
                $model->setAttributes($_POST['Testmail']);
                if ($model->validate()) {
                    $mail = new Mail();
                    $mail->sendTestMail($model->recipient);
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Testmail wurde gesendet.'));
                    $this->redirect(array('config'));
                }
            }
            $this->render('sendTestmail', array('model' => $model));
        } else {
            $this->throwFourNullThree();
        }
    }

    /**
     * @param type $option
     * @return mixed
     */
    public static function getDisabledOptions($option)
    {
        if ($option === 0) {
            return array('options' => array('disabled' => true));
        } else {
            return '';
        }
    }

    /**
     * action für das Konfigurationsskript
     */
    public function actionConfig()
    {
        if (Yii::app()->user->checkAccess(ADMIN)) {
            $configList = ConfigEntry::model()->findAll();
            $model = new ConfigForm();
            $class = new ReflectionClass('ConfigForm');
            foreach ($configList as $value) {
                if ($class->hasProperty($value->key)) {
                    $class->getProperty($value->key)->setValue($model, $value->value);
                }
            }
            $optionsBans = self::getDisabledOptions($model->banUsers);
            $optionsBlocks = self::getDisabledOptions($model->allowBlockingAppointments);
            if (isset($_POST['ConfigForm'])) {
                $model->attributes = $_POST['ConfigForm'];
                $model->config($class);
            }
            $this->render('config', array(
                'model' => $model,
                'optionsBans' => $optionsBans,
                'optionsBlocks' => $optionsBlocks,
            ));
        } else {
            $this->throwFourNullThree();
        }
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->actionLogin();
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $subject = $model->subject;
                $mail = new Mail;
                if (Yii::app()->params['useSchoolEmailForContactForm']) {
                    $toMail = Yii::app()->params['schoolEmail'];
                } else {
                    $toMail = Yii::app()->params['adminEmail'];
                }
                $model->body = Yii::t('app', 'Hallo,') . '<br/>' . Yii::t('app', '{name} hat Ihnen folgende Nachricht über das Kontaktformular von ESTA gesendet:', array('{name}' => $model->name)) . '<br/><br/><div>' . $model->body . '</div>';
                $model->body .= "<br/><br/>" . Yii::t('app', 'Um auf diese E-Mail zu antworten, schreiben Sie bitte eine E-Mail an {email}.', array('{email}' => '<a href="mailto:' . $model->email . '">' . $model->email . '</a>'));
                $mail->sendMail($subject, $model->body, $toMail, Yii::app()->params['fromMailHost'], Yii::app()->params['fromMail']);
                Yii::app()->user->setFlash('success', Yii::t('app', 'Vielen Dank dass Sie uns kontaktieren. Wir werden Ihnen so schnell wie möglich antworten.'));
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Zeigt die Login Seite an
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function actionLogin()
    {
        if (Yii::app()->user->isGuest) {
            $model = new LoginForm;
            if (isset($_POST['LoginForm'])) {
                $model->attributes = $_POST['LoginForm'];
                if ($model->validate() && $model->authenticate()) {
                    if (!Yii::app()->user->isAdmin()) {
                        if (Yii::app()->user->checkAccess(MANAGEMENT)) {
                            $this->redirect(array('Appointment/admin'));
                        }
                        $this->redirect(array('Appointment/index'));
                    } else {
                        $this->redirect(array('Date/admin'));
                    }
                }
            }
            $this->render('login', array('model' => $model));
        } else {
            $this->redirect(array('User/account'));
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        if (!Yii::app()->user->isGuest()) {
            Yii::app()->user->logout();
        }
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Zeigt die Statistikseite an
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function actionStatistics()
    {
        if (!Yii::app()->user->isGuest()) {
            $appointments = Appointment::model()->count() + BlockedAppointment::model()->count();
            $teachers = User::model()->countByAttributes(array('role' => TEACHER));
            $freeAppointments = (DateAndTime::model()->count() * $teachers) - $appointments;
            $this->render('statistics', array('freeApps' => $freeAppointments, 'apps' => $appointments, 'teachers' => $teachers));
        } else {
            $this->throwFourNullThree();
        }
    }
}
