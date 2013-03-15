<?php
/* @var $this UserController */
/* @var $model ChangePwd */
?>

<div class="row">
    <div class="nine columns centered">
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
            <div class="row collapse">
                <div class="three columns">
                    <span class="prefix"><?php echo $form->label($model,'email'); ?></span>
                </div>
                <div class="nine columns mobile-input">
                    <?php echo $form->textField($model, 'email'); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>
            </div>
  
    <?php if (CCaptcha::checkRequirements()): ?>
            <div class="row">
                <div class="three columns"></div>
                <div class="nine columns">
                    <?php $this->widget('CCaptcha'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="three columns">
                    <span class="prefix"><?php echo $form->label($model,'verifyCode'); ?></span>
                </div>
                <div class="nine columns mobile-input">
                    <?php echo $form->textField($model, 'verifyCode'); ?>
                    <?php echo $form->error($model, 'verifyCode'); ?>
                    <div class="hint">&nbsp;Bitte geben Sie den im Bild angezeigten Sicherheitscode ein.</div>
                </div>
            </div>
<?php endif; ?>

    <?php echo CHtml::submitButton('Absenden', array('class' => 'small button')); ?>
        </fieldset>
<?php $this->endWidget(); ?>
        <div class="panel">
            <p class="medium">Das Zur&uuml;cksetzen eines Passwortes funktioniert nur, wenn Sie bereits im System registriert sind. Sollten Sie noch keinen Zugang besitzen registrieren Sie sich bitte zuerst im System.</p>
        </div>
        <p class="text-center"><?php echo CHtml::link('<b>Zurück zur Startseite</b>', 'index.php'); ?> </p>
    </div>
</div>
