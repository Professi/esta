<?php
/* @var $this AppointmentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Appointments',
);

$this->menu=array(
	array('label'=>'Termine vereinbaren', 'url'=>array('create'),'visible' => Yii::app()->user->checkAccess('1')),
	array('label'=>'Termin Manage', 'url'=>array('admin'),'visible' => Yii::app()->user->checkAccess('1')),
);
?>
<div class="row">
    <div class="twelve columns">
        <h2 class="subheader">Ihre Termine</h2>
        <hr>
        

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
        'summaryText'=>'',
	'itemView'=>'_view',
        
)); ?>
    </div>
</div>
