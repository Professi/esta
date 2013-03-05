<?php
/* @var $this CPChildController */
/* @var $model PChild */

$this->breadcrumbs=array(
	'Pchildren'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PChild', 'url'=>array('index')),
	array('label'=>'Create PChild', 'url'=>array('create')),
	array('label'=>'Update PChild', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PChild', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PChild', 'url'=>array('admin')),
);
?>

<h1>View PChild #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'firstname',
		'lastname',
		'class',
	),
)); ?>
