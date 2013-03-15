<?php
/* @var $this AppointmentController */
/* @var $model User */
?>
<div class="row">
        <div class="twelve columns centered">
                <div class="panel">
                        <p>	Klicken Sie auf einen Buchstaben um sich alle Lehrer anzeigen zu lassen.<br> 
                                Drücken Sie auf den Stern um eine Liste mit allen Lehrer zu erhalten.<br>
                                Sie können alternativ auch den Namen in das Suchfeld eingeben um alle zutreffenden Möglichkeiten zu sehen.<br>
                                Wenn Sie den richtigen Lehrer gefunden haben, 
                                klicken Sie einfach auf seinen Namen um zu der Terminvereinbarung des Lehres zu gelangen.
                        </p>
                </div>
<?php
$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
    'name'=>'teacher-ac',
    //'source'=>$dataProvider,
    // additional javascript options for the autocomplete plugin
    'sourceUrl'=>'index.php?r=user/search',
    'options'=>array(
        'minLength'=>'2',
    ),
    'htmlOptions'=>array(
        //'style'=>'height:20px;',
    ),
));


$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'teacher-grid',
    'dataProvider' => $dataProvider->searchTeacher(),
    /**
     * @todo Suche einbauen
     */
    //   'filter' => $dataProvider, 
    'columns' => array(
        'title',
        'firstname',
        'lastname',        
        array(
            'class' => 'CustomButtonColumn', //ändern für zB. Termin vereinbaren
            'template' => '{date}',
            'buttons' => array(
                'date' => array(
                    'label' => 'Termin vereinbaren',
                    'imageUrl' => Yii::app()->request->baseUrl.'/img/alarm.svg',
                    'options' => array('class' => 'column-button')
                ),
            ),
        ),
    )
));
?>
        </div>
</div>
