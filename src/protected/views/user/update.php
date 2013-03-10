<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Benutzer erstellen', 'url'=>array('create'), 'visible'=>Yii::app()->user->checkAccess('1')),
	array('label'=>'Benutzer anzeigen', 'url'=>array('view', 'id'=>$model->id),),
	array('label'=>'Benutzer verwalten', 'url'=>array('admin'), 'visible'=>Yii::app()->user->checkAccess('1')),
);
?>

<h1>Benutzer aktualisieren <?php echo $model->email; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>