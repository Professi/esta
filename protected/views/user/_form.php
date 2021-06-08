<?php
/**
 * User Form
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
 * @var $form CActiveForm
 */
Yii::app()->clientScript->registerCssFile($this->assetsDir . "/css/select2.min.css");
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'errorMessageCssClass' => 'error',
    'skin' => false,
        ));
?>
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
<div class="row collapse">
    <div class="small-3 columns">
        <span class="prefix"><?php echo $form->label($model, 'email'); ?></span>
    </div>
    <div class="small-9 columns mobile-input">
        <?php
        if (Yii::app()->user->CheckAccess('1') || Yii::app()->user->isGuest) {
            echo $form->textField($model, 'email', array('size' => 45, 'maxlength' => 45));
            echo $form->error($model, 'email');
        } else {
            echo $form->textField($model, 'email', array('readonly' => true, 'class' => 'form-readonly'));
            echo $form->error($model, 'email');
        }
        ?>
    </div>
</div>
<div class="row collapse">
    <div class="small-3 columns">
        <?php if (!$model->isNewRecord) {
            ?>  
            <span class="prefix infofeld">
                <?php echo $form->label($model, 'password', array('class' => 'infolabel')); ?>
            </span>
            <div class="infotext">
                <i class="fi-info"></i>
                <?php
                echo Yii::t('app', 'Bitte beachten Sie, dass das Passwort nur geändert wird, wenn Sie ein neues Passwort eintragen.');
                echo Yii::t('app', 'Sollten Sie kein neues Passwort vergeben wollen, so können Sie die Passwortfelder leer lassen.');
                ?>
            </div>
            <?php
        } else {
            ?>
            <span class="prefix">
                <?php echo $form->label($model, 'password'); ?>
            </span>
            <?php
        }
        ?>
    </div>
    <div class="small-6 columns mobile-input">
        <?php
        echo $form->passwordField($model, 'password', array('size' => 45, 'maxlength' => 45));
        echo $form->error($model, 'password');
        ?>
    </div>
    <div class="small-3 columns mobile-input">
        <span class="postfix" style="font-size:.8em;"><?php echo Yii::t('app', 'Mindestlänge 8 Zeichen'); ?></span>
    </div>
</div>
<div class="show-for-small"><br></div>
<div class="row collapse">
    <div class="small-3 columns">
        <span class="prefix"><?php echo $form->label($model, 'password_repeat'); ?></span>
    </div>
    <div class="small-9 columns mobile-input">
        <?php
        echo $form->passwordField($model, 'password_repeat', array('size' => 45, 'maxlength' => 45));
        echo $form->error($model, 'password_repeat');
        ?>
    </div>
</div>
<?php if (Yii::app()->user->checkAccess(MANAGEMENT)) {
    ?>
    <div class="row collapse">
        <div class="small-3 columns">
            <span class="prefix"><?php echo $form->label($model, 'state'); ?></span>
        </div>
        <div class="small-9 columns">
            <?php
            echo Select2::activeDropDownList($model, 'state', array('1' => 'Aktiv', '0' => 'Nicht aktiv', '2' => 'Gesperrt'), array('select2Options' => array('minimumResultsForSearch' => 10)));
            echo $form->error($model, 'state');
            ?>
        </div>
    </div>
    <div class="row collapse">
        <div class="small-3 columns">
            <span class="prefix"><?php echo $form->label($model, 'role'); ?></span>
        </div>
        <div class="small-9 columns">
            <?php
            echo Select2::activeDropDownList($model, 'role', $model->getRolePermission(), array('select2Options' => array('minimumResultsForSearch' => 10)));
            echo $form->error($model, 'role');
            ?>
        </div>
    </div>
    <?php
    if (Yii::app()->params['allowGroups'] && ($model->role > 1 || $model->isNewRecord) && !Yii::app()->user->isGuest()) {
        $groups = Group::model()->getAllGroups('DESC');
        if (!empty($groups)) {
            ?>
            <div class="row collapse">
                <div class="small-3 columns">
                    <span class="prefix"><?php echo $form->label($model, 'groups'); ?> </span>
                </div>
                <div class="small-9 columns">
                    <?php
                    if (isset($_POST['User']['groupIds'])) {
                        $model->groupIds = $_POST['User']['groupIds'];
                    }
                    if (!$model->isNewRecord) {
                        $model->groupIds = $model->groups;
                    }
                    echo Select2::activeMultiSelect($model, 'groupIds', $groups, array(
                        'placeholder' => Yii::t('app', 'Hier können Sie mehrere Gruppen auswählen...'),
                        'id' => 'groups-select',
                        'select2Options' => array(
                            'allowClear' => true,
                        ),
                    ));
                    echo $form->error($model, 'groups');
                    ?>
                </div>
            </div>
            <?php
        }
    }
}
if (Yii::app()->user->isGuest && CCaptcha::checkRequirements()) {

    if (!Yii::app()->params['allowParentsToManageChilds']) {
        echo '<div class="row collapse">';
        echo '<div class="small-3 columns">';
        echo '<span class="prefix">' . $form->label($model, 'tan') . '</span>';
        echo '</div>';
        echo '<div class="small-9 columns mobile-input">';
        echo $form->textField($model, 'tan', array('size' => 45, 'maxlength' => Yii::app()->params['tanSize']));
        echo $form->error($model, 'tan');
        echo '</div>';
        echo '</div>';
    }
    ?>
    <div class="row ">
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
} echo CHtml::submitButton($model->isNewRecord && Yii::app()->user->isGuest() ? Yii::t('app', 'Registrieren') : Yii::t('app', 'Speichern'), array('class' => 'button'));
$this->endWidget();
?>
