<?php
/* @var $this ParentChildController */
/* @var $data ParentChild */
?>

<div class="view">
       <ul class="square">

    <li>
	<?php echo CHtml::encode($data->child->firstname." ".$data->child->lastname); ?>
    </li>

        </ul>

</div>