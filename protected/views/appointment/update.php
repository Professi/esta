<?php
/**
 * Appointment aktualisieren
 */
/* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
/* @var $this AppointmentController */
/* @var $model Appointment */
$this->setPageTitle(Yii::t('app', 'Termin bearbeiten'));
Yii::app()->clientScript->registerCssFile($this->assetsDir."/css/select2.min.css");
$this->breadcrumbs = array(
    'Appointments' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);
$this->menu = array(
    array(  'label' => Yii::t('app', 'Termin anlegen'),
            'url' => array('create'),
            'linkOptions' => array('class' => 'small button')),
    array(  'label' => Yii::t('app', 'Termin anzeigen'),
            'url' => array('view', 'id' => $model->id),
            'linkOptions' => array('class' => 'small button')),
    array(  'label' => Yii::t('app', 'Termine verwalten'),
            'url' => array('admin'),
            'linkOptions' => array('class' => 'small button')),
);
?>
<div class="row">
    <div class="small-12 columns small-centered">
        <fieldset>
            <legend><?php echo Yii::t('app', 'Termin bearbeiten'); ?></legend>
            <?php
            echo $this->renderPartial('_form', array(
                'model' => $model,
                'teacherLabel' => $teacherLabel,
                'parentLabel' => $parentLabel,
                'parentId' => $parentId,
            ));
            ?>
        </fieldset>
    </div>
</div>