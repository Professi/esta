<?php
/**
 * Kontaktseite
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
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */
$this->setPageTitle(Yii::t('app', 'Kontakt'));
$this->breadcrumbs = array(
    'contact',
);
?>
<div class="row">
    <div class="twelve columns">
        <?php if (Yii::app()->user->hasFlash('contact')): ?>
            <div class="flash-success">
                <?php echo Yii::app()->user->getFlash('contact'); ?>
            </div>
        <?php else: ?>
            <div class="panel">
                <?php echo Yii::t('app', 'Sollten Sie Fragen oder Anregungen haben, setzen Sie sich mit uns in Kontakt indem Sie das nachfolgende Formular ausfüllen.');?><br>
                <?php echo Yii::t('app', 'Vielen Dank.');?>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'contact-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <fieldset>
                <legend><?php echo Yii::t('app', 'Kontakt');?></legend>
                <div class="row collapse">
                    <div class="two columns">
                        <span class="prefix"><?php echo $form->label($model, 'name'); ?></span>
                    </div>
                    <div class="ten columns mobile-input">
                        <?php
                        echo $form->textField($model, 'name');
                        echo $form->error($model, 'name');
                        ?>
                    </div>
                </div>
                <div class="row collapse">
                    <div class="two columns">
                        <span class="prefix"><?php echo $form->label($model, 'email'); ?></span>
                    </div>
                    <div class="ten columns mobile-input">
                        <?php
                        echo $form->textField($model, 'email');
                        echo $form->error($model, 'email');
                        ?>
                    </div>
                </div>
                <div class="row collapse">
                    <div class="two columns">
                        <span class="prefix"><?php echo $form->label($model, 'subject'); ?></span>
                    </div>
                    <div class="ten columns mobile-input">
                        <?php
                        echo $form->textField($model, 'subject', array('size' => 60, 'maxlength' => 128));
                        echo $form->error($model, 'subject');
                        ?>
                    </div>
                </div>

                <div class="row collapse">
                    <div class="twelve columns" style="padding-left:.2em;">
                        <?php
                        echo $form->textArea($model, 'body', array('rows' => 6, 'cols' => 50, 'placeholder' => Yii::t('app', 'Ihre Nachricht')));
                        echo $form->error($model, 'body');
                        ?>
                    </div>
                </div>
                <?php if (CCaptcha::checkRequirements()): ?>
                    <div class="row">
                        <div class="two columns"></div>
                        <div class="ten columns">
                            <?php $this->widget('CCaptcha'); ?>
                        </div>
                    </div>
                    <div class="row collapse">
                        <div class="two columns">
                            <span class="prefix"><?php echo $form->label($model, 'verifyCode'); ?></span>
                        </div>
                        <div class="ten columns mobile-input">
                            <?php
                            echo $form->textField($model, 'verifyCode');
                            echo $form->error($model, 'verifyCode');
                            ?>
                            <div class="hint">&nbsp;<?php echo Yii::t('app', 'Bitte geben Sie den im Bild angezeigten Sicherheitscode ein.');?></div>
                        </div>
                    </div>
                    <?php
                endif;
                echo CHtml::submitButton('Absenden', array('class' => 'small button'));
                ?>
            </fieldset>
            <?php $this->endWidget(); ?>
        <p class="text-center"><?php echo CHtml::link('<b>' . Yii::t('app', 'Zurück zur Startseite') . '</b>', 'index.php'); ?> </p>
        </div>
    </div>
<?php endif; ?>
