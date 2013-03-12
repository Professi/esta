<?php
/* @var $this UserController */
/* @var $model ChangePwd */
?>

<?php if (Yii::app()->user->isGuest) { //  && !isset($_POST['email'])?>
    <div><p>Wollen Sie wirklich ihr Passwort ändern. Bitte EMail adresse angeben.</p></div>    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'ChangePwd-form',
//            'enableClientValidation' => true,
//            'clientOptions' => array(
//                'validateOnSubmit' => true,
//            ),
        ));
        ?>
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email'); ?>
        <?php echo $form->error($model, 'email'); ?>
        <?php if (CCaptcha::checkRequirements()): ?>
            <div class="row">
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
        <?php
    } else {
        if (Yii::app()->user->hasFlash('success')) {
            ?>  <div><p><?php echo Yii::app()->user->getFlash('success'); ?></p></div><?php
        } else {
            if (Yii::app()->user->hasFlash) {
                ?> <div><p><?php echo Yii::app()->user->getFlash('failMsg'); ?></p></div>  
                //<?
            }
        }
    }
    ?>