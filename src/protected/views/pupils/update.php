<?php
/* @var $this PupilsController */
/* @var $model Pupils */

$this->breadcrumbs=array(
	'Pupils'=>array('index'),
	$model->id_pupil=>array('view','id'=>$model->id_pupil),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pupils', 'url'=>array('index')),
	array('label'=>'Create Pupils', 'url'=>array('create')),
	array('label'=>'View Pupils', 'url'=>array('view', 'id'=>$model->id_pupil)),
	array('label'=>'Manage Pupils', 'url'=>array('admin')),
);
?>

<h1>Update Pupils <?php echo $model->id_pupil; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>