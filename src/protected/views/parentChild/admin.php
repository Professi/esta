<?php
/**
 * View ParentChild Verwaltung
 */
/* Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
/* @var $this ParentChildController */
/* @var $model ParentChild */
$this->setPageTitle(Yii::t('app', 'Eltern-Kind Verwaltung'));

$this->breadcrumbs = array(
    'Parent Children' => array('index'),
    'Manage',
);
$this->menu = array(
    array('label' => Yii::t('app', 'Eltern-Kind-Verknüpfung anlegen'), 'url' => array('create')),
);
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center"><?php echo Yii::t('app', 'Eltern-Kind-Verknüpfung'); ?></h2>
    </div>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'parent-child-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array('name' => 'user_id', 'value' => '$data->user->firstname." ".$data->user->lastname'),
        array('name' => 'child_id', 'value' => '$data->child->firstname." ".$data->child->lastname'),
        array(
            'class' => 'CustomButtonColumn',
            'template' => '{update} {delete}',
        ),
    ),
));
?>
