<?php
/**
 * Suche für Verwaltung
 */
/* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
/**
 * @var $this AppointmentController 
 * @var $model Appointment 
 * @var $form CActiveForm 
 */
?>
<div class="wide form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'errorMessageCssClass' => 'error',
        'skin' => false,
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id'); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'time'); ?>
        <?php echo $form->textField($model, 'time'); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'date_id'); ?>
        <?php echo $form->textField($model, 'date_id'); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'parent_child_id'); ?>
        <?php echo $form->textField($model, 'parent_child_id'); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'user_id'); ?>
        <?php echo $form->textField($model, 'user_id', array('size' => 11, 'maxlength' => 11)); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>