<?php
/**
 * ParentChild Controller für Model ParentChild 
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
class ParentChildController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * Filtermethoden
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
                'roles' => array('1'),
            ),
            array('allow',
                'actions' => array('create', 'index', 'delete'),
                'roles' => array('3'),
            ),
            array('deny',
                'users' => array('*'), // deny all users
            ),
        );
    }

    /**
     * Suche fuer Elternkindverknuepfungen anhand von  dem Namen des Erziehungsberechtigten 
     * @param string $term
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * echo JSON
     */
    public function actionSearch($term) {
        $dataProvider = new ParentChild();
        $dataProvider->unsetAttributes();
        $criteria = $dataProvider->searchParentChild($term);
        $a_rc = array();
        $a_data = ParentChild::model()->findAll($criteria);
        foreach ($a_data as $record) {
            $a_rc[] = array('label' => $record->user->firstname . " " . $record->user->lastname .
                ";Kind: " . $record->child->firstname . " " . $record->child->lastname, 'value' => $record->id);
        }
        echo CJSON::encode($a_rc);
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        if (Yii::app()->user->checkAccess(1)) {
            $dataProvider = new CActiveDataProvider('ParentChild');
        } else {
            $dataProvider = new CActiveDataProvider('ParentChild', array(
                'criteria' => array('condition' => 'user_id=' .
                    Yii::app()->user->getId())));
        }
        $this->render('index', array('dataProvider' => $dataProvider,));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new ParentChild;
        $userNameString = '';
        if (isset($_GET['id'])) {
            $userTemp = User::model()->findByPk($_GET['id']);
            $model->user_id = $_GET['id'];
            $userNameString = $userTemp->firstname . " " . $userTemp->lastname;
        }
        if (isset($_POST['ParentChild'])) {
            $model->attributes = $_POST['ParentChild'];
            if (isset($model->user->firstname) && isset($model->user->lastname)) {
                $userNameString = $model->user->firstname . " " . $model->user->lastname;
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('app','Kind erfolgreich hinzugefügt.'));
                if (Yii::app()->user->checkAccess('1')) {
                    $this->redirect(array('admin'));
                } else {
                    $this->redirect(array('index'));
                }
            }
        }
        $this->render('create', array(
            'model' => $model,
            'userNameString' => $userNameString,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        if (!isset($_GET['ajax']) && Yii::app()->user->checkAccess('1')) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else {
            $this->redirect(array('index'));
        }
    }
    
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $tempParent = User::model()->findByPk($model->attributes['user_id']);
        $tempChild = Child::model()->findByPk($model->attributes['child_id']);
        $model->childFirstName = $tempChild->firstname;
        $model->childLastName = $tempChild->lastname;
        $userNameString = $tempParent->firstname." ".$tempParent->lastname;
        if (isset($_POST['ParentChild'])) {
            $this->setPostAttribute($model);
            $tempChild->firstname = $model->childFirstName;
            $tempChild->lastname = $model->childLastName;
            if ($model->save() && $tempChild->save()) {
                $this->redirect(array('admin', 'id' => $model->id));
            }
        }
        $this->render('update', array('model'=>$model,'userNameString'=>$userNameString));
        
    }
    
    
    private function setPostAttribute(&$model) {
        if (!Yii::app()->params['allowParentsToManageChilds'] && isset($_POST['ParentChild'])) {
            $model->childFirstName = $_POST['ParentChild']['childFirstName'];
            $model->childLastName = $_POST['ParentChild']['childLastName'];
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ParentChild('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ParentChild'])) {
            $model->attributes = $_GET['ParentChild'];
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Prüft ob das Kind zum User gehört.
     * @param integer $parentChildId
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return boolean
     */
    public function checkUser($parentChildId) {
        $rc = false;
        if (Yii::app()->user->checkAccess('1')) {
            $rc = true;
        } else if (ParentChild::model()->countByAttributes(array('user_id' => Yii::app()->user->getId(), 'child_id' => $parentChildId)) == 1) {
            $rc = true;
        }
        return $rc;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ParentChild the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ParentChild::model()->findByPk($id);
        if ($model === null)
            $this->throwFourNullFour();
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ParentChild $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'parent-child-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
