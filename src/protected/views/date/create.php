<?php
/* @var $this DateController */
/* @var $model Date */

$this->breadcrumbs=array(
	'Dates'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Date', 'url'=>array('index')),
	array('label'=>'Manage Date', 'url'=>array('admin')),
);
?>

<h1>Create Date</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>