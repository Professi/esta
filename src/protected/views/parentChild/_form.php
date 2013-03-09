<?php
/* @var $this ParentChildController */
/* @var $model ParentChild */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'parent-child-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); 
        if(Yii::app()->user->checkAccess(1)) {
        
        ?>
	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>
        <?} ?>
<!--	<div class="row">
		<?php echo $form->labelEx($model,'child_id'); ?>
		<?php echo $form->textField($model,'child_id'); ?>
		<?php echo $form->error($model,'child_id'); ?>
	</div>-->

            	<div class="row">
		<?php echo $form->labelEx($model,'childFirstName'); ?>
		<?php echo $form->textField($model,'childFirstName'); ?>
		<?php echo $form->error($model,'childFirstName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'childLastName'); ?>
		<?php echo $form->textField($model,'childLastName'); ?>
		<?php echo $form->error($model,'childLastName'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'class'); ?>
		<?php echo $form->textField($model,'class'); ?>
		<?php echo $form->error($model,'class'); ?>
	</div>
            
            <?
        
?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->