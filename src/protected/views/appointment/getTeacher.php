<?php
/* @var $this AppointmentController */
/* @var $model User */

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'appointment-grid',
    'dataProvider' => $dataProvider,
    /**
     * @todo Suche einbauen
     */
    //   'filter' => $model, 
    'columns' => array(
        array('name' => 'firstname',),
        'lastname',
        'title',
        array(
            'class' => 'CButtonColumn', //ändern für zB. Termin vereinbaren
        )
    )
));
?>
