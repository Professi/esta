<?php
/* @var $this ParentsPupilsController */
/* @var $data ParentsPupils */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_parents_pupils')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_parents_pupils), array('view', 'id'=>$data->id_parents_pupils)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_parents')); ?>:</b>
	<?php echo CHtml::encode($data->id_parents); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_pupil')); ?>:</b>
	<?php echo CHtml::encode($data->id_pupil); ?>
	<br />


</div>