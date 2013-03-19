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
/* @var $model Appointment */

$this->breadcrumbs = array(
    'Appointments' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'Termin anlegen', 'url' => array('create')),
    array('label' => 'Termin bearbeiten', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Termin löschen', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Termine verwalten', 'url' => array('admin')),
);
?>

<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Termin Nummer <?php echo $model->id; ?></h2>
    </div>
</div>

<div class="row">
    <div class="twelve columns centered">
<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        array('name' => 'time', 'value' => $model->dateAndTime->time),
        array('name' => 'date_id', 'value' => $model->dateAndTime->date->date),
        //	'parent_child_id',
        array('name' => 'Schüler', 'value' => $model->parentChild->child->firstname . " " . $model->parentChild->child->lastname),
        array('name' => 'Erziehungsberechtigte/r', 'value' => $model->parentChild->user->firstname . " " . $model->parentChild->user->lastname),
        array('name' => 'Lehrer', 'value' => $model->user->title." ".$model->user->firstname." ".$model->user->lastname),
    //array('label'=>'Status','value'=>$model->getStateName()),
    ),
));
?>
        
    </div>
</div>