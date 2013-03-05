<?php
/* @var $this CPChildController */
/* @var $model PChild */

$this->breadcrumbs=array(
	'Pchildren'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PChild', 'url'=>array('index')),
	array('label'=>'Create PChild', 'url'=>array('create')),
	array('label'=>'View PChild', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PChild', 'url'=>array('admin')),
);
?>

<h1>Update PChild <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>