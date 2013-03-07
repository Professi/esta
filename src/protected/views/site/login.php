<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>ESTA der BWS-Hofheim</h1>

<p>Willkommen zur Elternsprechtagsanwendung der Brühlwiesenschule in Hofheim. Bitte melden Sie sich an.</p>

 <?php if (Yii::app()->user->hasFlash('success')) { ?>

        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('success') . "Sie sollten nun eine Aktivierungsmail erhalten in der Sie ihren Account aktivieren können."; ?>
        </div>

    <?php } ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Felder mit <span class="required">*</span> werden benötigt.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
            <p>Oder wollen Sie sich <?php echo CHtml::link('registrieren?','index.php?r=user/create'); ?> </p>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
