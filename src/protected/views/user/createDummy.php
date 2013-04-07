<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
        ));
?>
<div class="row collapse">
    <div class="three columns">
        <span class="prefix"><?php echo $form->label($model,'firstname'); ?></span>
    </div>
    <div class="nine columns mobile-input">
        <?php echo $form->textField($model, 'firstname', array('size' => 45, 'maxlength' => 45)); ?>
        <?php echo $form->error($model, 'firstname'); ?>
    </div>
</div>


<div class="row collapse">
    <div class="three columns">
        <span class="prefix"><?php echo $form->label($model,'lastname'); ?></span>
    </div>
    <div class="nine columns mobile-input">
        <?php echo $form->textField($model, 'lastname', array('size' => 45, 'maxlength' => 45)); ?>
        <?php echo $form->error($model, 'lastname'); ?>
    </div>
</div>

<?php echo CHtml::submitButton('Speichern', array('class' => 'button')); ?>

<?php $this->endWidget(); ?>
