<?php
/**
 * Anzeige der generierten TANs
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
/* @var $this TanController */
/* @var $model tan */
$this->setPageTitle('Generierte TAN\'s');
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Generierte TAN's</h2>
    </div>
</div>
<div class="row">
    <div class="five columns centered">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $dataProvider,
            'columns' => array(
                array('name' => 'TAN', 'value' => '$data->tan',),
                array('name' => 'Vorname', 'value' => '$data->child->firstname', 'visible' => !Yii::app()->params['allowParentsToManageChilds']),
                array('name' => 'Nachname', 'value' => '$data->child->lastname', 'visible' => !Yii::app()->params['allowParentsToManageChilds']),
            )
        ));
        ?>
    </div>
</div>