<?php
/* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock
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
 * @var $this   GroupController
 * @var $model  Group
 * @var $groups
 * @var $users
 */
$this->setPageTitle(Yii::t('app', 'Gruppen zuweisen'));
$this->menu = array(
    array(  'label' => Yii::t('app', 'Gruppen verwalten'),
            'url' => array('admin'),
            'linkOptions' => array('class' => 'small button')),
);
Yii::app()->clientScript->registerCssFile($this->assetsDir."/css/select2.min.css");
Yii::app()->clientScript->registerCoreScript('jquery.ui');
?>

<div class="row">
    <div class="small-12 columns">
        <h2 class="text-center"><?php echo Yii::t('app', 'Gruppen zuweisen'); ?></h2>
        <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'date-form',
                'enableAjaxValidation' => false,
                'errorMessageCssClass' => 'error',
                'skin' => false,
                    ));
?>
            <table>
                <thead>
                    <tr>
                        <th><?php echo Yii::t('app', 'Benutzer'); ?></th>
                        <th><?php echo Yii::t('app', 'Gruppe'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="input-target">
                    <?php
                    foreach ($assignedUsers as $i => $assignedUser) {
                        $this->renderPartial('assignDetail', array('assignedUser' => $assignedUser,'index' => $i));
                    }
                    ?>

                </tbody>
            </table>
            <input type="submit" class="small button right" value="<?php echo Yii::t('app', 'Absenden'); ?>">
       <?php $this->endWidget(); ?>
    </div>
</div>
<div class="push"></div>
<div class="row">
    <div class="small-6 columns">
        <div class="row collapse">
            <div class="small-3 columns">
                <span class="prefix"><?php echo Yii::t('app', 'Benutzer'); ?></span>
            </div>
            <div class="small-8 columns">
                <?php 
                    echo Select2::multiSelect(
                        'group-users',
                        '',
                                $users,
                                array('id' => 'group-users',
                                        'placeholder'=>Yii::t('app', 'Wählen Sie einen Benutzer aus'),
                                        'select2Options' => array(
                                            'closeOnSelect' => false,
                                            'allowClear'=>true,
                                            )
                                        )
                            );
                    ?>
            </div>
            <div class="small-1 columns">
                <span class="postfix" id="close-user-select">
                    <i class="fi-x" title="<?php echo Yii::t('app', 'Liste schließen') ?>"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="small-6 columns">
        <div class="row collapse">
            <div class="small-4 columns">
                <span class="prefix"><?php echo Yii::t('app', 'Gruppe'); ?></span>
            </div>
            <div class="small-8 columns"><?php echo Select2::dropDownList('groups', '', $groups, array('id' => 'groups')); ?></div>
        </div>
    </div>
</div>
<div class="hide" id="input-template">
    <input type="hidden" name="user[]" class="group-user">
    <input type="hidden" name="group[]" class="group-id">
    <input type="checkbox" name="delete[]" class="group-delete" >
    <i class="fi-x" title="<?php echo Yii::t('app', 'Eintrag entfernen') ?>"></i>
</div>
