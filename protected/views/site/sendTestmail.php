<?php
/**
 * Testmail versenden
 */
/* * Copyright (C) 2014  Christian Ehringfeld, David Mock
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
 * @var $this SiteController
 * @var $model ContactForm
 * @var $form CActiveForm
 */
$this->setPageTitle(Yii::t('app', 'Kontakt'));
$this->breadcrumbs = array(
    'contact',
);
?>
<div class="row">
    <div class="small-12 columns">
        <?php if (Yii::app()->user->hasFlash('contact')): ?>
            <div class="flash-success">
                <?php echo Yii::app()->user->getFlash('contact'); ?>
            </div>
        <?php else: ?>
            <div class="paper panel">
                <?php echo Yii::t('app', 'Sie können mit diesem Formular eine Testmail versenden.');?><br>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'contact-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'errorMessageCssClass' => 'error',
                'skin' => false,
            ));
            ?>
            <fieldset>
                <legend><?php echo Yii::t('app', 'Kontakt');?></legend>
                <div class="row collapse">
                    <div class="small-2 columns">
                        <span class="prefix"><?php echo $form->label($model, 'recipient'); ?></span>
                    </div>
                    <div class="small-10 columns mobile-input">
                        <?php
                        echo $form->textField($model, 'recipient');
                        echo $form->error($model, 'recipient');
                        ?>
                    </div>
                </div>
                    <?php
                echo CHtml::submitButton(Yii::t('app', 'Absenden'), array('class' => 'small button'));
                ?>
            </fieldset>
            <?php $this->endWidget(); ?>
        <p class="text-center"><?php echo CHtml::link('<b>' . Yii::t('app', 'Zurück zur Startseite') . '</b>', 'index.php'); ?> </p>
        </div>
    </div>
<?php endif; ?>
