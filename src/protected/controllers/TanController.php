<?php

/**
 * Tan Controller für das Tan Model
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
                'actions' => array('genTans'),
                'roles' => array('2', '1'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    private function tansForParentsManagement(&$model) {
        $model->attributes = $_POST['Tan'];
        if (Yii::app()->params['allowGroups'] && isset($_POST['Tan']['group_id'])) {
            $model->group_id = $_POST['Tan']['group_id'];
        }
        if ($model->validate() && is_int($model->tan_count)) {
            $tans = array();
            for ($i = 0; $i < $model->tan_count; $i++) {
                $tan = new Tan();
                $tans[] = $tan->generateTan($model->group_id);
            }
            Yii::app()->session['isTanGen'] = 1;
            $dataProvider = new CArrayDataProvider($tans, array('pagination' => array('pageSize' => Yii::app()->params['maxTanGen'])));
            $this->render('showGenTans', array('dataProvider' => $dataProvider));
        } else {
            $this->render('formGenTans', array('model' => $model));
        }
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de> 
     * action um Tans zu generieren
     */
    public function actionGenTans() {
        $model = new Tan();
        if (isset($_POST['Tan']) && Yii::app()->session['isTanGen'] != 1) {
            if (Yii::app()->params['allowParentsToManageChilds']) {
                $this->tansForParentsManagement($model);
            } else {
                $this->tansNotForParentsManagement($model);
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

    private function renderNewFormGenTans() {
        $model = array();
        $tan = new Tan();
        $tan->unsetAttributes();
        $model[] = $tan;
        $this->renderFormGenTans($model);
    }

    private function renderFormGenTans($model) {
        $this->render('formGenTans', array('model' => $model));
    }

    private function tansNotForParentsManagement(&$model) {
        $model = array();
        $tans = $_POST['Tan'];
        foreach ($tans as $i => $oneTan) {
            if (isset($_POST['Tan'][$i])) {
                $tan = new Tan();
                $tan->setAttributes($oneTan, false);
                $tan->childFirstname = $_POST['Tan'][$i]['childFirstname'];
                $tan->childLastname = $_POST['Tan'][$i]['childLastname'];
                if ($tan->generateTan()) {
                    $model[] = $tan;
                }
            }
            if (!empty($model)) {
                $dataProvider = new CArrayDataProvider($tans, array('pagination' => array('pageSize' => Yii::app()->params['maxTanGen'])));
                $this->render('showGenTans', array('dataProvider' => $dataProvider));
            } else {
                Yii::app()->user->setFlash('failMsg','Leider ist bei dem Versuch neue Tans zu generieren etwas schief gegangen.');
                $this->renderNewFormGenTans();
            }
        }
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
        if ($model === null)
            $this->throwFourNullFour();
        return $model;
    }

}
