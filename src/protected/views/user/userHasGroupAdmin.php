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
/* @var $this UserController */
/* @var $model UserHasGroup */
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'userHasGroup-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array('name' => 'user', 'value' => '$data->user->firstname . " " . $data->user->lastname','headerHtmlOptions' => array('style' => 'width: 45%;')),
        array('name' => 'group', 'value' => '$data->group->groupname','headerHtmlOptions' => array('style' => 'width: 45%;')),
        array('class' => 'CustomButtonColumn', 'template' => '{update} {delete}', 
                'buttons' => array(
                    'delete' => array(
                        'url' => '$this->grid->controller->createUrl("/group/deleteUserGroup", array("id"=>$data->id))'
                    ),
                    'update' => array(
                        'url' => '$this->grid->controller->createUrl("/user/update", array("id"=>$data->user->id))'
                    )
                ),
            'headerHtmlOptions' => array('style' => 'text-align:center;width: 10%;')
            ),
    )
));
?>