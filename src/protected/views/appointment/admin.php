<?php
/* @var $this AppointmentController */
/* @var $model Appointment */

$this->breadcrumbs=array(
	'Appointments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Termin anlegen', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#appointment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Terminverwaltung</h2>
    </div>
</div>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'appointment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'time',
		array(  'name' => 'date_id', 'value' => '$data->date->date' ),
		array(  'name' => 'parent_child_id', 
                        'value' => '$data->parentChild->user->firstname." ".$data->parentChild->user->lastname'),
		array(  'name' => 'user_id', 'value' => '$data->user->lastname'),
		array(
			'class'=>'CustomButtonColumn',
		),
	),
)); ?>
