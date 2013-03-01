<?php
/* @var $this TeachersController */
/* @var $data Teachers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_teacher')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_teacher), array('view', 'id'=>$data->id_teacher)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firstName')); ?>:</b>
	<?php echo CHtml::encode($data->firstName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastName')); ?>:</b>
	<?php echo CHtml::encode($data->lastName); ?>
	<br />


</div>