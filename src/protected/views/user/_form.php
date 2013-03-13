<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>



<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
        //'enableAjaxValidation' => true,
        //'enableClientValidation'=>true,
        // 'clientOptions'=>array('validateOnSubmit'=>true),
        ));
?>

<div class="row">
    <div class="six columns">
        <?php echo $form->textField($model, 'firstname', array('size' => 45, 'maxlength' => 45, 'placeholder' => 'Vorname')); ?>
        <?php echo $form->error($model, 'firstname'); ?>
    </div>

    <div class="six columns">
        <?php echo $form->textField($model, 'lastname', array('size' => 45, 'maxlength' => 45, 'placeholder' => 'Nachname')); ?>
        <?php echo $form->error($model, 'lastname'); ?>
    </div>
</div>

<?php if (Yii::app()->user->CheckAccess('1') || Yii::app()->user->isGuest) { ?>
    <?php
    echo $form->textField($model, 'email', array('size' => 45, 'maxlength' => 45, 'placeholder' => 'E-Mail'));
} else {
    ?>
    <?php
    echo $form->textField($model, 'email', array('readonly' => true));
}
?>
<?php echo $form->error($model, 'email'); ?>

<div class="row collapse">
    <div class="nine columns">
        <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 128, 'placeholder' => 'Passwort')); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>
    <div class="three columns">
        <span class="postfix" style="font-size:.8em;">Mindeslänge 8 Zeichen</span>
    </div>
</div>
<div class="show-for-small"><br></div>

<?php echo $form->passwordField($model, 'password_repeat', array('size' => 60, 'maxlength' => 128, 'placeholder' => 'Passwort bestätigen')); ?>
<?php echo $form->error($model, 'password_repeat'); ?>

<?php if (Yii::app()->user->checkAccess(1)) { ?>

    <?php echo $form->labelEx($model, 'state'); ?>
    <div class="styled-select">
        <?php echo $form->dropDownList($model, 'state', array('1' => 'Aktiv', '0' => 'Nicht aktiv', '2' => 'Gesperrt')); ?>
        <?php echo $form->error($model, 'state'); ?>
    </div>

    <?php echo $form->labelEx($model, 'role'); ?>
    <div class="styled-select">
        <?php
        if (Yii::app()->user->checkAccess(0)) {
            echo $form->dropDownList($model, 'role', array('0' => 'Administrator', '1' => 'Verwaltung', '2' => 'Lehrer', '3' => 'Eltern'));
        } else {
            echo $form->dropDownList($model, 'role', array('2' => 'Lehrer', '3' => 'Eltern'));
            ?>
            <?php echo $form->error($model, 'role'); ?>
            <?php echo $form->errorSummary($model);
        }
        ?>
    </div>
<?php } if (!Yii::app()->user->isAdmin() && CCaptcha::checkRequirements()) { ?>
        <?php echo $form->labelEx($model, 'verifyCode'); ?>
    <div>
        <?php $this->widget('CCaptcha'); ?>
    <?php echo $form->textField($model, 'verifyCode'); ?>
    </div>
    <div class="hint">Bitte geben Sie den im Bild angezeigten Sicherheitscode ein.</div>
    <?php
    echo $form->error($model, 'verifyCode');
}
?>

<?php echo CHtml::submitButton($model->isNewRecord ? 'Registrieren' : 'Speichern', array('class' => 'button')); ?>

<?php $this->endWidget(); ?>
