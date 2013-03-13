<?php
/* @var $this ChildController */
/* @var $model Child */
/* @var $form CActiveForm */
?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'child-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Vorname</span>
            </div>
            <div class="ten columns">
                <?php echo $form->textField($model,'firstname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'firstname'); ?>
            </div>
	</div>

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Nachname</span>
            </div>
            <div class="ten columns">
		<?php echo $form->textField($model,'lastname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lastname'); ?>
            </div>
	</div>
        <br>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Anlegen' : 'Speichern', array('class' => 'small button')); ?>
	

<?php $this->endWidget(); ?>