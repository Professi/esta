<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<div class="row">
	<div class="twelve columns ">
		<div class="panel">
			<h4> Liebe Eltern,</h4>
			<p> Willkommen auf der elektronischen Elternsprechtagsplattform der Brühlwiesenschule Hofheim.<br>
				Melden Sie sich an oder registrieren Sie sich um ihre Termine einzusehen oder neue Termine zu vereinbaren.
			</p>
		</div>
	</div>
</div>
 <?php if (Yii::app()->user->hasFlash('success')) { ?>

        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('success') . "Sie sollten nun eine Aktivierungsmail erhalten in der Sie ihren Account aktivieren können."; ?>
        </div>

    <?php } //else { ?>
<!-- <div class="panel callout"
<?//        echo Yii::app()->user->getFlash('failed');
   // } 
?> </div> -->

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

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
