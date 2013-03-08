<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Felder mit <span class="required">*</span> werden benötigt.</p>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 45, 'maxlength' => 45)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'firstname'); ?>
        <?php echo $form->textField($model, 'firstname', array('size' => 45, 'maxlength' => 45)); ?>
        <?php echo $form->error($model, 'firstname'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'lastname'); ?>
        <?php echo $form->textField($model, 'lastname', array('size' => 45, 'maxlength' => 45)); ?>
        <?php echo $form->error($model, 'lastname'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password_repeat'); ?>
        <?php echo $form->passwordField($model, 'password_repeat', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'password_repeat'); ?>
    </div>
    <?php if (!Yii::app()->user->isGuest) { ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'state'); ?>
            <?php echo $form->dropDownList($model, 'state', array('1' => 'Aktiv', '0' => 'Nicht aktiv', '2' => 'Gesperrt')); ?>
            <?php echo $form->error($model, 'state'); ?>
        </div>

        <?php echo $form->errorSummary($model); ?>
    <?php } ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Erstellen' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->