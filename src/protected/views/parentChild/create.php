<?php
/* @var $this ParentChildController */
/* @var $model ParentChild */

$this->breadcrumbs=array(
	'Parent Children'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Liste der Schüler', 'url'=>array('index'),'visible'=>Yii::app()->user->checkAccess(1)),
	array('label'=>'Eltern-Kind-Verknüpfungen verwalten', 'url'=>array('admin'), 'visible'=>Yii::app()->user->checkAccess(1)),
);
?>
<div class="row">
    <div class="twelve columns centered">
        <fieldset>
            <?php if (Yii::app()->user->checkAccess('3')) { ?>
            <legend>Kind anlegen</legend>
            <?php } else { ?>
            <legend>Eltern-Kind-Verknüpfung anlegen</legend>
            <?php } ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
        </fieldset>
    </div>
</div>