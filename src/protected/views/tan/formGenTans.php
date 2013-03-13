<?php
/* @var $this TanController */
/* @var $model tan */
?>


<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'tan-form',
        //'enableAjaxValidation' => true,
        //'enableClientValidation'=>true,
        // 'clientOptions'=>array('validateOnSubmit'=>true),
        ));
?>
<div><p>Wie viele Tans benötigen Sie?</p></div>
<?php echo $form->textField($model, 'tan_count', array('size' => 60, 'maxlength' => 6,)); ?>
<?php echo $form->error($model, 'tan_count'); ?>
<div class="row buttons">
    <?php echo CHtml::submitButton('Absenden'); ?>
</div>


<?php $this->endWidget(); ?>
