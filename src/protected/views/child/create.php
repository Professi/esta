<?php
/* @var $this ChildController */
/* @var $model Child */

$this->breadcrumbs=array(
	'Children'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Child', 'url'=>array('index')),
	array('label'=>'Manage Child', 'url'=>array('admin')),
);
?>

<h1>Create Child</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>