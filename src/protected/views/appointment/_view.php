<?php
/**   Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 *   This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/* @var $this AppointmentController */
/* @var $data Appointment */
?>


<div class="panel">
    <div class="row">
        <div class="one columns">
            <b>#<?php echo CHtml::encode($data->id); ?></b>
        </div>
        <div class="eleven columns">
            <b>Am <?php echo CHtml::encode($data->dateAndTime->date->date); ?> um <?php echo CHtml::encode($data->dateAndTime->time); ?></b>
        </div>
    </div>
    <br>
    <div class="row collapse">
        <div class="one columns"></div>
        <div class="one columns">
            <i>Ihr Kind</i>
        </div>
        <div class="ten columns">
            <?php echo CHtml::encode($data->parentChild->child->firstname.' '.$data->parentChild->child->lastname); ?>
        </div>
    </div>
    <br>
    <div class="row collapse">
        <div class="one columns"></div>
        <div class="one columns">   
            <i>bei</i>
        </div>
        <div class="ten columns">
             <?php echo CHtml::encode($data->user->title." ".$data->user->firstname." ".$data->user->lastname); ?>
        </div>
    </div>
</div>