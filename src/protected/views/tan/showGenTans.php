<?php
/* @var $this TanController */
/* @var $model tan */
?>

<div class="row">
    <div class="five columns centered">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        'tan',
    )
));
?>
    </div>
</div>