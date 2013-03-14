<?php
/* @var $this UserController */
/* @var $model ChangePwd */
?>

<div class="row">

    <?php if (Yii::app()->user->hasFlash('failMsg')) { ?> 
        <div class='panel callout'>
            <?php echo Yii::app()->user->getFlash('failMsg'); ?></div>  
    <? } ?>
    <div class="eight columns centered">
        <h3>M&ouml;chten Sie ihr Passwort zur&uuml;cksetzen ?</h3>
        <div class="panel">
            <p>Geben Sie einfach ihre E-Mail-Adresse ein. Ihnen wird ein tempor&auml;res Passwort zugesandt 
                mit dem Sie sich einloggen können.</p>
        </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'ChangePwd-form',
    ));
    ?>                
           
        <fieldset>
    <?php echo $form->textField($model, 'email', array('placeholder' => 'E-Mail')); ?>
    <?php echo $form->error($model, 'email'); ?>
    <?php if (CCaptcha::checkRequirements()): ?>
        <div>
            <?php $this->widget('CCaptcha'); ?>
            <?php echo $form->textField($model, 'verifyCode', array('placeholder' => 'Sicherheitscode')); ?>
            <?php echo $form->error($model, 'verifyCode'); ?>
        </div>
        <div class="hint">Bitte geben Sie den im Bild angezeigten Sicherheitscode ein.</div>
            
<?php endif; ?>

    <?php echo CHtml::submitButton('Absenden', array('class' => 'small button')); ?>
        </fieldset>
<?php $this->endWidget(); ?>
        <div class="panel">
            <p class="medium">Das Zur&uuml;cksetzen eines Passwortes funktioniert nur, wenn Sie bereits im System registriert sind. Sollten Sie noch keinen Zugang besitzen registrieren Sie sich bitte zuerst im System.</p>
        </div>
    </div>
</div>
