<?php
/**
 * Appointment aktualisieren
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
/* @var $this AppointmentController */
/* @var $model Appointment */
$this->setPageTitle('Termin bearbeiten');
$this->breadcrumbs = array(
    'Appointments' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);
$this->menu = array(
    array('label' => 'Termin anlegen', 'url' => array('create')),
    array('label' => 'Termin anzeigen', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Termine verwalten', 'url' => array('admin')),
);
?>
<div class="row">
    <div class="twelve columns centered">
        <fieldset>
            <legend>Termin Nummer <?php echo $model->id; ?> bearbeiten</legend>
            <?php
            echo $this->renderPartial('_form', array(
                'model' => $model,
                'teacherLabel' => $teacherLabel,
                'parentLabel' => $parentLabel,
                'parentId' => $parentId,
            ));
            ?>
        </fieldset>
    </div>
</div>