<?php
/* @var $this DateController */
/* @var $model Date */

$this->breadcrumbs=array(
	'Dates'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Date', 'url'=>array('index')),
	array('label'=>'Create Date', 'url'=>array('create')),
	array('label'=>'Update Date', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Date', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Date', 'url'=>array('admin')),
);
?>

<h1>View Date #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date',
		'begin',
		'end',
		'durationPerAppointment',
	),
)); ?>
