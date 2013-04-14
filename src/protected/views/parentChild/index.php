<?php
/**
 * Anzeige der eingetragenen Kinder eines Benutzers
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
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs = array(
    'Parent Children',
);
$this->menu = array(
    array('label' => 'Kind hinzufügen', 'url' => array('create')),
    array('label' => 'Verwalte Elternkindverknüpfungen', 'url' => array('admin'), 'visible' => Yii::app()->user->checkAccess(1)),
);
if (Yii::app()->user->checkAccess(1)) {
    ?> <h1>Elternkindverknüpfungen</h1> <?
} else {
    ?>
    <div class="row">
        <div class="twelve columns">
            <h2 class="subheader">Ihre Kinder</h2>
            <hr/>
            <div class="panel hide-for-print">
                Falls Sie bei der Eingabe ihrer Kinder einen Fehler gemacht haben sollten, 
                drücken Sie einfach auf das "x" neben dem Namen. 
                Der Eintrag wird daraufhin entfernt und Sie können eine neue Eingabe über "Kind hinzufügen" tätigen.
            </div>
            <?php
        }
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'summaryText' => '',
            'itemView' => '_view',
        ));
        ?>
    </div>
</div>