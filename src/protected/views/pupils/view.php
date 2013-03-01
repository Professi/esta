<?php
/* @var $this PupilsController */
/* @var $model Pupils */

$this->breadcrumbs=array(
	'Pupils'=>array('index'),
	$model->id_pupil,
);

$this->menu=array(
	array('label'=>'List Pupils', 'url'=>array('index')),
	array('label'=>'Create Pupils', 'url'=>array('create')),
	array('label'=>'Update Pupils', 'url'=>array('update', 'id'=>$model->id_pupil)),
	array('label'=>'Delete Pupils', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_pupil),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pupils', 'url'=>array('admin')),
);
?>

<h1>View Pupils #<?php echo $model->id_pupil; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_pupil',
		'firstname',
		'lastname',
		'id_schoolclass',
		'bDay',
	),
)); ?>
