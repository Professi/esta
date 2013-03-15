<?php
/* @var $this ParentChildController */
/* @var $model ParentChild */

$this->breadcrumbs=array(
	'Parent Children'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Eltern-Kind-Verknüpfung anlegen', 'url'=>array('create')),
	array('label'=>'Eltern-Kind-Verknüpfung bearbeiten', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eltern-Kind-Verknüpfung löschen', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Eltern-Kind-Verknüpfungen bearbeiten', 'url'=>array('admin')),
);
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Eltern-Kind-Verknüpfung Nummer <?php echo $model->id; ?></h2>
    </div>
</div>

<div class="row">
    <div class="twelve columns centered">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array('name' => 'user_id', 'value' => '$data->user->firstname." ".$data->user->lastname." (ID#".$data->user->user_id.")"'), 'user_id',
		array('name' => 'child_id', 'value' => '$data->child->firstname." ".$data->child->lastname." (ID#".$data->childr->child_id.")"'), 'child_id',
	),
)); ?>
    </div>
</div>