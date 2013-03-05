<?php
/* @var $this CPChildController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pchildren',
);

$this->menu=array(
	array('label'=>'Create PChild', 'url'=>array('create')),
	array('label'=>'Manage PChild', 'url'=>array('admin')),
);
?>

<h1>Pchildren</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
