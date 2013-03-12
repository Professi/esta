<?php
/* @var $this AppointmentController */
/* @var $data Appointment */
?>

<div class="view">
<?php //hier deine Methoden      array('name' => 'Lehrer', 'value' => data->user->firstname . " " . $data->user->lastname), ?>  
        
	<b><?php echo CHtml::encode("um"); ?>:</b>
	<?php  echo CHtml::link(CHtml::encode($data->time), array('view', 'id'=>$data->id));//echo CHtml::encode($data->time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_id')); ?>:</b>
	<?php echo CHtml::encode($data->date_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent_child_id')); ?>:</b>
	<?php echo CHtml::encode($data->parent_child_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />


</div>