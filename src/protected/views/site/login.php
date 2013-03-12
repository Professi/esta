<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
?>

<div class="row">
    <div class="twelve columns ">
        <div class="panel">
            <h4> Liebe Eltern,</h4>
            <p> Willkommen auf der elektronischen Elternsprechtagsplattform der Brühlwiesenschule Hofheim.<br>
                Melden Sie sich an oder registrieren Sie sich um ihre Termine einzusehen oder neue Termine zu vereinbaren.
            </p>
        </div>
    </div>
</div>
<?php if (Yii::app()->user->hasFlash('success')) { ?>
<div class="row">
    <div class="twelve columns">
        <div class="alert-box success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    </div>
</div>
    <?php
}
if ($model->getError('error') !== NULL) {
    ?>
	<div class="row">
            <div class="twelve columns centered">
                <div class="alert-box alert">
        <? echo $model->getError('error');
        ?> </div> 
            </div>
	</div> <? } ?>
<div class="row">
    <div class="six columns centered">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableClientValidation' => false,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>

        <fieldset>
            <legend>Login</legend>

            <?php echo $form->textField($model, 'email', array('placeholder' => 'E-Mail')); ?>
            <?php echo $form->error($model, 'email'); ?>

            <?php echo $form->passwordField($model, 'password', array('placeholder' => 'Passwort')); ?>
            <?php echo $form->error($model, 'password'); ?>

            <?php echo $form->checkBox($model, 'rememberMe'); ?>
            Anmeldedaten merken<br><br>
            <?php echo $form->error($model, 'rememberMe'); ?>

            <?php echo CHtml::submitButton('Login', array('class' => 'button')); ?>
            <?php echo CHtml::link('Passwort vergessen?', 'index.php?r=user/ChangePwd', array('class'=>'medium right')); ?>
        </fieldset>
        <p class="text-center"><?php echo CHtml::link('<b>Ben&ouml;tigen Sie einen neuen Zugang?<br>Klicken Sie hier.</b>', 'index.php?r=user/create'); ?> </p>

        <?php $this->endWidget(); ?>
    </div>
</div>
