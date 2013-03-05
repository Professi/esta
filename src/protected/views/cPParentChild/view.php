<?php
/* @var $this CPParentChildController */
/* @var $model PParentChild */

$this->breadcrumbs=array(
	'Pparent Children'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PParentChild', 'url'=>array('index')),
	array('label'=>'Create PParentChild', 'url'=>array('create')),
	array('label'=>'Update PParentChild', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PParentChild', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PParentChild', 'url'=>array('admin')),
);
?>

<h1>View PParentChild #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'child_id',
	),
)); ?>
