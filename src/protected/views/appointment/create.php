<?php
/* @var $this AppointmentController */
/* @var $model Appointment */

$this->breadcrumbs=array(
	'Appointments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Termine verwalten', 'url'=>array('admin')),
);
?>


<div class="row">
    <div class="twelve columns centered">
        <fieldset>
            <legend>Termin anlegen</legend>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </fieldset>
    </div>
</div>