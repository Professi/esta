<?php
/* @var $this DateController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Dates',
);

$this->menu=array(
	array('label'=>'Create Date', 'url'=>array('create')),
	array('label'=>'Manage Date', 'url'=>array('admin')),
);
?>

<h1>Dates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
