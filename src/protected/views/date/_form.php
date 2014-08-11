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
                'dateFormat' => strtolower(Yii::app()->locale->getDateFormat('short')),
                'nextText' => '',
                'prevText' => '',
            ),
//            'language' => Yii::app()->params['language'],
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
        <span class="prefix infofeld">
            <?php echo $form->label($model, 'lockAt', array('class' => 'infolabel')); ?>
        </span>
        <div class="infotext">
            <span aria-hidden="true" data-icon="&#xe012;"></span>
            <?php echo Yii::t('app', 'In diesem Feld können Sie festlegen, bis wann Termine von Eltern reserviert werden können. Nach diesem Zeitpunkt können Eltern keine weiteren Termine mehr vereinbaren.'); ?>
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
                        'dateFormat' => strtolower(Yii::app()->locale->getDateFormat('short')),
                        'nextText' => '',
                        'prevText' => '',
                    ),
                    'language' => Yii::app()->params['language'],
                    'skin' => false,
                    'cssFile' => false,
                    'htmlOptions' => array(
                        'readonly' => 'readonly',
                    ),
                ));
                ?>
            </div>
            <div class="six columns" id="date-form-fix-right">
                <?php
                $this->widget(
                'ext.jui.EJuiDateTimePicker', array(
                'id' => "time_lockAt",
                'name' => "time_lockAt",
                'value' => $timeLabel,
                'mode' => 'time',
                // 'options' => $a_disabled
                ));
                ?>
            </div>
        </div>
        <?php
        echo $form->hiddenField($model, 'lockAt', array('id' => 'lockAt_value'));
        echo $form->error($model, 'lockAt');
        ?>
    </div>
    <div class="two columns">
        <span class="postfix">Datum + Uhrzeit</span>
    </div>
</div>
<div class="row collapse">
    <div class="two columns">
        <span class="prefix"><?php echo $form->label($model, 'begin'); ?></span>
    </div>
    <div class="eight columns">
        <?php
        $this->widget(
                'ext.jui.EJuiDateTimePicker', array(
            'model' => $model,
            'attribute' => 'begin',
            'mode' => 'time',
            'options' => $a_disabled
                )
        );


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
        $this->widget(
                'ext.jui.EJuiDateTimePicker', array(
            'model' => $model,
            'attribute' => 'end',
            'mode' => 'time',
            'options' => $a_disabled
                )
        );
        echo $form->error($model, 'end');
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
<div class="row collapse">
    <div class="two columns">
        <span class="prefix infofeld"><?php echo $form->label($model, 'title', array('class' => 'infolabel')); ?></span>
        <div class="infotext">
            <span aria-hidden="true" data-icon="&#xe012;"></span>
            <?php echo Yii::t('app', 'Vergeben Sie einen beliebigen Titel an diesen Elternsprechtag, um ihre interne Organisation zu erleichtern.'); ?>
            <?php echo Yii::t('app', 'Dieses Feld kann, wenn es nicht benötigt wird, leer gelassen werden.'); ?>
        </div>
    </div>
    <div class="ten columns">
        <?php
        echo $form->textField($model, 'title');
        echo $form->error($model, 'title');
        ?>
    </div>
</div>
<?php
if (Yii::app()->params['allowGroups']) {
    $groups = Group::model()->getAllGroups('DESC');
    if (!empty($groups)) {
        ?>
        <div class="row collapse">
            <div class="two columns">
                <span class="prefix"><?php echo $form->label($model, 'groups'); ?></span>
            </div>
            <div class="ten columns">
                <?php
                if (isset($_POST['Date']['groups'])) {
                    $model->groups = $_POST['Date']['groups'];
                }
                echo Select2::activeMultiSelect($model, 'groups', $groups, array(
                    'placeholder' => Yii::t('app', 'Hier können Sie mehrere Gruppen auswählen...'),
                    'id' => 'groups-select',
                    'select2Options' => array(
                        'allowClear' => true,
                    ),
                ));
                echo $form->error($model, 'groups');
                ?>
            </div>
        </div>
        <?php
    }
}
?>
<br>
<?php
echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Anlegen') : Yii::t('app', 'Speichern'), array('class' => 'small button'));
$this->endWidget();
?>

