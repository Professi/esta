<?php
/* @var $this ParentsPupilsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Parents Pupils',
);

$this->menu=array(
	array('label'=>'Create ParentsPupils', 'url'=>array('create')),
	array('label'=>'Manage ParentsPupils', 'url'=>array('admin')),
);
?>

<h1>Parents Pupils</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
