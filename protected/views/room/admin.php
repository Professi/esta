<?php
/* @var $this RoomController */
/* @var $model Room */

$this->breadcrumbs=array(
	'Rooms'=>array('index'),
	'Manage',
);

$this->menu=array(
    array(  'label' => Yii::t('app', 'Raum anlegen'), 
            'url' => array('create'),
            'linkOptions' => array('class' => 'small button')),
    array(  'label' => Yii::t('app', 'Räume mit Lehrern verknüpfen'), 
            'url' => array('assignall'),
            'linkOptions' => array('class' => 'small button')),
);
$this->setPageTitle(Yii::t('app', 'Raumverwaltung'));

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#room-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="row">
    <div class="small-12 columns small-centered">
        <h2 class="text-center"><?php echo Yii::t('app', 'Raumverwaltung'); ?></h2>
    </div>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'room-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
            'name',
            array(
                'class' => 'CustomButtonColumn',
                'template' => '{update} {delete}',
            ),
	),
)); ?>
<div class="push"></div>
    <div class="row">
        <div class="small-12 columns small-centered">
            <h2 class="text-center"><?php echo Yii::t('app', 'Lehrerräume'); ?></h2>
        </div>
    </div>
<div>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'userrooms-grid',
        'dataProvider' => $user_rooms->search(),
        'filter' => $user_rooms,
        'columns' => array(
            array('name' => 'room_id', 'value' => '$data->room->name'),
            array('name' => 'user_id', 'value' => '$data->user->title." ".$data->user->firstname." ".$data->user->lastname'),
            array('name' => 'date_id', 'value' => 'Yii::app()->dateFormatter->formatDateTime(strtotime($data->date->date), "short", null)." ({$data->date->title})"',
                'filter' => CHtml::listData(Date::filterDate(), 'value', 'name')
                 ),
            array(
                'class' => 'CustomButtonColumn',
                'template' => '{delete}',
            ),
        ),
    ));
?>
    </div>
<div class="push"></div>
<?php 
    $this->renderPartial('assign',['dates'=>$dates]);