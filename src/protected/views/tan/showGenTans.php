<?php
/* @var $this TanController */
/* @var $model tan */
?>


<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'columns'=>array(
        'tan',
    )
));
?>
