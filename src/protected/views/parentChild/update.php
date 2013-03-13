<?php
/* @var $this ParentChildController */
/* @var $model ParentChild */

$this->breadcrumbs=array(
	'Parent Children'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Eltern-Kind-Verknüpfung anlegen', 'url'=>array('create')),
	array('label'=>'Eltern-Kind-Verknüpfung anzeigen', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Eltern-Kind-Verknüpfungen verwalten', 'url'=>array('admin')),
);
?>
<div class="row">
    <div class="twelve columns centered">
        <fieldset>
            <legend>Eltern-Kind-Verknüpfung Nummer <?php echo $model->id; ?> bearbeiten</legend>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </fieldset>
    </div>
</div>