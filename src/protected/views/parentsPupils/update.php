<?php
/* @var $this ParentsPupilsController */
/* @var $model ParentsPupils */

$this->breadcrumbs=array(
	'Parents Pupils'=>array('index'),
	$model->id_parents_pupils=>array('view','id'=>$model->id_parents_pupils),
	'Update',
);

$this->menu=array(
	array('label'=>'List ParentsPupils', 'url'=>array('index')),
	array('label'=>'Create ParentsPupils', 'url'=>array('create')),
	array('label'=>'View ParentsPupils', 'url'=>array('view', 'id'=>$model->id_parents_pupils)),
	array('label'=>'Manage ParentsPupils', 'url'=>array('admin')),
);
?>

<h1>Update ParentsPupils <?php echo $model->id_parents_pupils; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>