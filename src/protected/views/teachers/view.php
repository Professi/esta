<?php
/* @var $this TeachersController */
/* @var $model Teachers */

$this->breadcrumbs=array(
	'Teachers'=>array('index'),
	$model->id_teacher,
);

$this->menu=array(
	array('label'=>'List Teachers', 'url'=>array('index')),
	array('label'=>'Create Teachers', 'url'=>array('create')),
	array('label'=>'Update Teachers', 'url'=>array('update', 'id'=>$model->id_teacher)),
	array('label'=>'Delete Teachers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_teacher),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Teachers', 'url'=>array('admin')),
);
?>

<h1>View Teachers #<?php echo $model->id_teacher; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_teacher',
		'firstName',
		'lastName',
	),
)); ?>
