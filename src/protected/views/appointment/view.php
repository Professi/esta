<?php
/* @var $this AppointmentController */
/* @var $model Appointment */

$this->breadcrumbs = array(
    'Appointments' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List Appointment', 'url' => array('index')),
    array('label' => 'Create Appointment', 'url' => array('create')),
    array('label' => 'Update Appointment', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Appointment', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Appointment', 'url' => array('admin')),
);
?>

<h1>View Appointment #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'time',
        'date_id',
        //	'parent_child_id',
        array('name' => 'Schüler', 'value' => $model->parentChild->child->firstname . " " . $model->parentChild->child->lastname),
        array('name' => 'Erziehungsberechtigte/r', 'value' => $model->parentChild->user->firstname . " " . $model->parentChild->user->lastname),
        array('name' => 'Lehrer', 'value' => $model->user->firstname . " " . $model->user->lastname),
    //array('label'=>'Status','value'=>$model->getStateName()),
    ),
));
?>
