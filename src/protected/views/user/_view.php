<?php
/**
 * Basis für CGridView der Benutzerverwaltung
 */
/* * Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
/* @var $data User */
?>
<div class="view">
    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br />
    <b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
    <?php echo CHtml::encode($data->username); ?>
    <br />
    <b><?php echo CHtml::encode($data->getAttributeLabel('createtime')); ?>:</b>
    <?php echo CHtml::encode(date(Yii::app()->params['dateTimeFormat'], $data->createtime)); ?>
    <br />
    <b><?php echo CHtml::encode($data->getAttributeLabel('firstname')); ?>:</b>
    <?php echo CHtml::encode($data->firstname); ?>
    <br />
    <b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
    <?php
    $state = "";
    switch ($data->state) {
        case 0:
            $state = "Nicht aktiv";
            break;
        case 1:
            $state = "Aktiv";
            break;
        case 2:
            $sate = "Gesperrt";
            break;
    }
    echo CHtml::encode($state);
    ?>
    <br />
</div>