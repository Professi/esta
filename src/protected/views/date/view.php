<?php
/**
 * Elternsprechtag anschauen
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

$this->breadcrumbs=array(
	'Dates'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Elternsprechtag löschen', 'url'=>'#', 'linkOptions' => array( 'submit' => array( 'delete' , 'id' => $model->id ), 'confirm' => 'Möchten Sie diesen Elternsprechtag wirklich löschen?'), 'visible' => true),
	array('label'=>'Elternsprechtage verwalten', 'url'=>array('admin')),
);
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Elternsprechtag Nummer <?php echo $model->id; ?></h2>
    </div>
</div>

<div class="row">
    <div class="twelve columns centered">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array ('label' => $model->getAttributeLabel('date'), 'value' => date('d.m.Y', strtotime($model->date))),
		array ('label' => $model->getAttributeLabel('begin'), 'value' => date('H:i', strtotime($model->begin))),
		array ('label' => $model->getAttributeLabel('end'), 'value' => date('H:i', strtotime($model->end))),
            array ('label' => $model->getAttributeLabel('lockAt'), 'value' => date('H:i', strtotime($model->lockAt))),
		'durationPerAppointment',
	), //date(Yii::app()->params['dateTimeFormat'],
)); ?>
    </div>
</div>