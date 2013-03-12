<?php
/* @var $this UserController */
/* @var $model NewPw */
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
<div><p>Sie können nun Ihr Passwort ändern.</p></div>
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
<div class="row buttons">
    <?php echo CHtml::submitButton('Absenden'); ?>
</div>


<?php $this->endWidget(); ?>