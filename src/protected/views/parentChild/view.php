<?php
/* @var $this ParentChildController */
/* @var $model ParentChild */

$this->breadcrumbs=array(
	'Parent Children'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ParentChild', 'url'=>array('index')),
	array('label'=>'Create ParentChild', 'url'=>array('create')),
	array('label'=>'Update ParentChild', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ParentChild', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ParentChild', 'url'=>array('admin')),
);
?>

<h1>View ParentChild #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'child_id',
	),
)); ?>
