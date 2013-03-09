<?php
/* @var $this ParentChildController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Parent Children',
);

$this->menu=array(
	array('label'=>'Schüler hinzufügen', 'url'=>array('create')),
	array('label'=>'Verwalte Elternkindverknüpfungen', 'url'=>array('admin'), 'visible'=>Yii::app()->user->checkAccess(1)),
);

if(Yii::app()->user->checkAccess(1)) {
    ?> <h1>Elternkindverknüpfungen</h1> <?
} else {
?>

<h1>Ihr(e) Kind(er)</h1>

<?php  } $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
