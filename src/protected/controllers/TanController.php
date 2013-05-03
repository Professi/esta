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
     * action um Tans zu generieren
     */
    public function actionGenTans() {
        $model = new Tan();
        if (isset($_POST['Tan']) && Yii::app()->session['isTanGen'] != 1) {
            $model->attributes = $_POST['Tan'];
            if (Yii::app()->params['allowGroups']) {
                $model->group_id = $_POST['Tan']['group_id'];
            }
            if ($model->validate()) {
                Yii::app()->session['isTanGen'] = 1;
                $dataProvider = new CArrayDataProvider(self::generateTan($model->tan_count, $model->group_id), array('pagination' => array('pageSize' => Yii::app()->params['maxTanGen'])));
                $this->render('showGenTans', array('dataProvider' => $dataProvider));
            } else {
                $this->render('formGenTans', array('model' => $model));
            }
        } else {
            if (isset(Yii::app()->session['isTanGen'])) {
                unset(Yii::app()->session['isTanGen']);
            }
            $this->render('formGenTans', array('model' => $model));
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

    /**
     * Generiert n-Tans
     * @param integer $count Anzahl der zu generierenden TAN's
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array Beinhaltet TAN's
     */
    public function generateTan($count, $groupId = "") {
        $a_rc = array();
        $ok = false;
        if (Yii::app()->params['allowGroups'] && Group::model()->findByPk($groupId) != null) {
            $ok = true;
        }
        for ($i = 0; $i < $count; ++$i) {
            $tan = new Tan;
            $sTan = "";
            for ($x = 0; $x < Yii::app()->params['tanSize']; ++$x) {
                $sTan .= rand(0, 9);
            }
            $tan->tan = $sTan;
            $tan->used = false;
            $tan->tan_count = 1;
            if (Yii::app()->params['allowGroups'] && $ok) {
                $tan->group_id = $groupId;
            }
            if (strlen($tan->tan) == Yii::app()->params['tanSize'] && Tan::model()->countByAttributes(array('tan' => $tan->tan)) == 0) {
                if ($tan->save()) {
                    $tan->id = $i;
                    $a_rc[] = $tan;
                }
            } else {
                --$i;
            }
        }
        return $a_rc;
    }

}
