<?php
/* @var $this ParentChildController */
/* @var $model ParentChild */

$this->breadcrumbs=array(
	'Parent Children'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Eltern-Kind-Verknüpfung anlegen', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#parent-child-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Eltern-Kind-Verknüpfung</h2>
    </div>
</div>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'parent-child-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array('name' => 'user_id', 'value' => '$data->user->firstname." ".$data->user->lastname'), 
		array('name' => 'child_id', 'value' => '$data->child->firstname." ".$data->child->lastname'),
		array(
			'class'=>'MyButtonColumn',
		),
	),
)); ?>
