<?php
/* @var $this DateController */
/* @var $model Date */

$this->breadcrumbs=array(
	'Dates'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Date', 'url'=>array('index')),
	array('label'=>'Create Date', 'url'=>array('create')),
	array('label'=>'View Date', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Date', 'url'=>array('admin')),
);
?>

<h1>Update Date <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>