<?php
/* @var $this CParentController */
/* @var $model CParent */

$this->breadcrumbs=array(
	'Cparents'=>array('index'),
	$model->id_parent,
);

$this->menu=array(
	array('label'=>'List CParent', 'url'=>array('index')),
	array('label'=>'Create CParent', 'url'=>array('create')),
	array('label'=>'Update CParent', 'url'=>array('update', 'id'=>$model->id_parent)),
	array('label'=>'Delete CParent', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_parent),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CParent', 'url'=>array('admin')),
);
?>

<h1>View CParent #<?php echo $model->id_parent; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_parent',
		'firstName',
		'lastName',
	),
)); ?>
