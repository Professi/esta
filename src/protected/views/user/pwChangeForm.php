<?php
/* @var $this UserController */
/* @var $model NewPw */
/* @var $form CActiveForm */
?>
<div class="row">
    <div class="eight columns centered">
        <div class="alert-box secondary">
            Sie können nun Ihr Passwort ändern.
        </div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
        //'enableAjaxValidation' => true,
        //'enableClientValidation'=>true,
        // 'clientOptions'=>array('validateOnSubmit'=>true),
        ));
?>
        <fieldset>
<div class="row collapse">
    <div class="nine columns">
        <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 128, 'placeholder' => 'Passwort')); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>
    <div class="three columns">
        <span class="postfix" style="font-size:.8em;">Mindeslänge 8 Zeichen</span>
    </div>
</div>

<div class="row collapse">
    <?php echo $form->passwordField($model, 'password_repeat', array('size' => 60, 'maxlength' => 128, 'placeholder' => 'Passwort bestätigen')); ?>
    <?php echo $form->error($model, 'password_repeat'); ?>
</div>

    <?php echo CHtml::submitButton('Absenden', array('class' => 'small button')); ?>
        </fieldset>
<?php $this->endWidget(); ?>
    </div>
</div>