<?php

/**
 * User Controller stellt alle Benutzer Actions zur Verfügung
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
class UserController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * Filtermethode
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Captchagenerator
     * @return array Actions
     */
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => 2,
            ),);
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('update', 'account', 'search'),
                'roles' => array(PARENTS, TEACHER),
            ),
            array('allow',
                'actions' => array('create', 'activate', 'ChangePwd', 'captcha', 'NewPw'),
                'users' => array('?'),
            ),
            array('allow',
                'roles' => array(MANAGEMENT)),
            array('deny',
                'actions' => array('deleteAll'),
                'roles' => array(MANAGEMENT)),
            array('allow',
                'roles' => array(ADMIN),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Löscht alles außer den Admin Account
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function actionDeleteAll()
    {
        Appointment::model()->deleteAll();
        DateAndTime::model()->deleteAll();
        ParentChild::model()->deleteAll();
        Child::model()->deleteAll();
        Date::model()->deleteAll();
        Tan::model()->deleteAll();
        UserHasGroup::model()->deleteAll();
        DateHasGroup::model()->deleteAll();
        Group::model()->deleteAll();
        UserHasRoom::model()->deleteAll();
        Room::model()->deleteAll();
        User::model()->deleteUsersWithRole(PARENTS);
        User::model()->deleteUsersWithRole(TEACHER);
        Yii::app()->user->setFlash('success', Yii::t('app', 'Alle Daten gelöscht, einzig die Verwaltungs- und Administrationskonten wurden nicht gelöscht')) .
                $this->redirect(array('account'));
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
     * rendert das Profilview des Users
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function actionAccount()
    {
        $model = $this->loadModel(Yii::app()->user->getId());
        if (isset($_POST['User']['tan'])) {
            $model->tan = $_POST['User']['tan'];
            if ($model->validate()) {
                $model->addWithTanNewGroup();
                $model->tan = '';
                Yii::app()->user->setFlash('success', Yii::t('app', 'Weitere TAN wurde erfolgreich hinzugefügt.'));
            }
        }
        $this->render('view', array('model' => $model));
    }

    /**
     * Überprüft einen Aktivierungslink und aktiviert gegebenenfalls einen Benutzer.
     * @param string $activationKey Aktivierungsschlüssel in sha1 als string
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function actionActivate($activationKey)
    {
        $user = User::model()->findByAttributes(array('activationKey' => $activationKey));
        if ($user != null) {
            if ($user->state == NOT_ACTIVE) {
                $user->setAttribute('state', ACTIVE);
                $user->update();
                Yii::app()->user->setFlash('success', Yii::t('app', 'Ihr Benutzerkonto wurde erfolgreich aktiviert. Sie können Sich nun einloggen.'));
            } elseif ($user->state == ACTIVE) {
                Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Ihr Benutzerkonto wurde bereits aktiviert.'));
            } elseif ($user->state == BLOCKED) {
                Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Ihr Benutzerkonto konnte nicht aktiviert werden, weil er bereits gesperrt wurde. Sollten Sie Fragen haben füllen Sie bitte das Kontaktformular aus.'));
            }
        } else {
            Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Leider konnte Ihr Aktivierungsschlüssel nicht identifiziert werden. Sollten Sie uns kontaktieren wollen, füllen Sie bitte das Kontaktformular aus.'));
        }
        $this->render('activate');
    }

    /**
     * Falls die CSV Datei hochgeladen wurde, wird diese geparsed und sofern eine E-Mail Adresse vorhanden ist eingefügt
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     *
     */
    public function actionImportTeachers()
    {
        $model = new CsvUpload();
        if (isset($_POST['CsvUpload'])) {
            $model->attributes = $_POST['CsvUpload'];
            if ($model->validate() && !empty($_FILES['CsvUpload']['tmp_name']['file'])) {
                $file = CUploadedFile::getInstance($model, 'file');
                $fp = fopen($file->tempName, 'r');
                $msg = "";
                if ($fp) {
                    if (!$model->createTeachers($fp, $msg)) {
                        Yii::app()->user->setFlash('failMsg', $msg);
                    } else {
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Lehrerliste erfolgreich importiert.'));
                    }
                    fclose($fp);
                }
            }
        }
        $this->render('importTeacher', array('model' => $model,));
    }

    public function actionCreateDummy()
    {
        $model = new DummyUserForm();
        $model->unsetAttributes();
        if (isset($_POST['DummyUserForm'])) {
            $model->attributes = $_POST['DummyUserForm'];
            if ($model->validate()) {
                $model->insert();
                $this->redirect(array('admin'));
            }
        }
        $this->render('createDummy', array(
            'model' => $model,
        ));
    }

    /**
     * Action um ein neues Passwort zu setzen
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function actionNewPw()
    {
        $model = new NewPw();
        $model->unsetAttributes();
        $user = null;
        if (isset($_GET['activationKey']) && isset($_GET['email'])) {
            $user = User::model()->findByAttributes(array('activationKey' => $_GET['activationKey'], 'email' => $_GET['email']));
        }
        if (isset($_POST['NewPw']) && !empty($user)) {
            $model->setAttributes($_POST['NewPw']);
            if ($model->validate()) {
                $user->password = $model->password;
                $user->password_repeat = $model->password_repeat;
                $user->activationKey = $user->generateActivationKey();
                if ($user->save(false)) {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Ihr Passwort konnte erfolgreich geändert werden. Sie können sich nun mit diesem einloggen.'));
                    $this->redirect(array('site/index', false));
                } else {
                    Yii::app()->user->setFlash('success', Yii::t('app', 'Leider konnte Ihr Passwort nicht geändert werden.') . ' ' . Yii::t('app', 'Bitte kontaktieren Sie den Seitenadministrator.'));
                }
                $this->render('pwChangeForm', array('model' => $model));
            }
            $this->render('pwChangeForm', array('model' => $model));
        } elseif (!empty($user)) {
            $model->activationKey = $_GET['activationKey'];
            $this->render('pwChangeForm', array('model' => $model));
        } else {
            Yii::app()->user->setFlash('success', Yii::t('app', 'Leider konnte Ihr Aktivierungsschlüssel nicht wiedererkannt werden.'));
            $this->redirect(array('site/index'), false);
        }
    }

    /**
     * Action um ein neues Passwort anzufordern
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function actionChangePwd()
    {
        $model = new ChangePwd;
        if (isset($_POST['ChangePwd'])) {
            $model->attributes = $_POST['ChangePwd'];
            if ($model->validate()) {
                $user = User::model()->findByAttributes(array('email' => $model->email));
                if ($user != null) {
                    $time = time();
                    if ($user->state == 2 && $user->bannedUntil > $time) {
                        Yii::app()->user->setFlash('failMsg', Yii::t('app', "Ihr Benutzerkonto ist noch für {sekunden} Sekunden gesperrt.", array('{sekunden}' => ($user->bannedUntil - $time))) . ' ' . Yii::t('app', 'Sie können im Anschluss Ihr Passwort zurücksetzen.'));
                    } elseif ($user->state == 1 || ($user->state == 2 && $user->bannedUntil < $time)) {
                        $user->activationKey = $user->generateActivationKey();
                        $user->update();
                        $mail = new Mail();
                        $mail->sendChangePasswordMail($user->email, $user->activationKey);
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Sie erhalten eine Aktivierungsemail mit der Sie dann ein neues Passwort setzen können.'));
                        $this->redirect(array('site/index'));
                    } else {
                        Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Bevor Sie ein neues Passwort anfordern können, muss Ihr Benutzerkonto aktiviert sein.'));
                    }
                } else {
                    Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Leider konnte Ihre E-Mail Adresse nicht im System gefunden werden.'));
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
    public function actionCreate()
    {
        if ((!Yii::app()->params['lockRegistration'] && Yii::app()->user->isGuest()) || Yii::app()->user->checkAccess(MANAGEMENT)) {
            $model = new User;
            if (isset($_POST['User'])) {
                $model->setAttributes($_POST['User']);
                if (Yii::app()->params['allowGroups'] && isset($_POST['User']['groupIds'])) {
                    $model->groupIds = $_POST['User']['groupIds'];
                }
                if ($model->save()) {
                    if (Yii::app()->user->checkAccess(MANAGEMENT)) {
                        Yii::app()->user->setFlash("success", Yii::t('app', "Benutzer wurde erstellt."));
                        $this->redirect(array('user/admin'));
                    } else {
                        Yii::app()->user->setFlash('success', Yii::t('app', "Sie konnten sich erfolgreich registrieren. Sie erhalten nun eine E-Mail mit der Sie Ihren Account aktivieren können."));
                        $mail = new Mail();
                        $mail->sendActivationLinkMail($model->email, $model->activationKey);
                        $this->redirect(array('site/login'));
                    }
                } else {
                    Yii::app()->user->setFlash("error", Yii::t('app', "Benutzer konnte nicht erstellt werden."));
                }
            }
            $this->render('create', array(
                'model' => $model,
            ));
        } else {
            $this->throwFourNullThree();
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if ((!Yii::app()->user->isAdmin() && $model->role != ADMIN) || Yii::app()->user->isAdmin()) {
            $model->password = '';
            $model->password_repeat = '';
            if (isset($_POST['User'])) {
                $model->setAttributes($_POST['User']);
                $model->updateGroups = true;
                if ($model->save()) {
                    if (Yii::app()->user->checkAccess(MANAGEMENT)) {
                        Yii::app()->user->setFlash("success", Yii::t('app', "Benutzer wurde aktualisiert."));
                        $this->redirect(array('view&id=' . $id), false);
                    } else {
                        Yii::app()->user->setFlash('success', Yii::t('app', 'Ihr Benutzerkonto wurde aktualisiert.'));
                        $this->redirect(array('account'));
                    }
                } else {
                    Yii::app()->user->setFlash("failMsg", Yii::t('app', "Benutzer konnte nicht aktualisiert werden"));
                }
            }
        } else {
            Yii::app()->user->setFlash('failMsg', Yii::t('app', 'Sie können keine Administratorkonten bearbeiten.'));
        }
        if ((Yii::app()->user->checkAccessRole(TEACHER, PARENTS) && Yii::app()->user->id == $id) || Yii::app()->user->checkAccess(MANAGEMENT)) {
            $this->render('update', array(
                'model' => $model,
            ));
        } else {
            Yii::app()->user->getFlash('failMsg');
            $this->throwFourNullThree();
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User'])) {
            $model->setAttributes($_GET['User']);
        }
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
    public function loadModel($id)
    {
        $model = User::model()->findByPk($id);
        if ($model === null) {
            $this->throwFourNullFour();
        } else {
            $model->password_repeat = $model->password;
            $model->role = $model->role;
            switch ($model->state) {
                case NOT_ACTIVE:
                    $model->stateName = Yii::t('app', "Nicht aktiv");
                    break;
                case ACTIVE:
                    $model->stateName = Yii::t('app', "Aktiv");
                    break;
                case BLOCKED:
                    $model->stateName = Yii::t('app', "Gesperrt");
                    break;
            }
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function actionUserHasGroupAdmin()
    {
        $model = new \UserHasGroup('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserHasGroup'])) {
            $model->attributes = $_GET['UserHasGroup'];
        }
        $this->renderPartial('userHasGroupAdmin', array(
            'model' => $model), false, true);
    }

    /**
     * Autocomplete suche anhand des Nachnamen
     * Wenn Eltern suchen wird nur nach Lehrern gesucht und
     * falls Gruppen aktiviert sind wird auch nur nach Lehrern entsprechend der Gruppen gesucht
     * echos JSON
     * @param integer $role Rollen ID
     * @param string $term Suchstring
     * @author Christian Ehringfeld <c.ehringfeld@t-onlined.e>
     */
    public function actionSearch($role, $term)
    {
        $dataProvider = new User();
        $dataProvider->unsetAttributes();
        $dataProvider->lastname = $term;
        if (Yii::app()->user->isTeacher() || Yii::app()->user->isParent()) {
            $dataProvider->groups = Yii::app()->user->getGroups();
            $dataProvider->state = true;
        }
        if (Yii::app()->user->isParent()) {
            $dataProvider->role = TEACHER;
        } elseif (Yii::app()->user->checkAccess('1')) {
            $dataProvider->role = $role;
        } elseif (Yii::app()->user->isTeacher() && Yii::app()->params['allowTeachersToCreateAppointments'] && !Yii::app()->params['teacherAllowBlockTeacherApps']) {
            $dataProvider->role = PARENTS;
        } elseif (Yii::app()->user->isTeacher() && Yii::app()->params['allowTeachersToCreateAppointments'] && Yii::app()->params['teacherAllowBlockTeacherApps']) {
            if ($role > 1) {
                $dataProvider->role = $role;
            } else {
                $dataProvider->role = PARENTS;
            }
        }
        $criteria = $dataProvider->searchCriteriaTeacherAutoComplete();
        $a_rc = array();
        $a_data = User::model()->findAll($criteria);
        foreach ($a_data as $record) {
            $a_rc[] = array('label' => $record->title . " "
                . $record->firstname . " " . $record->lastname
                , 'value' => $record->id);
        }
        echo CJSON::encode($a_rc);
    }
}
