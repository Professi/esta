<?php
/* @var $this RoomController */
/* @var $model Room */
/* @var $form CActiveForm */
?>


<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'room-form',
    'enableAjaxValidation'=>false,
        'enableAjaxValidation' => false,
        'errorMessageCssClass' => 'error',
        'skin' => false,
)); ?>
    
<div class="row collapse">
    <div class="small-2 columns">
        <span class="prefix"><?php echo $form->label($model, 'name'); ?></span>
    </div>
    <div class="small-10 columns">
        <?php
        echo $form->textField($model, 'name');
        echo $form->error($model, 'name');
        ?>
    </div>
</div>
<?php
echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Anlegen') : Yii::t('app', 'Speichern'), array('class' => 'small button'));
$this->endWidget(); ?>
