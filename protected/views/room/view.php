<?php
/* @var $this RoomController */
/* @var $model Room */

$this->breadcrumbs=array(
	'Rooms'=>array('index'),
	$model->name,
);

$this->menu = array(
    array('label' => Yii::t('app', 'Raum bearbeiten'),
        'url' => array('update', 'id' => $model->id),
        'linkOptions' => array('class' => 'small button')),
    array('label' => Yii::t('app', 'Raum löschen'),
        'url' => '#',
        'linkOptions' => array('submit' => array('delete', 'id' => $model->id),
            'confirm' => Yii::t('app', 'Möchten Sie diesen Raum wirklich löschen?'),
            'class' => 'small button',
            'csrf'=>true)),
    array('label' => Yii::t('app', 'Räume verwalten'),
        'url' => array('admin'),
        'linkOptions' => array('class' => 'small button')),
);
$this->setPageTitle(Yii::t('app', 'Detailansicht Raum'));
?>
<div class="row">
    <div class="small-12 columns small-centered">
        <h2 class="text-center"><?php echo Yii::t('app', 'Raum {name}', array('{name}' => $model->name)); ?></h2>
    </div>
</div>
<div class="row">
    <div class="small-12 columns small-centered">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
	),
)); ?>
    </div>
</div>
