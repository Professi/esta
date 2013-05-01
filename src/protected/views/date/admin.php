<?php
/**
 * Elternsprechtagsverwaltung
 */
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
/* @var $this DateController */
/* @var $model Date */
$this->breadcrumbs = array(
    'Dates' => array('index'),
    'Manage',
);
$this->menu = array(
    array('label' => 'Elternsprechtag erstellen', 'url' => array('create')),
);
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Elternsprechtagsverwaltung</h2>
    </div>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'date-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array('name' => 'date', 'value' => 'date(Yii::app()->params["dateFormat"], strtotime($data->date))'),
        array('name' => 'begin', 'value' => 'date(Yii::app()->params["timeFormat"], strtotime($data->begin))'),
        array('name' => 'end', 'value' => 'date(Yii::app()->params["timeFormat"], strtotime($data->end))'),
        array('name' => 'lockAt', 'value' => 'date(Yii::app()->params["dateTimeFormat"], $data->lockAt)'),
        'durationPerAppointment',
        array('name' => 'title', 'value' => '$data->title'),
//        array('name' => 'groups', 'visible' => Yii::app()->params['allowGroups']),
        array(
            'class' => 'CustomButtonColumn',
        ),
    ),
));
?>
