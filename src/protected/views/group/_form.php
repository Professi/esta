<?php
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
 * @var $this GroupController 
 * @var $model Group 
 */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'date-form',
    'enableAjaxValidation' => false,
    'errorMessageCssClass' => 'error',
    'skin' => false,
        ));
?>
<div class="row collapse">
    <div class="small-3 columns">
        <span class="prefix"><?php echo $form->label($model, 'groupname'); ?></span>
    </div>
    <div class="small-9 columns mobile-input">
        <?php
        echo $form->textField($model, 'groupname', array('size' => 10, 'maxlength' => 255));
        echo $form->error($model, 'groupname');
        ?>
    </div>
</div>

<?php
echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Anlegen') : Yii::t('app','Speichern'), array('class' => 'small button'));
$this->endWidget();
?>
