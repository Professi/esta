<?php
/* @var $this UserController */
/* @var $model ChangePwd */
?>

<div class="row">

    <?php if (Yii::app()->user->hasFlash('failMsg')) { ?> 
        <div class='panel callout'>
            <?php echo Yii::app()->user->getFlash('failMsg'); ?></div>  
    <? } ?>
    <p>Sofern Sie ein neues Passwort anfordern möchten, können Sie folgendes Formular ausfüllen.</p>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'ChangePwd-form',
    ));
    ?>

    <?php echo $form->labelEx($model, 'email'); ?>
    <?php echo $form->textField($model, 'email'); ?>
    <?php echo $form->error($model, 'email'); ?>
    <?php if (CCaptcha::checkRequirements()): ?>
        <?php echo $form->labelEx($model, 'verifyCode'); ?>
        <div>
            <?php $this->widget('CCaptcha'); ?>
            <?php echo $form->textField($model, 'verifyCode'); ?>
        </div>
        <div class="hint">Bitte geben Sie den im Bild angezeigten Sicherheitscode ein.</div>
        <?php echo $form->error($model, 'verifyCode'); ?>
    </div>
<?php endif; ?>

<div class="row buttons">
    <?php echo CHtml::submitButton('Absenden'); ?>
</div>

<?php $this->endWidget(); ?>
