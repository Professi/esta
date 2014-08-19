<?php
/* Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
 * @var $groups
 * @var $users
 */
$this->setPageTitle(Yii::t('app','Gruppen zuweisen'));
$this->menu = array(
    array('label' => Yii::t('app', 'Gruppen verwalten'), 'url' => array('admin')),
);
Yii::app()->clientScript->registerCssFile( $this->assetsDir."/css/select2.min.css");
Yii::app()->clientScript->registerCoreScript('jquery.ui');
?>

<div class="row">
    <div class="twelve columns">
        <h2 class="text-center"><?php echo Yii::t('app','Gruppen zuweisen'); ?></h2>
        <table>
            <thead>
                <tr>
                    <th><?php echo Yii::t('app','Benutzer'); ?></th>
                    <th><?php echo Yii::t('app','Gruppe'); ?></th>
                </tr>
            </thead>
            <tbody id="input-target">

            </tbody>
        </table>
        <div class="small button right"><?php echo Yii::t('app','Absenden'); ?></div>
    </div>
</div>
<div class="push"></div>
<div class="row">
    <div class="six columns">
        <div class="row collapse">
            <div class="four columns">
                <span class="prefix"><?php echo Yii::t('app','Benutzer'); ?></span>
            </div>
            <div class="eight columns">
                <?php echo Select2::dropDownList('group-users', '', 
                                $users, 
                                array('id' => 'group-users',
                                    'select2Options' => array(
                                        'closeOnSelect' => false,
                                        'allowClear'=>true,
                                        'placeholder'=>Yii::t('app','Wählen Sie einen Benutzer aus')
                                        )
                                    )
                            ); ?>
            </div>
        </div>
    </div>
    <div class="six columns">
        <div class="row collapse">
            <div class="four columns">
                <span class="prefix"><?php echo Yii::t('app','Gruppe'); ?></span>
            </div>
            <div class="eight columns"><?php echo Select2::dropDownList('groups', '', $groups, array('id' => 'groups')); ?></div>
        </div>
    </div>
</div>
<div class="hide" id="input-template">
    <input type="hidden" name="user[]" class="group-user">
    <input type="hidden" name="group[]" class="group-id">
</div>
