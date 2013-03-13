<?php
/* @var $this ChildController */
/* @var $model Child */

$this->breadcrumbs=array(
	'Children'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Schüler anlegen', 'url'=>array('create')),
	array('label'=>'Schüler bearbeiten', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Schüler löschen', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Schüler verwalten', 'url'=>array('admin')),
);
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Schüler Nummer <?php echo $model->id; ?></h2>
    </div>
</div>

<div class="row">
    <div class="twelve columns centered">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'firstname',
		'lastname',
	),
)); ?>
    </div>
</div>