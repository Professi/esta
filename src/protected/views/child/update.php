<?php
/* @var $this ChildController */
/* @var $model Child */

$this->breadcrumbs=array(
	'Children'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Schüler anlegen', 'url'=>array('create')),
	array('label'=>'Schüler anzeigen', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Schüler verwalten', 'url'=>array('admin')),
);
?>
<div class="row">
    <div class="twelve columns centered">
        <fieldset>
            <legend>Schüler Nummer <?php echo $model->id; ?> bearbeiten</legend>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </fieldset>
    </div>
</div>