<?php
/* @var $this RoomController */
/* @var $model Room */
$this->setPageTitle(Yii::t('app', 'Raum bearbeiten'));
$this->breadcrumbs=array(
    'Rooms'=>array('index'),
    $model->name=>array('view','id'=>$model->id),
    'Update',
);

$this->menu = array(
    array(  'label' => Yii::t('app', 'Raum anlegen'),
            'url' => array('create'),
            'linkOptions' => array('class' => 'small button')),
    array(  'label' => Yii::t('app', 'Raum anzeigen'),
            'url' => array('view', 'id' => $model->id),
            'linkOptions' => array('class' => 'small button')),
    array(  'label' => Yii::t('app', 'Räume verwalten'),
            'url' => array('admin'),
            'linkOptions' => array('class' => 'small button')),
);
?>

<div class="row">
    <div class="small-12 columns">
        <fieldset>
            <legend><?php echo Yii::t('app', 'Raum {name} bearbeiten', array('{name}' => $model->name)); ?></legend>
            <?php
            echo $this->renderPartial('_form', array(
                'model' => $model,
            ));
            ?>
        </fieldset>
    </div>
</div>
