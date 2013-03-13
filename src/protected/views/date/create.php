<?php
/* @var $this DateController */
/* @var $model Date */

$this->breadcrumbs=array(
	'Dates'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Elternsprechtage verwalten', 'url'=>array('admin')),
);
?>
<div class="row">
    <div class="twelve columns">
        <fieldset>
            <legend>Elternsprechtag anlegen</legend>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </fieldset>
    </div>
</div>