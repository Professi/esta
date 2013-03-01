<?php
/* @var $this CParentController */
/* @var $model CParent */

$this->breadcrumbs=array(
	'Cparents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CParent', 'url'=>array('index')),
	array('label'=>'Manage CParent', 'url'=>array('admin')),
);
?>

<h1>Create CParent</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>