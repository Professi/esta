<?php
/* @var $this CParentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cparents',
);

$this->menu=array(
	array('label'=>'Create CParent', 'url'=>array('create')),
	array('label'=>'Manage CParent', 'url'=>array('admin')),
);
?>

<h1>Cparents</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
