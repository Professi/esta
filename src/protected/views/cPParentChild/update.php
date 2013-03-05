<?php
/* @var $this CPParentChildController */
/* @var $model PParentChild */

$this->breadcrumbs=array(
	'Pparent Children'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PParentChild', 'url'=>array('index')),
	array('label'=>'Create PParentChild', 'url'=>array('create')),
	array('label'=>'View PParentChild', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PParentChild', 'url'=>array('admin')),
);
?>

<h1>Update PParentChild <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>