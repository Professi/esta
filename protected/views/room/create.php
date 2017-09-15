<?php
/* @var $this RoomController */
/* @var $model Room */

$this->breadcrumbs=array(
    'Rooms'=>array('index'),
    'Create',
);

$this->menu=array(
    array(  'label' => Yii::t('app', 'Räume verwalten'),
            'url' => array('admin'),
            'linkOptions' => array('class' => 'small button')),
);
$this->setPageTitle(Yii::t('app', 'Elternsprechtag anlegen'));
?>

<div class="row">
    <div class="small-12 columns">
        <fieldset>
            <legend><?php echo Yii::t('app', 'Raum anlegen');?></legend>
            <?php
            echo $this->renderPartial('_form', array(
                'model' => $model,
            ));
            ?>
        </fieldset>
    </div>
</div>