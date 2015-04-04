<?php
/**
 * Appointment view für ListView
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
/* @var $data Appointment */
?>
<div class="paper panel">
    <div class="row">
        <div class="small-2 medium-1 columns">
            <b>#<?php echo CHtml::encode($index + 1); ?></b>
        </div>
        <div class="small-10 medium-11 columns">
            <b><?php echo Yii::t('app', 'Am {date} um {time}', array('{date}' => CHtml::encode(Yii::app()->dateFormatter->formatDateTime(strtotime($data->dateandtime->date->date), "medium", null)), '{time}' => CHtml::encode(Yii::app()->dateFormatter->formatDateTime(strtotime($data->dateandtime->time), null, "short")))); ?>
            </b>
        </div>
    </div>
    <br>
    <div class="row collapse">
        <div class="small-3 small-offset-1 medium-2 large-1 columns">
            <i><?php echo Yii::t('app', 'Ihr Kind') ?></i>
        </div>
        <div class="small-8 medium-9 large-10 columns">
            <?php echo CHtml::encode("{$data->parentchild->child->firstname} {$data->parentchild->child->lastname}"); ?>
        </div>
    </div>
    <br>
    <div class="row collapse">
        <div class="small-3 small-offset-1 medium-2 large-1 columns">   
            <i><?php echo Yii::t('app', 'bei'); ?></i>
        </div>
        <div class="small-8 medium-9 large-10 columns">
            <?php echo CHtml::encode("{$data->user->title} {$data->user->firstname} {$data->user->lastname}"); ?>
        </div>
        
    </div>
    <br>
     <div class="row collapse">
        <div class="small-3 small-offset-1 medium-2 large-1 columns">
            <i><?php echo Yii::t('app', 'In Raum') ?></i>
        </div>
        <div class="small-8 medium-9 large-10 columns">
            <?php echo CHtml::encode("{$data->user->getRoom($data->dateandtime->date->id)->name}"); ?>
        </div>
         <a class="small button right hide-for-print delete-appointment" href="index.php?r=appointment/delete&amp;id=<?php echo CHtml::encode($data->id); ?>"><?php echo Yii::t('app', 'Termin löschen?'); ?></a>
    </div>
</div>
