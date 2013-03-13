<?php
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
    </div>
</div>