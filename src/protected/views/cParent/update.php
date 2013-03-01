<?php
/* @var $this CParentController */
/* @var $model CParent */

$this->breadcrumbs=array(
	'Cparents'=>array('index'),
	$model->id_parent=>array('view','id'=>$model->id_parent),
	'Update',
);

$this->menu=array(
	array('label'=>'List CParent', 'url'=>array('index')),
	array('label'=>'Create CParent', 'url'=>array('create')),
	array('label'=>'View CParent', 'url'=>array('view', 'id'=>$model->id_parent)),
	array('label'=>'Manage CParent', 'url'=>array('admin')),
);
?>

<h1>Update CParent <?php echo $model->id_parent; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>