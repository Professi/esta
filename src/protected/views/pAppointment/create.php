<?php
/* @var $this PAppointmentController */
/* @var $model PAppointment */

$this->breadcrumbs=array(
	'Pappointments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PAppointment', 'url'=>array('index')),
	array('label'=>'Manage PAppointment', 'url'=>array('admin')),
);
?>

<h1>Create PAppointment</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>