<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create User', 'url'=>array('create'), 'visible'=>!Yii::app()->user->isGuest),
	array('label'=>'View User', 'url'=>array('view', 'id'=>$model->id),),
	array('label'=>'Manage User', 'url'=>array('admin'), 'visible'=>!Yii::app()->user->isGuest),
);
?>

<h1>Update User <?php echo $model->email; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>