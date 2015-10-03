<?php

/**
 * Tan Controller für das Tan Model
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
class TanController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * Filtermethode
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
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
                'actions' => array('genTans', 'pupilImport'),
                'roles' => array(TEACHER, MANAGEMENT),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * tans for Parents Management
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    private function tansForParentsManagement(&$model, $csv = true) {
        $model = new Tan();
        if (isset($_POST['Tan'])) {
            $model->setAttributes($_POST['Tan']);
        }
        $tans = array();
        for ($i = 0; $i < $model->tan_count; $i++) {
            $tan = new Tan();
            $tan->group_id = $model->group_id;
            $tan->generateTan();
            $tans[] = $tan;
        }
        Yii::app()->session['isTanGen'] = 1;
        if ($csv) {
            $this->generateCSVFile($tans, true);
        } else {
            $dataProvider = new CArrayDataProvider($tans, array('pagination' => array('pageSize' => Yii::app()->params['maxTanGen'])));
            $this->render('showGenTans', array('dataProvider' => $dataProvider));
        }
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de> 
     * renders showGenTans when allowParentsToManageChilds activated
     * @param Tan $model
     */
    private function tansNotForParentsManagement(&$model, $csv = false) {
        $validate = true;
        $model = $this->iterateOverTans($_POST['Tan'], $validate);
        if (!empty($model) && $validate) {
            if ($csv) {
                $this->generateCSVFile($model, false);
            } else {
                $dataProvider = new CArrayDataProvider($model);
                $this->render('showGenTans', array('dataProvider' => $dataProvider));
            }
        } else {
            $this->renderFormGenTans($model);
        }
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de> 
     * action um Tans zu generieren
     */
    public function actionGenTans() {
        $csv = false;
        if (isset($_POST['csv'])) {
            $csv = true;
        }
        $model = new Tan();
        if (isset($_POST['Tan']) && Yii::app()->session['isTanGen'] != 1) {
            if (Yii::app()->params['allowParentsToManageChilds']) {
                $this->tansForParentsManagement($model, $csv);
            } else {
                $this->tansNotForParentsManagement($model, $csv);
            }
        } else {
            if (isset(Yii::app()->session['isTanGen'])) {
                unset(Yii::app()->session['isTanGen']);
            }
            if (!Yii::app()->params['allowParentsToManageChilds']) {
                $model = array();
                $tan = new Tan();
                $tan->unsetAttributes();
                $model[] = $tan;
            }
            $this->renderFormGenTans($model);
        }
    }

    /**
     * 
     * @param array $tans
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    protected function generateCSVFile($tans, $parentManagement = true) {
        $allowGroups = Yii::app()->params['allowGroups'];
//        $filename = Yii::getPathOfAlias('webroot') . '/assets/tans' . date("Ymd") . '.csv';
//        $fp = fopen($filename, 'w+');
        //$fp = fopen('php://output', 'w+');
        $fp = fopen('php://output', 'w');
        $delimiter = ";";
        $enclosure = '"';
        $data = array(Yii::t('app', 'TAN'));
        if ($allowGroups) {
            $data[] = Yii::t('app', 'Gruppe');
        }
        if (!$parentManagement) {
            $data[] = Yii::t('app', 'Vorname');
            $data[] = Yii::t('app', 'Nachname');
        }
        fputcsv($fp, $data, $delimiter, $enclosure);
        if (is_array($tans)) {
            foreach ($tans as $tan) {
                $d = array($tan->tan);
                if ($allowGroups) {
                    if (is_object($tan->group)) {
                        $d[] = $tan->group->groupname;
                    } else {
                        $d[] = '';
                    }
                }
                if (!$parentManagement) {
                    if (is_object($tan->child)) {
                        $d[] = $tan->child->firstname;
                        $d[] = $tan->child->lastname;
                    }
                }
                fputcsv($fp, $d, $delimiter, $enclosure);
            }
        }
        Yii::app()->getRequest()->sendFile('tans' . date('Ymd') . '_esta.csv', stream_get_contents($fp), "text/csv");
        fclose($fp);
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de> 
     * action um Schüler zu importieren
     */
    public function actionPupilImport() {
        $model = new PupilImport();
        if (isset($_POST['PupilImport']) && $model->setAttributes($_POST['PupilImport']) && $model->validate() && !empty($_FILES['PupilImport']['tmp_name']['file'])) {
            $model->createTans();
            $dataProvider = new CArrayDataProvider($model->getModel());
            $this->render('showGenTans', array('dataProvider' => $dataProvider));
        } else {
            $this->render('importPupils', array('model' => $model, 'groups' => $this->getAvailableGroups()));
        }
    }

    /**
     * returns empty Tan Model in a array with only one object
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de> 
     * @return \Tan
     */
    private function getEmptyTanModel() {
        $model = array();
        $tan = new Tan();
        $tan->unsetAttributes();
        $model[] = $tan;
        return $model;
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de> 
     * renders formGenTans
     * @param Tan $model
     */
    private function renderFormGenTans($model) {
        $this->render('formGenTans', array('model' => $model, 'groups' => $this->getAvailableGroups()));
    }

    /**
     * Returns all Groups of a user
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de> 
     * @return array of groups
     */
    private function getAvailableGroups() {
        $groups = array();
        if (Yii::app()->params['allowGroups']) {
            if (empty(Yii::app()->user->getGroups()) || Yii::app()->user->checkAccess('1')) {
                $groups = Group::model()->getAllGroups('DESC');
            } else {
                $groups = Group::formatGroups(Yii::app()->user->getGroups(), 'DESC');
            }
        }
        return $groups;
    }

    /**
     * iterates over Tan Array
     * @param array $tans
     * @param boolean $validate
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de> 
     * @return Tan
     */
    private function iterateOverTans($tans, &$validate) {
        $model = array();
        foreach ($tans as $i => $oneTan) {
            $ok = true;
            if (isset($_POST['Tan'][$i])) {
                $tan = new Tan();
                if (array_key_exists('group_id', $_POST['Tan'][$i])) {
                    $tan->group_id = $_POST['Tan'][$i]['group_id'];
                }
                $firstname = trim($_POST['Tan'][$i]['childFirstname']);
                $lastname = trim($_POST['Tan'][$i]['childLastname']);
                if (!Yii::app()->params['allowParentsToManageChilds'] && !empty($firstname) && !empty($lastname)) {
                    $tan->childFirstname = $firstname;
                    $tan->childLastname = $lastname;
                } else {
                    $ok = false;
                }
                if ($ok) {
                    $tan->tan_count = 1;
                    $tan->generateTan();
                    $model[] = $tan;
                } else {
                    $validate = false;
                }
            }
        }
        if (empty($model) || !$validate) {
            $model = $this->getEmptyTanModel();
            $validate = false;
        }
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Tan the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Tan::model()->findByPk($id);
        if ($model === null) {
            $this->throwFourNullFour();
        }
        return $model;
    }

}
