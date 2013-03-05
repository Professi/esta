<?php
/* @var $this CPParentChildController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pparent Children',
);

$this->menu=array(
	array('label'=>'Create PParentChild', 'url'=>array('create')),
	array('label'=>'Manage PParentChild', 'url'=>array('admin')),
);
?>

<h1>Pparent Children</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
