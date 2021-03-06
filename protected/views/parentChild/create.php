<?php
/**
 * ParentChild Create
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
/* @var $this ParentChildController */
/* @var $model ParentChild */
$this->setPageTitle(Yii::t('app', 'Eltern-Kind-Verknüpfung anlegen'));
$this->breadcrumbs = array(
    'Parent Children' => array('index'),
    'Create',
);
$this->menu = array(
    array(  'label' => Yii::t('app', 'Eltern-Kind-Verknüpfungen verwalten'),
            'url' => array('admin'),
            'visible' => Yii::app()->user->checkAccess(MANAGEMENT),
            'linkOptions' => array('class' => 'small button')),
);
?>
<div class="row">
    <div class="small-12 columns small-centered">
        <fieldset>
            <?php if (Yii::app()->user->checkAccess(PARENTS)) {
    ?>
                <legend><?php echo Yii::t('app', 'Kind anlegen'); ?></legend>
            <?php
} else {
        ?>
                <legend><?php echo Yii::t('app', 'Eltern-Kind-Verknüpfung anlegen'); ?></legend>
            <?php
    } ?>
            <?php
            echo $this->renderPartial('_form', array(
                'model' => $model,
                'userNameString' => $userNameString,
                'parent_disabled' => false,
            ));
            ?>
        </fieldset>
    </div>
</div>