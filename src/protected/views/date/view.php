<?php
/* @var $this DateController */
/* @var $model Date */

$this->breadcrumbs=array(
	'Dates'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Elternsprechtag bearbeiten', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Elternsprechtag löschen', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Elternsprechtage verwalten', 'url'=>array('admin')),
);
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Elternsprechtag Nummer <?php echo $model->id; ?></h2>
    </div>
</div>

<div class="row">
    <div class="twelve columns centered">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date',
		'begin',
		'end',
		'durationPerAppointment',
	),
)); ?>
    </div>
</div>