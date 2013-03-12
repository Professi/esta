<?php
/* @var $this AppointmentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Appointments',
);

$this->menu=array(
	array('label'=>'Termine vereinbaren', 'url'=>array('create')),
	array('label'=>'Termin Manage', 'url'=>array('admin')),
);
?>

<h1>Appointments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
        'summaryText'=>'',
	'itemView'=>'_view',
        
)); ?>
