<?php
/**
 * Loginpage
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
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->setPageTitle(Yii::app()->name . ' - ' .'Login');
$this->breadcrumbs = array(
    'Login',
);
?>
<div class="row">
    <div class="twelve columns ">
        <div class="panel">
            <h4> Liebe Eltern,</h4>
            <p> Willkommen auf der elektronischen Elternsprechtagsplattform der Brühlwiesenschule Hofheim.<br>
                Melden Sie sich an oder registrieren Sie sich um ihre Termine einzusehen oder neue Termine zu vereinbaren.
            </p>
        </div>
    </div>
</div>
<?php if ($model->getError('error') !== NULL) { ?>
    <div class="row">
        <div class="twelve columns centered">
            <div class="alert-box alert">
                <? echo $model->getError('error'); ?> 
            </div> 
        </div>
    </div> 
<? } ?>
<div class="row">
    <div class="seven columns centered">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableClientValidation' => false,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
        ));
        ?>
        <fieldset>
            <legend>Login</legend>
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
                    <span class="prefix"><?php echo $form->label($model, 'password'); ?></span>
                </div>
                <div class="ten columns mobile-input">
                    <?php
                    echo $form->passwordField($model, 'password');
                    echo $form->error($model, 'password');
                    ?>
                </div>
            </div>
            <?php
            echo $form->textField($model, 'text', array('style' => 'display:none'));
            echo $form->checkBox($model, 'rememberMe');
            ?>
            Anmeldedaten merken<br><br>
            <?php
            echo $form->error($model, 'rememberMe');
            echo CHtml::submitButton('Login', array('class' => 'button'));
            ?>
            <div class="show-for-small"><br><br></div>
            <?php echo CHtml::link('Passwort vergessen?', 'index.php?r=user/ChangePwd', array('class' => 'medium right')); ?>
        </fieldset>
        <?php if (!Yii::app()->params['lockRegistration']) { ?>
            <p class="text-center"><?php echo CHtml::link('<b>Ben&ouml;tigen Sie einen neuen Zugang?<br>Klicken Sie hier.</b>', 'index.php?r=user/create'); ?> </p>
        <?php } else { ?>
            <div class="panel">
                <p class="text-center">Aktuell ist es leider nicht m&ouml;glich sich zu registrieren. Sofern Sie sich registrieren m&ouml;chten, f&uuml;llen Sie bitte das Kontaktformular aus.</p>
            </div>
        <?php } $this->endWidget(); ?>
    </div>
</div>
