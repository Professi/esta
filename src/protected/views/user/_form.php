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
<div class="row collapse">
    <div class="two columns">
        <span class="prefix"><?php echo $form->labelEx($model,'firstname'); ?></span>
    </div>
    <div class="ten columns">
        <?php echo $form->textField($model, 'firstname', array('size' => 45, 'maxlength' => 45)); ?>
        <?php echo $form->error($model, 'firstname'); ?>
    </div>
</div>


<div class="row collapse">
    <div class="two columns">
        <span class="prefix"><?php echo $form->labelEx($model,'lastname'); ?></span>
    </div>
    <div class="ten columns">
        <?php echo $form->textField($model, 'lastname', array('size' => 45, 'maxlength' => 45)); ?>
        <?php echo $form->error($model, 'lastname'); ?>
    </div>
</div>

        


<div class="row collapse">
    <div class="two columns">
        <span class="prefix"><?php echo $form->labelEx($model,'email'); ?></span>
    </div>
    <div class="ten columns">
    <?php if (Yii::app()->user->CheckAccess('1') || Yii::app()->user->isGuest) { ?>
    <?php
    echo $form->textField($model, 'email', array('size' => 45, 'maxlength' => 45));
} else {
    ?>
    <?php
    echo $form->textField($model, 'email', array('readonly' => true, 'class' => 'form-readonly'));
}?>
<?php echo $form->error($model, 'email'); ?>
    </div>
</div>


<div class="row collapse">
    <div class="two columns">
        <span class="prefix"><?php echo $form->labelEx($model,'password'); ?></span>
    </div>
    <div class="seven columns">
        <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>
    <div class="three columns">
        <span class="postfix" style="font-size:.8em;">Mindestlänge 8 Zeichen</span>
    </div>
</div>
<div class="show-for-small"><br></div>
<div class="row collapse">
    <div class="two columns">
        <span class="prefix"><?php echo $form->labelEx($model,'password_repeat'); ?></span>
    </div>
    <div class="ten columns">
        <?php echo $form->passwordField($model, 'password_repeat', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'password_repeat'); ?>
    </div>
</div>


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
<?php } if (Yii::app()->user->isGuest && CCaptcha::checkRequirements()) { ?>
<div class="row collapse">
    <div class="two columns">
        <span class="prefix"><?php echo $form->labelEx($model,'tan'); ?></span>
    </div>
    <div class="ten columns">
        <?php echo $form->textField($model, 'tan', array('size' => 45, 'maxlength' => Yii::app()->params['tanSize'])); ?>
        <?php echo $form->error($model, 'tan'); ?>
    </div>
</div>


<div class="row ">
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
        <?php echo $form->textField($model, 'verifyCode');?>
        <?php echo $form->error($model, 'verifyCode');?>
        <div class="hint">&nbsp;Bitte geben Sie den im Bild angezeigten Sicherheitscode ein.</div>
    </div>
</div>
    
<?php } ?>

<?php echo CHtml::submitButton($model->isNewRecord ? 'Registrieren' : 'Speichern', array('class' => 'button')); ?>

<?php $this->endWidget(); ?>
