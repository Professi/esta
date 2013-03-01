<?php
/* @var $this ParentsPupilsController */
/* @var $model ParentsPupils */

$this->breadcrumbs=array(
	'Parents Pupils'=>array('index'),
	$model->id_parents_pupils,
);

$this->menu=array(
	array('label'=>'List ParentsPupils', 'url'=>array('index')),
	array('label'=>'Create ParentsPupils', 'url'=>array('create')),
	array('label'=>'Update ParentsPupils', 'url'=>array('update', 'id'=>$model->id_parents_pupils)),
	array('label'=>'Delete ParentsPupils', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_parents_pupils),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ParentsPupils', 'url'=>array('admin')),
);
?>

<h1>View ParentsPupils #<?php echo $model->id_parents_pupils; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_parents_pupils',
		'id_parents',
		'id_pupil',
	),
)); ?>
