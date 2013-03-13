<?php
/* @var $this ChildController */
/* @var $model Child */

$this->breadcrumbs=array(
	'Children'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Kind anlegen', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#child-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Schülerverwaltung</h2>
    </div>
</div>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'child-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'firstname',
		'lastname',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
