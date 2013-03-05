<?php
/* @var $this CPParentChildController */
/* @var $model PParentChild */

$this->breadcrumbs=array(
	'Pparent Children'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PParentChild', 'url'=>array('index')),
	array('label'=>'Manage PParentChild', 'url'=>array('admin')),
);
?>

<h1>Create PParentChild</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>