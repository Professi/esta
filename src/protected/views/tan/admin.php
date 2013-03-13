<?php
/* @var $this TanController */
/* @var $model Tan */

$this->breadcrumbs=array(
	'Tans'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Tan', 'url'=>array('genTans')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tan-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Bisher generierte Tans</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tan-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'tan',
		'used',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
