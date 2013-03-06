<?php
/* @var $this ChildController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Children',
);

$this->menu=array(
	array('label'=>'Create Child', 'url'=>array('create')),
	array('label'=>'Manage Child', 'url'=>array('admin')),
);
?>

<h1>Children</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
