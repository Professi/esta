<?php
/* @var $this TanController */
/* @var $model tan */
?>

<div class="row">
    <div class="eight columns centered">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'tan-form',
        //'enableAjaxValidation' => true,
        //'enableClientValidation'=>true,
        // 'clientOptions'=>array('validateOnSubmit'=>true),
        ));
?>
        <fieldset>
        <div class="row collapse">
            <div class="two columns">
                <span class="prefix">Anzahl TANs</span>
            </div>
            <div class="ten columns">
                <?php echo $form->textField($model, 'tan_count', array('size' => 60, 'maxlength' => 6,)); ?>
                <?php echo $form->error($model, 'tan_count'); ?>
            </div>
        </div>

    <?php echo CHtml::submitButton('Absenden', array('class' => 'small button')); ?>
        </fieldset>
<?php $this->endWidget(); ?>
    </div>
</div>