<?php
/* @var $this DateController */
/* @var $model Date */

$this->breadcrumbs=array(
	'Dates'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Elternsprechtag erstellen', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#date-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Datumsverwaltung</h2>
    </div>
</div>

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>-->

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<!--<div class="search-form" style="display:none">-->
<?php // $this->renderPartial('_search',array(
//	'model'=>$model,
//)); ?>
<!--</div> search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'date-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'date',
		'begin',
		'end',
		'durationPerAppointment',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
