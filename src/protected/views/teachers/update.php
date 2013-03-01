<?php
/* @var $this TeachersController */
/* @var $model Teachers */

$this->breadcrumbs=array(
	'Teachers'=>array('index'),
	$model->id_teacher=>array('view','id'=>$model->id_teacher),
	'Update',
);

$this->menu=array(
	array('label'=>'List Teachers', 'url'=>array('index')),
	array('label'=>'Create Teachers', 'url'=>array('create')),
	array('label'=>'View Teachers', 'url'=>array('view', 'id'=>$model->id_teacher)),
	array('label'=>'Manage Teachers', 'url'=>array('admin')),
);
?>

<h1>Update Teachers <?php echo $model->id_teacher; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>