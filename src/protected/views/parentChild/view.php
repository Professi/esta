<?php
/**
 * Parent Child Ansicht einer Verknüpfung
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
/* @var $this ParentChildController */
/* @var $model ParentChild */
$this->setPageTitle('Konfiguration');
$this->breadcrumbs = array(
    'Parent Children' => array('index'),
    $model->id,
);
$this->menu = array(
    array('label' => 'Eltern-Kind-Verknüpfung anlegen', 'url' => array('create')),
    array('label' => 'Eltern-Kind-Verknüpfung löschen', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Sind Sie sich sicher, dass Sie diese Verknüpfung löschen möchten?')),
    array('label' => 'Eltern-Kind-Verknüpfungen verwalten', 'url' => array('admin')),
);
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Eltern-Kind-Verknüpfung Nummer <?php echo $model->getPrimaryKey(); ?></h2>
    </div>
</div>
<div class="row">
    <div class="twelve columns centered">
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                array('name' => 'user_id', 'value' => $model->user->firstname . " " . $model->user->lastname),
                array('name' => 'child_id', 'value' => $model->child->firstname . " " . $model->child->lastname),
            ),
        ));
        ?>
    </div>
</div>