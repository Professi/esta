<?php
/* @var $this AppointmentController */
/* @var $data Appointment */
?>


<div class="panel">
    <div class="row">
        <div class="one columns">
            <b>#<?php echo CHtml::encode($data->id); ?></b>
        </div>
        <div class="eleven columns">
            <b>Am <?php echo CHtml::encode($data->date->date); ?> um <?php echo CHtml::encode($data->time.substr(0, 4)); ?></b>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="one columns"></div>
        <div class="four columns">
            <i>Ihr Kind</i><br>
            <?php echo CHtml::encode($data->parentChild->child->firstname.' '.$data->parentChild->child->lastname); ?>
        </div>
        <div class="three columns">
            <i>bei</i><br>
            <?php echo CHtml::encode($data->user->lastname); ?>
        </div>
    </div>

</div>