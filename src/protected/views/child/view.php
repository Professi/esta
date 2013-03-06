<?php
/* @var $this ChildController */
/* @var $model Child */

$this->breadcrumbs=array(
	'Children'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Child', 'url'=>array('index')),
	array('label'=>'Create Child', 'url'=>array('create')),
	array('label'=>'Update Child', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Child', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Child', 'url'=>array('admin')),
);
?>

<h1>View Child #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'firstname',
		'lastname',
		'class',
	),
)); ?>
