<br/>
<?php
/* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/* @var $this DateController */
/* @var $model DateHasGroup */
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'dateHasGroup-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array('name' => 'date', 'value' => 'Yii::app()->dateFormatter->formatDateTime(strtotime($data->date->date), "short", null)', 'headerHtmlOptions' => array('style' => 'width: 45%;')),
        array('name' => 'group', 'value' => '$data->group->groupname', 'headerHtmlOptions' => array('style' => 'width: 45%;')),
        array('class' => 'CustomButtonColumn', 'template' => '{update} {delete}',
            'buttons' => array(
                'delete' => array(
                    'url' => '$this->grid->controller->createUrl("/group/deleteDateGroup", array("id"=>$data->id))'
                ),
                'update' => array(
                    'url' => '$this->grid->controller->createUrl("/date/update", array("id"=>$data->date->id))'
                )
            ),
            'headerHtmlOptions' => array('style' => 'text-align:center;width: 10%;')
        ),
    )
));
?>