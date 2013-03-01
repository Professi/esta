<?php
/* @var $this ParentsController */
/* @var $model Parents */

$this->breadcrumbs=array(
	'Parents'=>array('index'),
	$model->id_parents=>array('view','id'=>$model->id_parents),
	'Update',
);

$this->menu=array(
	array('label'=>'List Parents', 'url'=>array('index')),
	array('label'=>'Create Parents', 'url'=>array('create')),
	array('label'=>'View Parents', 'url'=>array('view', 'id'=>$model->id_parents)),
	array('label'=>'Manage Parents', 'url'=>array('admin')),
);
?>

<h1>Update Parents <?php echo $model->id_parents; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>