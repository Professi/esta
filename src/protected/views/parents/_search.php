<?php
/* @var $this ParentsController */
/* @var $model Parents */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_parents'); ?>
		<?php echo $form->textField($model,'id_parents'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'parent1'); ?>
		<?php echo $form->textField($model,'parent1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'parent2'); ?>
		<?php echo $form->textField($model,'parent2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pw'); ?>
		<?php echo $form->textField($model,'pw'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->