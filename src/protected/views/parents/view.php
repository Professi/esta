<?php
/* @var $this ParentsController */
/* @var $model Parents */

$this->breadcrumbs=array(
	'Parents'=>array('index'),
	$model->id_parents,
);

$this->menu=array(
	array('label'=>'List Parents', 'url'=>array('index')),
	array('label'=>'Create Parents', 'url'=>array('create')),
	array('label'=>'Update Parents', 'url'=>array('update', 'id'=>$model->id_parents)),
	array('label'=>'Delete Parents', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_parents),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Parents', 'url'=>array('admin')),
);
?>

<h1>View Parents #<?php echo $model->id_parents; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_parents',
		'parent1',
		'parent2',
		'pw',
	),
)); ?>
