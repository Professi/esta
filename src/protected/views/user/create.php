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
}?>
<div class="row">
    <div class="nine columns centered">
        <fieldset>
            <?php if (Yii::app()->user->isGuest) { ?>
            <legend>Registrierung</legend>
            <div class="panel">
		<p> Geben Sie ihre E-Mail-Adresse und ein Passwort ein um sich im System zu registrieren.<br> 
			Sie sollten innerhalb weniger Minuten eine E-Mail empfangen, die einen Link enthält mit dem Sie ihre Registrierung abschlie&szlig;en k&ouml;nnen.
		</p>
            </div>
            <?php } else { ?>
            <legend>Benutzer anlegen</legend>
            <?php } ?>
<? echo $this->renderPartial('_form', array('model' => $model)); ?>
        </fieldset>
    </div>
</div>