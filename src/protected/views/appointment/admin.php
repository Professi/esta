<?php
/**
 * Terminverwaltung
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
/* @var $this AppointmentController */
/* @var $model Appointment */
/* @var $blockedApp BlockedAppointment */

$this->breadcrumbs = array(
    'Appointments' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'Termin anlegen', 'url' => array('create')),
    array('label' => 'Termin blockieren', 'url' => array('createBlockApp'), 'visible' => (Yii::app()->params['allowBlockingAppointments'])),
);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$('#appointment-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Terminverwaltung</h2>
    </div>
</div>



<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'appointment-grid',
    'dataProvider' => $model->search(),
//	'filter'=>$model,
    'columns' => array(
        'id',
        array('name' => 'dateAndTime_id', 'value' => 'date(Yii::app()->params["dateTimeFormat"], strtotime($data->dateAndTime->date->date . $data->dateAndTime->time))'),
        array('name' => 'parent_child_id', 'value' => '$data->parentChild->user->firstname." ".$data->parentChild->user->lastname'),
        array('name' => 'user_id', 'value' => '$data->user->title." ".$data->user->firstname." ".$data->user->lastname'),
        array('class' => 'CustomButtonColumn',),
    ),
));
?>
<div class="push"></div>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Blockierte Termine</h2>
    </div>
</div>

<?php if (Yii::app()->params['allowBlockingAppointments']) { 
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'appointmentBlock-grid',
        'dataProvider' => $blockedApp->search(),
        'columns' => array(
            'id',
            array('name' => 'dateAndTime_id', 'value' => 'date(Yii::app()->params["dateTimeFormat"], strtotime($data->dateAndTime->date->date . $data->dateAndTime->time))'),
            array('name' => 'user_id', 'value' => '$data->user->title." ".$data->user->firstname." ".$data->user->lastname'),
            array('name' => 'reason'),
            array('class' => 'CustomButtonColumn', 'template' => '{delete}', 'buttons' => array(
                    'delete' => array(
                        'url' => '$this->grid->controller->createUrl("/appointment/deleteblockapp", array("id"=>$data->id))'
                    ),
                )),
        ),
    ));
}
?>
