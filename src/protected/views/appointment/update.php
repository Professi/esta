<?php
/* @var $this AppointmentController */
/* @var $model Appointment */

$this->breadcrumbs=array(
	'Appointments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Termin anlegen', 'url'=>array('create')),
	array('label'=>'Termin anzeigen', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Termine verwalten', 'url'=>array('admin')),
);
?>
<div class="row">
    <div class="twelve columns centered">
        <fieldset>
            <legend>Termin Nummer <?php echo $model->id; ?> bearbeiten</legend>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </fieldset>
    </div>
</div>