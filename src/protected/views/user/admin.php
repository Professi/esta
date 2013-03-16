<?php
/**Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
");
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Benutzerverwaltung</h2>
    </div>
</div>

<!--<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>-->

<?php //echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<!--<div class="search-form" style="display:none">-->
<?php
//    $this->renderPartial('_search', array(
//        'model' => $model,
//    ));
?>
<!--</div> search-form -->
<?php //print_r($model->search()); ?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    /**
     * @todo Suche einbauen
     */
      // 'filter' => $model, 
    'columns' => array(
        'id',
        'email',
//		'password',
//		'activationKey',
        //array('name' => 'createtime', 'value' => 'date(Yii::app()->params["dateTimeFormat"], $data->createtime)',),
        array('name' => 'firstname',),
        'lastname',
        'title',
        array('name' => 'state', 'value' => 'User::getFormattedState($data->state)'),
        array('name' => 'role', 'value' => 'User::getFormattedRole($data->userRoles->role_id)'),
         // array('header'=>'Rolle','value'=>'$data->role'),
        //'username',
        array(
            'class' => 'CustomButtonColumn',
        )
    )
));
?>
