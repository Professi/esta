<?php
/* @var $this PAppointmentController */
/* @var $model PAppointment */

$this->breadcrumbs=array(
	'Pappointments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PAppointment', 'url'=>array('index')),
	array('label'=>'Create PAppointment', 'url'=>array('create')),
	array('label'=>'View PAppointment', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PAppointment', 'url'=>array('admin')),
);
?>

<h1>Update PAppointment <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>