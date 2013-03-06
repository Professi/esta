<?php
/* @var $this ParentChildController */
/* @var $model ParentChild */

$this->breadcrumbs=array(
	'Parent Children'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ParentChild', 'url'=>array('index')),
	array('label'=>'Manage ParentChild', 'url'=>array('admin')),
);
?>

<h1>Create ParentChild</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>