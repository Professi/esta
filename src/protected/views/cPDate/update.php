<?php
/* @var $this CPDateController */
/* @var $model PDate */

$this->breadcrumbs=array(
	'Pdates'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PDate', 'url'=>array('index')),
	array('label'=>'Create PDate', 'url'=>array('create')),
	array('label'=>'View PDate', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PDate', 'url'=>array('admin')),
);
?>

<h1>Update PDate <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>