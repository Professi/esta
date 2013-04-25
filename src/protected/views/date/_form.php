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
    <div class="ten columns">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'date',
            'options' => array(
                'showAnim' => 'fold',
                'minDate' => '0',
                'dateFormat' => $this->dateStringToDatepickerFormat(Yii::app()->params['dateFormat']),
                'nextText' => '',
                'prevText' => '',
            ),
            'language' => 'de',
            'skin' => false,
            'cssFile' => false,
            'htmlOptions' => array(
                'readonly' => 'readonly',
            ),
        ));
        echo $form->error($model, 'date');
        ?>
    </div>
</div>
<div class="row collapse">
    <div class="two columns">
        <span class="prefix"><?php echo $form->label($model, 'begin'); ?></span>
    </div>
    <div class="eight columns">
        <?php
        echo $form->textField($model, 'begin', $a_disabled);
        echo $form->error($model, 'begin');
        ?>
    </div>
    <div class="two columns">
        <span class="postfix">Uhrzeit</span>
    </div>
</div>
<div class="row collapse">
    <div class="two columns">
        <span class="prefix"><?php echo $form->label($model, 'end'); ?></span>
    </div>
    <div class="eight columns">
        <?php
        echo $form->textField($model, 'end', $a_disabled);
        echo $form->error($model, 'end');
        ?>
    </div>
    <div class="two columns">
        <span class="postfix">Uhrzeit</span>
    </div>
</div>
<div class="row collapse">
    <div class="two columns">
        <span class="prefix infofeld">
            <?php echo $form->label($model, 'lockAt', array('class' => 'infolabel')); ?>
        </span>
        <div class="infotext">
            <span aria-hidden="true" data-icon="&#xe012;"></span>
            In diesem Feld können Sie festlegen, bis wann Termine reserviert werden können. Nach diesem Zeitpunkt können Eltern keine Termine mehr vereinbaren.
        </div>
    </div>
    <div class="eight columns">
        <div class="row">
            <div class="six columns" id="date-form-fix-left">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'name' => 'lockAt',
                    'id' => 'date_lockAt',
                    'value' => $dateLabel,
                    'options' => array(
                        'showAnim' => 'fold',
                        'minDate' => '0',
                        'dateFormat' => $this->dateStringToDatepickerFormat(Yii::app()->params['dateFormat']),
                        'nextText' => '',
                        'prevText' => '',
                    ),
                    'language' => 'de',
                    'skin' => false,
                    'cssFile' => false,
                    'htmlOptions' => array(
                        'readonly' => 'readonly',
                    ),
                ));
                ?>
            </div>
            <div class="six columns" id="date-form-fix-right">
                <input type="text" id="time_lockAt" value="<?php echo $timeLabel; ?>">
            </div>
        </div>
        <?php
        echo $form->hiddenField($model, 'lockAt', array('id' => 'lockAt_value'));
        echo $form->error($model, 'lockAt');
        ?>
    </div>
    <div class="two columns">
        <span class="postfix">Uhrzeit</span>
    </div>
</div>
<div class="row collapse">
    <div class="two columns">
        <span class="prefix"><?php echo $form->label($model, 'durationPerAppointment'); ?></span>
    </div>
    <div class="eight columns">
        <?php
        echo $form->textField($model, 'durationPerAppointment', $a_disabled);
        echo $form->error($model, 'durationPerAppointment');
        ?>
    </div>
    <div class="two columns">
        <span class="postfix">in Minuten</span>
    </div>
</div>
<br>
<?php
echo CHtml::submitButton($model->isNewRecord ? 'Anlegen' : 'Speichern', array('class' => 'small button'));
$this->endWidget();
?>

