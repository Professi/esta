<?php
/**
 * Appointment view für ListView
 * Copyright (C) 2013-2014  Christian Ehringfeld, David Mock
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
/** @var $this AppointmentController 
 *  @var $data Appointment 
 */
?>

<tr>
    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->formatDateTime(strtotime($data->dateandtime->date->date), "medium", null)), ' - ', CHtml::encode(Yii::app()->dateFormatter->formatDateTime(strtotime($data->dateandtime->time), null, "short")); ?></td>
    <td><?php echo CHtml::encode("{$data->parentchild->child->firstname} {$data->parentchild->child->lastname}"); ?></td>
    <td><?php echo CHtml::encode("{$data->user->title} {$data->user->firstname} {$data->user->lastname}"); ?></td>
</tr>