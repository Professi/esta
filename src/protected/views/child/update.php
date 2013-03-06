<?php
/* @var $this ChildController */
/* @var $model Child */

$this->breadcrumbs=array(
	'Children'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Child', 'url'=>array('index')),
	array('label'=>'Create Child', 'url'=>array('create')),
	array('label'=>'View Child', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Child', 'url'=>array('admin')),
);
?>

<h1>Update Child <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>