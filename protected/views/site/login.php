<?php
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
 * Loginpage
 * @var $this SiteController
 * @var $model LoginForm
 * @var $form CActiveForm */
$this->setPageTitle(Yii::t('app', 'Login'));
$this->breadcrumbs = array('Login');
?>
<div class="row">
    <div class="small-12 columns small-centered">
        <div class="panel paper">
            <h4> <?php echo Yii::t('app', 'Liebe Eltern,'); ?></h4>
            <p>  <?php echo Yii::t('app', 'Willkommen auf der elektronischen Elternsprechtagsplattform der') . ' ' . Yii::app()->params['schoolName']; ?>.<br>
                 <?php echo Yii::t('app', 'Melden Sie sich an oder registrieren Sie sich um Ihre Termine einzusehen oder um neue Termine zu vereinbaren.'); ?>
            </p>
        </div>
    </div>
</div>
<?php if ($model->getError('error') !== null) {
    ?>
    <div class="row">
        <div class="small-12 columns small-centered">
            <div class="alert-box alert">
                <?php echo $model->getError('error'); ?>
            </div>
        </div>
    </div>
<?php
} ?>
<div class="row">
    <div class="small-12 columns small-centered">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableClientValidation' => false,
            'errorMessageCssClass' => 'error',
            'skin' => false,
            'clientOptions' => array(
                'validateOnSubmit' => true),
        ));
        ?>
        <fieldset>
            <legend><?php echo Yii::t('app', 'Login'); ?></legend>
            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix"><?php echo $form->label($model, 'email'); ?></span>
                </div>
                <div class="small-8 columns mobile-input">
                    <?php
                    echo $form->textField($model, 'email');
                    echo $form->error($model, 'email');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix"><?php echo $form->label($model, 'password'); ?></span>
                </div>
                <div class="small-8 columns mobile-input">
                    <?php
                    echo $form->passwordField($model, 'password');
                    echo $form->error($model, 'password');
                    ?>
                </div>
            </div>
            <?php
            echo $form->textField($model, 'text', array('style' => 'display:none'));
            echo $form->checkBox($model, 'rememberMe');
            echo $form->label($model, 'rememberMe');
            ?>
            <br><br>
            <?php
            echo $form->error($model, 'rememberMe');
            echo CHtml::submitButton(Yii::t('app', 'Login'), array('class' => 'small button'));
            ?>
            <!--<div class="show-for-small-only"><br><br></div>-->
            <?php echo CHtml::link(Yii::t('app', 'Passwort vergessen?'), array('user/ChangePwd'), array('class' => 'medium right')); ?>
        </fieldset>
        <?php if (!Yii::app()->params['lockRegistration']) {
                ?>
            <p class="text-center"><?php echo CHtml::link('<b>' . Yii::t('app', 'Benötigen Sie einen neuen Zugang?') . '<br>' . Yii::t('app', 'Klicken Sie hier.') . '</b>', array('user/create')); ?> </p>
        <?php
            } else {
                ?>
            <div class="panel callout">
                <i class="fi-info"></i>
                <p><?php echo Yii::t('app', 'Aktuell ist es leider nicht möglich sich zu registrieren. Sofern Sie sich registrieren möchten, füllen Sie bitte das Kontaktformular aus.'); ?></p>
            </div>
            <?php
            }
        $this->endWidget();
        ?>
    </div>
</div>
