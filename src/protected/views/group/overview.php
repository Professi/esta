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
/* @var $this GroupController */
/* @var $model Group */
$this->menu = array(
    array('label' => Yii::t('app','Gruppe erstellen'), 'url' => array('create')),
);
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'group-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        'groupname',
        array(
            'class' => 'CustomButtonColumn',
            'template' => '{update} {delete}',
            'headerHtmlOptions' => array('style' => 'text-align:center;width: 10%;'),
        ),
    ),
));
echo CHtml::link(Yii::t('app', 'Gruppe erstellen'), array('create'), array('class' => 'small button'));
?>