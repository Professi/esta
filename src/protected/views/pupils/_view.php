<?php
/* @var $this PupilsController */
/* @var $data Pupils */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_pupil')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_pupil), array('view', 'id'=>$data->id_pupil)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firstname')); ?>:</b>
	<?php echo CHtml::encode($data->firstname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastname')); ?>:</b>
	<?php echo CHtml::encode($data->lastname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_schoolclass')); ?>:</b>
	<?php echo CHtml::encode($data->id_schoolclass); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bDay')); ?>:</b>
	<?php echo CHtml::encode($data->bDay); ?>
	<br />


</div>