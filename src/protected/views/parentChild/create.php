<?php
/* @var $this ParentChildController */
/* @var $model ParentChild */

$this->breadcrumbs=array(
	'Parent Children'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Liste der Schüler', 'url'=>array('index')),
	array('label'=>'Elternkinderverknüpfungsverwaltung', 'url'=>array('admin'), 'visible'=>Yii::app()->user->checkAccess(1)),
);
?>

<h1>Create ParentChild</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>