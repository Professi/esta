<?php
/* @var $this ParentChildController */
/* @var $model ParentChild */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'parent-child-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php
echo $form->errorSummary($model);
if (Yii::app()->user->checkAccess(1)) {
    ?>
    <div class="row collapse">
        <div class="two columns">
            <span class="prefix">Benutzer-ID</span>
        </div>
        <div class="ten columns">
    <?php echo $form->textField($model, 'user_id', array('size' => 11, 'maxlength' => 11)); ?>
    <?php echo $form->error($model, 'user_id'); ?>
        </div>
    </div>
<? } ?>
<div class="row collapse">
    <div class="two columns">
        <span class="prefix">Vorname</span>
    </div>
    <div class="ten columns mobile-input">
<?php echo $form->textField($model, 'childFirstName'); ?>
<?php echo $form->error($model, 'childFirstName'); ?>
    </div>
</div>

<div class="row collapse">
    <div class="two columns">
        <span class="prefix">Nachname</span>
    </div>
    <div class="ten columns mobile-input">
<?php echo $form->textField($model, 'childLastName'); ?>
<?php echo $form->error($model, 'childLastName'); ?>
    </div>
</div>            
<br>
<?php echo CHtml::submitButton($model->isNewRecord ? 'Anlegen' : 'Speichern', array('class' => 'small button')); ?>

<?php $this->endWidget(); ?>
