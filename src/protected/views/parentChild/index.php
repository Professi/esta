<?php
/* @var $this ParentChildController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Parent Children',
);

$this->menu=array(
	array('label'=>'Schüler hinzufügen', 'url'=>array('create')),
	array('label'=>'Verwalte Elternkindverknüpfungen', 'url'=>array('admin'), 'visible'=>Yii::app()->user->checkAccess(1)),
);

if(Yii::app()->user->checkAccess(1)) {
    ?> <h1>Elternkindverknüpfungen</h1> <?
} else {
?>

<div class="row">
    <div class="twelve columns">
        <h2 class="subheader">Ihre Kinder</h2>
        <hr/>
         
<?php } ?>
  
  <?php  $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
        'summaryText' => '',
	'itemView'=>'_view',
)); ?>
    </div>
</div>