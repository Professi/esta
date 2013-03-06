<?php
/* @var $this ParentChildController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Parent Children',
);

$this->menu=array(
	array('label'=>'Create ParentChild', 'url'=>array('create')),
	array('label'=>'Manage ParentChild', 'url'=>array('admin')),
);
?>

<h1>Parent Children</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
