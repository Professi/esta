<?php
/* @var $this CPDateController */
/* @var $model PDate */

$this->breadcrumbs=array(
	'Pdates'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PDate', 'url'=>array('index')),
	array('label'=>'Manage PDate', 'url'=>array('admin')),
);
?>

<h1>Create PDate</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>