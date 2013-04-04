<?php
/**
 * Formular um Tans zu generieren
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
/* @var $this TanController */
/* @var $model tan */
                Yii::app()->clientScript->registerPackage('jquery');
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Tan Generierung</h2>
    </div>
</div>
<div class="row">
    <div class="eight columns centered">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'tan-form',
        //'enableAjaxValidation' => true,
        //'enableClientValidation'=>true,
        // 'clientOptions'=>array('validateOnSubmit'=>true),
        ));
?>
        <fieldset>
        <div class="row collapse">
            <div class="two columns">
                <span class="prefix">Anzahl TANs</span>
            </div>
            <div class="ten columns">
                <?php echo $form->textField($model, 'tan_count', array('size' => 60, 'maxlength' => 6,)); ?>
                <?php echo $form->error($model, 'tan_count'); ?>
            </div>
        </div>

    <?php echo CHtml::submitButton('Absenden', array('class' => 'small button')); ?>
        </fieldset>
<?php $this->endWidget(); ?>
    </div>
</div>