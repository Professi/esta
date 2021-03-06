<?php
/**
 * Pseudobenutzer erstellen
 */
/* * Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
 * @var $this UserController
 * @var $model User
 */
$this->setPageTitle('Pseudobenutzer anlegen');

if (Yii::app()->user->checkAccess(MANAGEMENT)) {
    $this->menu = array(
        array(  'label' => Yii::t('app', 'Benutzer verwalten'),
                'url' => array('admin'),
                'linkOptions' => array('class' => 'small button')),
    );
}

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'errorMessageCssClass' => 'error',
    'skin' => false,
        ));
?>
<div class="push"></div>
<div class="row">
    <div class="small-12 columns">
        <fieldset>
            <legend><?php echo Yii::t('app', 'Pseudobenutzer anlegen'); ?></legend>
            <div class="row collapse">
                <div class="small-3 columns">
                    <span class="prefix"><?php echo $form->label($model, 'firstname'); ?></span>
                </div>
                <div class="small-9 columns mobile-input">
                    <?php
                    echo $form->textField($model, 'firstname', array('size' => 45, 'maxlength' => 45));
                    echo $form->error($model, 'firstname');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-3 columns">
                    <span class="prefix"><?php echo $form->label($model, 'lastname'); ?></span>
                </div>
                <div class="small-9 columns mobile-input">
                    <?php
                    echo $form->textField($model, 'lastname', array('size' => 45, 'maxlength' => 45));
                    echo $form->error($model, 'lastname');
                    ?>
                </div>
            </div>
            <?php echo CHtml::submitButton(Yii::t('app', 'Erstellen'), array('class' => 'small button')); ?>
        </fieldset>
    </div>
</div>
<?php $this->endWidget(); ?>
