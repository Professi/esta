<?php
/**
 * View Benutzer aktualisieren
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
/* @var $this UserController */
/* @var $model User */
$this->setPageTitle(Yii::t('app', 'Benutzerkonto bearbeiten'));
$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);
$this->menu = array(
    array(  'label' => Yii::t('app', 'Benutzer erstellen'),
            'url' => array('create'),
            'visible' => Yii::app()->user->checkAccess(MANAGEMENT),
            'linkOptions' => array('class' => 'small button')),
    array(  'label' => Yii::t('app', 'Benutzer anzeigen'),
            'url' => array('view', 'id' => $model->id),
            'visible' => Yii::app()->user->checkAccess(MANAGEMENT),
            'linkOptions' => array('class' => 'small button')),
    array(  'label' => Yii::t('app', 'Benutzer verwalten'),
            'url' => array('admin'),
            'visible' => Yii::app()->user->checkAccess(MANAGEMENT),
            'linkOptions' => array('class' => 'small button')),
);
?>
<div class="row">
    <div class="small-9 columns small-centered">
        <fieldset>
            <legend><?php echo Yii::t('app', 'Benutzer {email} aktualisieren', array('{email}'=>$model->email)); ?></legend>
            <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
        </fieldset>
    </div>
</div>