<?php
/**   Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 *   This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
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
