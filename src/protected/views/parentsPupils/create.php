<?php
/* @var $this ParentsPupilsController */
/* @var $model ParentsPupils */

$this->breadcrumbs=array(
	'Parents Pupils'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ParentsPupils', 'url'=>array('index')),
	array('label'=>'Manage ParentsPupils', 'url'=>array('admin')),
);
?>

<h1>Create ParentsPupils</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>