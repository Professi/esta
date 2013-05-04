<?php
/**
 * View Benutzerverwaltung
 */
/* * Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
/* @var $model User */
$this->breadcrumbs = array(
    'Users' => array('index'),
    'Manage',
);
$this->menu = array(
    array('label' => 'Benutzer erstellen', 'url' => array('create')),
    array('label' => 'Pseudobenutzer erstellen', 'url' => array('createDummy')),
    array('label' => 'Lehrer importieren', 'url' => array('importTeachers')),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
", CClientScript::POS_READY);
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Benutzerverwaltung</h2>
    </div>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array('name' => 'username', 'header' => 'E-Mail'),
        array('name' => 'firstname',),
        'lastname',
        //       array('name' => 'title', 'htmlOptions' => array('width' => '5%')), //nicht wirklich wichtig für die Verwaltung
        /**
         * @todo Gruppen anzeigen
         */
        array('name' => 'group', 'value' => 'User::getGroupname($data->group)', 'visible' => Yii::app()->params['allowGroups']),
        array('name' => 'state',
            'value' => 'User::getFormattedState($data->state)',
            'filter' => CHtml::listData(
                    User::getStateNameAndValue(), 'value', 'name'),
        ),
        array('name' => 'role',
            'value' => 'User::getFormattedRole($data->userRole->role_id)',
            'filter' => CHtml::listData(Role::model()->findAll(), 'id', 'title')),
        array(
            'class' => 'CustomButtonColumn',
            'htmlOptions' => array('width' => '10%', 'style' => 'text-align:center;')
        )
    )
));
?>
