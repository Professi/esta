<?php

/* @var $this UserController */
/* @var $model CsvUpload */
/* @var $form CActiveForm */
?>


<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'csv-form',
        //'enableAjaxValidation' => true,
        //'enableClientValidation'=>true,
        // 'clientOptions'=>array('validateOnSubmit'=>true),
        ));
?>

<?php echo $form->labelEx($model, 'email'); ?>
<?php echo $form->textField($model, 'email'); ?>
<?php echo $form->error($model, 'email'); ?>



<?php echo CHtml::submitButton($model->isNewRecord ? 'Registrieren' : 'Speichern', array('class' => 'button')); ?>

<?php $this->endWidget(); ?>

