<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="row">
<div class="nine columns centered">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        //'enableAjaxValidation' => true,
        //'enableClientValidation'=>true,
       // 'clientOptions'=>array('validateOnSubmit'=>true),
    ));
    ?>
	
	<fieldset>
	<?php if (Yii::app()->user->isGuest) { ?>
	<legend>Registrierung</legend>
	<div class="panel">
		<p> Geben Sie ihre E-Mail-Adresse und ein Passwort ein um sich im System zu registrieren.<br> 
			Sie sollten innerhalb weniger Minuten eine E-Mail empfangen, die einen Link enthält mit dem Sie ihre Registrierung abschlie&szlig;en k&ouml;nnen.
		</p>
	</div>
	<?php } else { ?>
	<legend>Benutzerdaten</legend>
	<?php } ?>

	<div class="row">
		<div class="six columns">
			<?php echo $form->textField($model, 'firstname', array('size' => 45, 'maxlength' => 45,'placeholder' => 'Vorname')); ?>
			<?php echo $form->error($model, 'firstname'); ?>
		</div>
		
		<div class="six columns">
			<?php echo $form->textField($model, 'lastname', array('size' => 45, 'maxlength' => 45,'placeholder' => 'Nachname')); ?>
			<?php echo $form->error($model, 'lastname'); ?>
		</div>
	</div>

        <?php if (Yii::app()->user->CheckAccess('1') || Yii::app()->user->isGuest) { ?>
            <?php echo $form->textField($model, 'email', array('size' => 45, 'maxlength' => 45,'placeholder' => 'E-Mail'));
        } else {
            ?>
            <?php echo $form->textField($model, 'email', array('readonly' => true));
        }
        ?>
		<?php echo $form->error($model, 'email'); ?>

        <?php echo $form->hiddenField($model, 'oldPw'); ?>
		<div class="row collapse">
		<div class="nine columns">
		<?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 128,'placeholder' => 'Passwort')); ?>
		<?php echo $form->error($model, 'password'); ?>
		</div>
		<div class="three columns">
			<span class="postfix" style="font-size:.8em;">Mindeslänge 8 Zeichen</span>
		</div>
		</div>
		<div class="show-for-small"><br></div>

    <?php echo $form->passwordField($model, 'password_repeat', array('size' => 60, 'maxlength' => 128,'placeholder' => 'Passwort bestätigen')); ?>
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
                
                

            <?php echo $form->errorSummary($model); ?>
            <?php
        } ?>
                </div>
    <?php }
    ?>


    <?php echo CHtml::submitButton($model->isNewRecord ? 'Registrieren' : 'Speichern', array('class' => 'button')); ?>

	</fieldset>
<?php $this->endWidget(); ?>
</div>
</div><!-- form -->