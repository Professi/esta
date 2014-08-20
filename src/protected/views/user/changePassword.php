<?php
/**
 * View Benutzer Passwort ändern
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
 * @var $model ChangePwd 
 */
$this->setPageTitle(Yii::t('app', 'Passwort zurücksetzen'));
?>
<div class="row">
    <div class="small-9 columns small-centered">
        <h3><?php echo Yii::t('app', 'Möchten Sie Ihr Passwort zurücksetzen ?'); ?></h3>
        <div class="panel">
            <p><?php echo Yii::t('app', 'Geben Sie Ihre E-Mail-Adresse ein. Ihnen wird ein Aktivierungslink zugesendet mit dem Sie ein neues Passwort setzen können.'); ?></p>
        </div>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'ChangePwd-form',
            'errorMessageCssClass' => 'error',
            'skin' => false,
        ));
        ?>                
        <fieldset>
            <div class="row collapse">
                <div class="small-3 columns">
                    <span class="prefix"><?php echo $form->label($model, 'email'); ?></span>
                </div>
                <div class="small-9 columns mobile-input">
                    <?php
                    echo $form->textField($model, 'email');
                    echo $form->error($model, 'email');
                    ?>
                </div>
            </div>
            <?php if (CCaptcha::checkRequirements()): ?>
                <div class="row">
                    <div class="small-3 columns"></div>
                    <div class="small-9 columns">
                        <?php $this->widget('CCaptcha'); ?>
                    </div>
                </div>
                <div class="row collapse">
                    <div class="small-3 columns">
                        <span class="prefix"><?php echo $form->label($model, 'verifyCode'); ?></span>
                    </div>
                    <div class="small-9 columns mobile-input">
                        <?php
                        echo $form->textField($model, 'verifyCode');
                        echo $form->error($model, 'verifyCode');
                        ?>
                        <div class="hint">&nbsp;<?php echo Yii::t('app', 'Bitte geben Sie den im Bild angezeigten Sicherheitscode ein.'); ?></div>
                    </div>
                </div>
                <?php
            endif;
            echo CHtml::submitButton(Yii::t('app','Absenden'), array('class' => 'small button'));
            ?>
        </fieldset>
        <?php $this->endWidget(); ?>
        <div class="panel">
            <p class="medium"><?php echo Yii::t('app', 'Das Zurücksetzen eines Passwortes funktioniert nur, wenn Sie bereits im System registriert sind. Sollten Sie noch keinen Zugang besitzen registrieren Sie sich bitte zuerst im System.'); ?></p>
        </div>
        <p class="text-center"><?php echo CHtml::link('<b>' . Yii::t('app', 'Zurück zur Startseite') . '</b>', 'index.php'); ?> </p>
    </div>
</div>
