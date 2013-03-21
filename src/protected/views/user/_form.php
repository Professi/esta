<?php
/**
 * User Form
 */
/**Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>



<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
        ));
?>
<div class="row collapse">
    <div class="three columns">
        <span class="prefix"><?php echo $form->label($model,'firstname'); ?></span>
    </div>
    <div class="nine columns mobile-input">
        <?php echo $form->textField($model, 'firstname', array('size' => 45, 'maxlength' => 45)); ?>
        <?php echo $form->error($model, 'firstname'); ?>
    </div>
</div>


<div class="row collapse">
    <div class="three columns">
        <span class="prefix"><?php echo $form->label($model,'lastname'); ?></span>
    </div>
    <div class="nine columns mobile-input">
        <?php echo $form->textField($model, 'lastname', array('size' => 45, 'maxlength' => 45)); ?>
        <?php echo $form->error($model, 'lastname'); ?>
    </div>
</div>

        


<div class="row collapse">
    <div class="three columns">
        <span class="prefix"><?php echo $form->label($model,'email'); ?></span>
    </div>
    <div class="nine columns mobile-input">
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
    <div class="three columns">
        <span class="prefix"><?php echo $form->label($model,'password'); ?></span>
    </div>
    <div class="six columns mobile-input">
        <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>
    <div class="three columns mobile-input">
        <span class="postfix" style="font-size:.8em;">Mindestlänge 8 Zeichen</span>
    </div>
</div>
<div class="show-for-small"><br></div>
<div class="row collapse">
    <div class="three columns">
        <span class="prefix"><?php echo $form->label($model,'password_repeat'); ?></span>
    </div>
    <div class="nine columns mobile-input">
        <?php echo $form->passwordField($model, 'password_repeat', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'password_repeat'); ?>
    </div>
</div>


<?php if (Yii::app()->user->checkAccess('1')) { ?>

    <?php echo $form->label($model, 'state'); ?>
    <div class="styled-select">
        <?php echo $form->dropDownList($model, 'state', array('1' => 'Aktiv', '0' => 'Nicht aktiv', '2' => 'Gesperrt')); ?>
        <?php echo $form->error($model, 'state'); ?>
    </div>

    <?php echo $form->label($model, 'role'); ?>
    <div class="styled-select">
        <?php
        if (Yii::app()->user->checkAccess('0')) {
            echo $form->dropDownList($model, 'role', array('0' => 'Administrator', '1' => 'Verwaltung', '2' => 'Lehrer', '3' => 'Eltern'));
        } else {
            echo $form->dropDownList($model, 'role', array('1' =>'Verwaltung', '2' => 'Lehrer', '3' => 'Eltern'));
            ?>
            <?php echo $form->error($model, 'role'); ?>
            
        }
        ?>
    </div>
<?php } if (Yii::app()->user->isGuest && CCaptcha::checkRequirements()) { ?>
<div class="row collapse">
    <div class="three columns">
        <span class="prefix"><?php echo $form->label($model,'tan'); ?></span>
    </div>
    <div class="nine columns mobile-input">
        <?php echo $form->textField($model, 'tan', array('size' => 45, 'maxlength' => Yii::app()->params['tanSize'])); ?>
        <?php echo $form->error($model, 'tan'); ?>
    </div>
</div>


<div class="row ">
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
        <?php echo $form->textField($model, 'verifyCode');?>
        <?php echo $form->error($model, 'verifyCode');?>
        <div class="hint">&nbsp;Bitte geben Sie den im Bild angezeigten Sicherheitscode ein.</div>
    </div>
</div>
    
<?php } ?>

<?php echo CHtml::submitButton($model->isNewRecord ? 'Registrieren' : 'Speichern', array('class' => 'button')); ?>

<?php $this->endWidget(); ?>
