<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'Benutzer erstellen', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Benutzerverwaltung</h1>

<!--<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>-->

<?php //echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<!--<div class="search-form" style="display:none">-->
    <?php
//    $this->renderPartial('_search', array(
//        'model' => $model,
//    ));
    ?>
<!--</div> search-form -->
<?php //print_r($model->search()); ?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    /**
     * @todo Suche einbauen
     */
 //   'filter' => $model, 
    'columns' => array(
        'id',
        'email',
//		'password',
//		'activationKey',
        array('name'=>'createtime','value'=>'date(Yii::app()->params["dateTimeFormat"], $data->createtime)',),
        array('name'=>'firstname',),
        'lastname',
        'state',
        'userRoles.role_id.title',
      //  array('header'=>'Rolle','value'=>'$data->role'),
        //'username',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
