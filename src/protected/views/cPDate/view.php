<?php
/* @var $this CPDateController */
/* @var $model PDate */

$this->breadcrumbs=array(
	'Pdates'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PDate', 'url'=>array('index')),
	array('label'=>'Create PDate', 'url'=>array('create')),
	array('label'=>'Update PDate', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PDate', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PDate', 'url'=>array('admin')),
);
?>

<h1>View PDate #<?php echo $model->id; ?></h1>

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
