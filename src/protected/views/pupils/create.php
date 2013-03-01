<?php
/* @var $this PupilsController */
/* @var $model Pupils */

$this->breadcrumbs=array(
	'Pupils'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pupils', 'url'=>array('index')),
	array('label'=>'Manage Pupils', 'url'=>array('admin')),
);
?>

<h1>Create Pupils</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>