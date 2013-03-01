<?php
/* @var $this ParentsController */
/* @var $data Parents */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_parents')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_parents), array('view', 'id'=>$data->id_parents)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent1')); ?>:</b>
	<?php echo CHtml::encode($data->parent1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent2')); ?>:</b>
	<?php echo CHtml::encode($data->parent2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pw')); ?>:</b>
	<?php echo CHtml::encode($data->pw); ?>
	<br />


</div>