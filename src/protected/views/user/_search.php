<?php
/**
 * Suchfelder Benutzerverwaltung
 */
/* * Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
<div class="wide form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <div class="row">
        <?php
        echo $form->label($model, 'id');
        echo $form->textField($model, 'id', array('size' => 11, 'maxlength' => 11));
        ?>
    </div>
    <div class="row">
        <?php
        echo $form->label($model, 'username');
        echo $form->textField($model, 'username', array('size' => 45, 'maxlength' => 45));
        ?>
    </div>
    <div class="row">
        <?php
        echo $form->label($model, 'activationKey');
        echo $form->textField($model, 'activationKey', array('size' => 60, 'maxlength' => 128));
        ?>
    </div>
    <div class="row">
        <?php
        echo $form->label($model, 'createtime');
        echo $form->textField($model, 'createtime');
        ?>
    </div>
    <div class="row">
        <?php
        echo $form->label($model, 'firstname');
        echo $form->textField($model, 'firstname', array('size' => 45, 'maxlength' => 45));
        ?>
    </div>
    <div class="row">
        <?php
        echo $form->label($model, 'state');
        echo $form->textField($model, 'state');
        ?>
    </div>
    <div class="row">
        <?php
        echo $form->label($model, 'lastname');
        echo $form->textField($model, 'lastname', array('size' => 45, 'maxlength' => 45));
        ?>
    </div>
    <div class="row">
        <?php
        echo $form->label($model, 'email');
        echo $form->textField($model, 'email', array('size' => 45, 'maxlength' => 45));
        ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->