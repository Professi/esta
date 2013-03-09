<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    'Create',
);
if (!Yii::app()->user->isGuest) {
    $this->menu = array(
        array('label' => 'Manage User', 'url' => array('admin')),
    );
    ?>

    <h1>Erstelle Benutzer</h1>
<? } else { ?>
    <h1>Registrierung</h1>


<? }echo $this->renderPartial('_form', array('model' => $model)); ?>