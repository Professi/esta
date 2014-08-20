<?php
/**
 * Appointment View für einen Termin
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
$this->setPageTitle(Yii::t('app', 'Detailansicht Termin'));
$this->breadcrumbs = array(
    'Appointments' => array('index'),
    $model->id,
);
$this->menu = array(
    array(  'label' => Yii::t('app', 'Termin anlegen'), 
            'url' => array('create'),
            'linkOptions' => array('class' => 'small button')),
    array(  'label' => Yii::t('app', 'Termin bearbeiten'), 
            'url' => array('update', 'id' => $model->id),
            'linkOptions' => array('class' => 'small button')),
    array(  'label' => Yii::t('app', 'Termin löschen'), 
            'url' => '#', 
            'linkOptions' => array(
                'submit' => array(
                    'delete', 
                    'id' => $model->id), 
                'confirm' => 'Sind Sie sich sicher, dass Sie diesen Termin löschen möchten?',
                'class' => 'small button')),
    array(  'label' => Yii::t('app', 'Termine verwalten'), 
            'url' => array('admin'),
            'linkOptions' => array('class' => 'small button')),
);
?>
<div class="row">
    <div class="small-12 columns small-centered">
        <h2 class="text-center"><?php echo Yii::t('app', 'Termin Nummer {id}', array('{id}' => $model->getPrimaryKey())); ?></h2>
    </div>
</div>
<div class="row">
    <div class="small-12 columns small-centered">
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                array('name' => 'time', 'value' => Yii::app()->dateFormatter->formatDateTime(strtotime($model->dateandtime->time), null, "short")),
                array('name' => 'date_id', 'value' => Yii::app()->dateFormatter->formatDateTime(strtotime($model->dateandtime->date->date), "short", null)),
                array('name' => Yii::t('app', 'Schüler'), 'value' => $model->parentchild->child->firstname . " " . $model->parentchild->child->lastname),
                array('name' => Yii::t('app', 'Erziehungsberechtigte/r'), 'value' => $model->parentchild->user->firstname . " " . $model->parentchild->user->lastname),
                array('name' => Yii::t('app', 'Lehrer'), 'value' => $model->user->title . " " . $model->user->firstname . " " . $model->user->lastname),
            ),
        ));
        ?>
    </div>
</div>