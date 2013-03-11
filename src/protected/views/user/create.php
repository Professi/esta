<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    'Create',
);
if (Yii::app()->user->checkAccess(1)) {
    $this->menu = array(
        array('label' => 'Benutzer verwalten', 'url' => array('admin')),
    );
    ?>


<? }echo $this->renderPartial('_form', array('model' => $model)); ?>