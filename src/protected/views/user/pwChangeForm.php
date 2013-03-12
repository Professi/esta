<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
        //'enableAjaxValidation' => true,
        //'enableClientValidation'=>true,
        // 'clientOptions'=>array('validateOnSubmit'=>true),
        ));
?>


<?php if (Yii::app()->user->isGuest) { ?>
    <?php echo $form->textField($model, 'email', array('size' => 45, 'maxlength' => 45, 'placeholder' => 'E-Mail'));
}
?>
<?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 128, 'placeholder' => 'Passwort')); ?>
<?php echo $form->error($model, 'password'); ?>
</div>
<div class="three columns">
    <span class="postfix" style="font-size:.8em;">Mindeslänge 8 Zeichen</span>
</div>
</div>
<div class="show-for-small"><br></div>

<?php echo $form->passwordField($model, 'password_repeat', array('size' => 60, 'maxlength' => 128, 'placeholder' => 'Passwort bestätigen')); ?>
<?php echo $form->error($model, 'password_repeat'); ?>
