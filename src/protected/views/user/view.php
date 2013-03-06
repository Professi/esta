<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Benutzerliste', 'url'=>array('index')),
	array('label'=>'Benutzer erstellen', 'url'=>array('create')),
	array('label'=>'Benutzer aktualisieren', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Benutzer löschen', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Benutzer verwalten', 'url'=>array('admin')),
);
?>

<h1>View User #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'password',
		'activationKey',
		'createtime',
		'firstname',
		'status',
		'lastname',
		'email',
	),
)); ?>
