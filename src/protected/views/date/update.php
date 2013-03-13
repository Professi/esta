<?php
/* @var $this DateController */
/* @var $model Date */

$this->breadcrumbs=array(
	'Dates'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Elternsprechtag anlegen', 'url'=>array('create')),
	array('label'=>'Elternsprechtag anzeigen', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Elternsprechtage verwalten', 'url'=>array('admin')),
);
?>
<div class="row">
    <div class="twelve columns">
        <fieldset>
            <legend>Elternsprechtag Nummer <?php echo $model->id; ?> bearbeiten</legend>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
            </fieldset>
    </div>
</div>