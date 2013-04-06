<?php
/**
 * Date _view
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
/* @var $data Date */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode(date('d.m.Y', strtotime($data->date))); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('begin')); ?>:</b>
	<?php echo CHtml::encode(date('H:i', strtotime($data->begin))); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end')); ?>:</b>
	<?php echo CHtml::encode(date('H:i', strtotime($data->end))); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('durationPerAppointment')); ?>:</b>
	<?php echo CHtml::encode($data->durationPerAppointment); ?>
	<br />


</div>