<?php
/* @var $this PAppointmentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pappointments',
);

$this->menu=array(
	array('label'=>'Create PAppointment', 'url'=>array('create')),
	array('label'=>'Manage PAppointment', 'url'=>array('admin')),
);
?>

<h1>Pappointments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
