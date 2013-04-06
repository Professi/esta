<?php
/**
 * Date _form
 */
/* Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
/* @var $this DateController */
/* @var $model Date */
/* @var $form CActiveForm */
?>



<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'date-form',
    'enableAjaxValidation' => false,
        ));
?>

<div class="row collapse">
    <div class="two columns">
        <span class="prefix"><?php echo $form->label($model, 'date'); ?></span>
    </div>
    <div class="eight columns">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'date',
            'options' => array(
                'showAnim' => 'fold',
                'minDate' => '0',
//                            'dateFormat' => Yii::app()->params['dateFormat'],
                            'nextText' => '',
                            'prevText' => '',
                        ),
                        'language' => 'de',
                        'skin' => false,
                        'cssFile' => false,
                        'htmlOptions'=>array(
                            'readonly' => 'readonly',
                        ),
        ));
        ?>
<?php echo $form->error($model, 'date'); ?>
    </div>
    <div class="two columns">
        <span class="postfix">TT.MM.JJJJ<?php //echo Yii::app()->params['dateFormat']  ?></span>
    </div>
</div>

<div class="row collapse">
    <div class="two columns">
        <span class="prefix"><?php echo $form->label($model, 'begin'); ?></span>
    </div>
    <div class="eight columns">
        <?php echo $form->textField($model, 'begin'); ?>
<?php echo $form->error($model, 'begin'); ?>
    </div>
    <div class="two columns">
        <span class="postfix">HH:MM</span>
    </div>
</div>

<div class="row collapse">
    <div class="two columns">
        <span class="prefix"><?php echo $form->label($model, 'end'); ?></span>
    </div>
    <div class="eight columns">
        <?php echo $form->textField($model, 'end'); ?>
<?php echo $form->error($model, 'end'); ?>
    </div>
    <div class="two columns">
        <span class="postfix">HH:MM</span>
    </div>
</div>
<div class="row collapse">
    <div class="two columns">
        <span class="prefix"><?php echo $form->label($model, 'lockAt'); ?></span>
    </div>
    <div class="eight columns">
        <?php echo $form->textField($model, 'lockAt'); ?>
<?php echo $form->error($model, 'lockAt'); ?>
    </div>
    <div class="two columns">
        <span class="postfix">HH:MM</span>
    </div>
</div>

<?php if ($model->isNewRecord) { ?>
    <div class="row collapse">
        <div class="two columns">
            <span class="prefix"><?php echo $form->label($model, 'durationPerAppointment'); ?></span>
        </div>
        <div class="eight columns">
            <?php echo $form->textField($model, 'durationPerAppointment'); ?>
    <?php echo $form->error($model, 'durationPerAppointment'); ?>
        </div>
        <div class="two columns">
            <span class="postfix">MM</span>
        </div>
    </div>
<?php } ?>
<br>
<?php echo CHtml::submitButton($model->isNewRecord ? 'Anlegen' : 'Speichern', array('class' => 'small button')); ?>
<?php $this->endWidget(); ?>

