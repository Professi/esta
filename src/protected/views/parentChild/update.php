<?php
/* @var $this ParentChildController */
/* @var $model ParentChild */

$this->breadcrumbs=array(
	'Parent Children'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ParentChild', 'url'=>array('index')),
	array('label'=>'Create ParentChild', 'url'=>array('create')),
	array('label'=>'View ParentChild', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ParentChild', 'url'=>array('admin')),
);
?>

<h1>Update ParentChild <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>