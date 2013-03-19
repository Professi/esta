<?php
/**   Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 *   This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/* @var $this AppointmentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Appointments',
);

$this->menu=array(
	array('label'=>'Termine vereinbaren', 'url'=>array('create'),'visible' => Yii::app()->user->checkAccess('1')),
	array('label'=>'Termin Manage', 'url'=>array('admin'),'visible' => Yii::app()->user->checkAccess('1')),
);
?>
<div class="row">
    <div class="twelve columns">
        <h2 class="subheader">Ihre Termine</h2>
        <hr>
        

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
        'summaryText'=>'',
	'itemView'=>'_view',
        
)); ?>
        <span id="print_button" class="nav-icons small button js_show" aria-hidden="true" data-icon="&#xe001;" onClick="window.print();">&nbsp;Drucken</span>
    </div>
</div>
