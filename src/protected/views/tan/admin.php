<?php
/* @var $this TanController */
/* @var $model Tan */

$this->breadcrumbs=array(
	'Tans'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Tan generieren', 'url'=>array('genTans')),
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
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Bisher generierte Tans</h2>
    </div>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tan-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'tan',
		'used',
		array(
			'class'=>'MyButtonColumn',
		),
	),
)); ?>
