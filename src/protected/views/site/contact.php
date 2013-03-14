<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - Kontakt';
$this->breadcrumbs = array(
    'contact',
);
?>

<div class="row">
    <div class="twelve columns">
        

<?php if (Yii::app()->user->hasFlash('contact')): ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('contact'); ?>
    </div>

<?php else: ?>
    <div class="alert-box secondary">
        
            Sollten Sie Fragen haben, füllen Sie bitte das nachfolgende Formular aus. Vielen Dank.
        
    </div>


        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'contact-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>
    <fieldset>
        <legend>Kontakt</legend>

            <?php echo $form->textField($model, 'name', array('placeholder' => 'Name')); ?>
            <?php echo $form->error($model, 'name'); ?>

            <?php echo $form->textField($model, 'email', array('placeholder' => 'E-Mail')); ?>
            <?php echo $form->error($model, 'email'); ?>

            <?php echo $form->textField($model, 'subject', array('size' => 60, 'maxlength' => 128, 'placeholder' => 'Betreff')); ?>
            <?php echo $form->error($model, 'subject'); ?>

            <?php echo $form->textArea($model, 'body', array('rows' => 6, 'cols' => 50, 'placeholder' => 'Ihre Nachricht')); ?>
            <?php echo $form->error($model, 'body'); ?>

        <?php if (CCaptcha::checkRequirements()): ?>
                <div>
                    <?php $this->widget('CCaptcha'); ?>
                    <?php echo $form->textField($model, 'verifyCode'); ?>
                </div>
                <?php echo $form->error($model, 'verifyCode'); ?>
                <div class="hint">Bitte geben Sie den im Bild angezeigten Sicherheitscode ein.</div>
                
        <?php endif; ?>

            <?php echo CHtml::submitButton('Absenden', array('class' => 'small button')); ?>
        
    </fieldset>

        <?php $this->endWidget(); ?>

    
    <p class="text-center"><?php echo CHtml::link('<b>Zurück zur Startseite</b>', 'index.php'); ?> </p>
    </div>
</div>
<?php endif; ?>
