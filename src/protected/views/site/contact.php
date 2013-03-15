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
        
            Sollten Sie Fragen oder Anregungen haben, setzen Sie sich mit uns in Kontakt indem Sie das nachfolgende Formular ausfüllen. Vielen Dank.
        
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
        
        <div class="row collapse">
            <div class="two columns">
                <span class="prefix"><?php echo $form->labelEx($model,'name'); ?></span>
            </div>
            <div class="ten columns">
                <?php echo $form->textField($model, 'name'); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="row collapse">
            <div class="two columns">
                <span class="prefix"><?php echo $form->labelEx($model,'email'); ?></span>
            </div>
            <div class="ten columns">
                <?php echo $form->textField($model, 'email'); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>
        <div class="row collapse">
            <div class="two columns">
                <span class="prefix"><?php echo $form->labelEx($model,'subject'); ?></span>
            </div>
            <div class="ten columns">
                <?php echo $form->textField($model, 'subject', array('size' => 60, 'maxlength' => 128)); ?>
                <?php echo $form->error($model, 'subject'); ?>
            </div>
        </div>

               <div class="row collapse">
            <div class="twelve columns" style="padding-left:.2em;">
                <?php // $model->body = 'Ihre Nachricht'; ?>
                <?php echo $form->textArea($model, 'body', array('rows' => 6, 'cols' => 50, 'placeholder' => 'Ihre Nachricht')); ?>
                
                <?php echo $form->error($model, 'body'); ?>
            </div>
        </div>
        

        <?php if (CCaptcha::checkRequirements()): ?>
        <div class="row">
            <div class="two columns"></div>
            <div class="ten columns">
                <?php $this->widget('CCaptcha'); ?>
            </div>
        </div>
                <div class="row collapse">
                    <div class="two columns">
                        <span class="prefix"><?php echo $form->labelEx($model,'verifyCode'); ?></span>
                    </div>
                    <div class="ten columns">
                        <?php echo $form->textField($model, 'verifyCode'); ?>
                        <?php echo $form->error($model, 'verifyCode'); ?>
                        <div class="hint">&nbsp;Bitte geben Sie den im Bild angezeigten Sicherheitscode ein.</div>
                    </div>
                </div>
                
                
                
        <?php endif; ?>

            <?php echo CHtml::submitButton('Absenden', array('class' => 'small button')); ?>
        
    </fieldset>

        <?php $this->endWidget(); ?>

    
    <p class="text-center"><?php echo CHtml::link('<b>Zurück zur Startseite</b>', 'index.php'); ?> </p>
    </div>
</div>
<?php endif; ?>
