<?php

/* @var $this UserController */
/* @var $model CsvUpload */
/* @var $form CActiveForm */
?>


<?php

$form=$this->beginWidget('CActiveForm', array( 'id'=>'csv-form', 'enableAjaxValidation'=>true, 'htmlOptions' => array('enctype' => 'multipart/form-data'), ));
?>

<?php echo $form->labelEx($model,'file'); ?> <?php echo $form->fileField($model,'file'); ?> <?php echo $form->error($model, 'file'); ?>



<?php echo CHtml::submitButton('Importieren', array('class' => 'button')); ?>

<?php $this->endWidget(); ?>

