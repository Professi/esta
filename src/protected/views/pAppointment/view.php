<?php
/* @var $this PAppointmentController */
/* @var $model PAppointment */

$this->breadcrumbs=array(
	'Pappointments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PAppointment', 'url'=>array('index')),
	array('label'=>'Create PAppointment', 'url'=>array('create')),
	array('label'=>'Update PAppointment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PAppointment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PAppointment', 'url'=>array('admin')),
);
?>

<h1>View PAppointment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date_id',
		'user_id',
		'parent_child_id',
	),
)); ?>
