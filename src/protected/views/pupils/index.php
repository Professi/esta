<?php
/* @var $this PupilsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pupils',
);

$this->menu=array(
	array('label'=>'Create Pupils', 'url'=>array('create')),
	array('label'=>'Manage Pupils', 'url'=>array('admin')),
);
?>

<h1>Pupils</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
