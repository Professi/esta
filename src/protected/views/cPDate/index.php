<?php
/* @var $this CPDateController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pdates',
);

$this->menu=array(
	array('label'=>'Create PDate', 'url'=>array('create')),
	array('label'=>'Manage PDate', 'url'=>array('admin')),
);
?>

<h1>Pdates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
