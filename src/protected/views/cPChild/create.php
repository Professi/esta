<?php
/* @var $this CPChildController */
/* @var $model PChild */

$this->breadcrumbs=array(
	'Pchildren'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PChild', 'url'=>array('index')),
	array('label'=>'Manage PChild', 'url'=>array('admin')),
);
?>

<h1>Create PChild</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>