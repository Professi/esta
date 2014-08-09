<?php
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
/* @var $this GroupController */
$this->setPageTitle( 'Gruppenverwaltung');
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Gruppenverwaltung</h2>
    </div>
</div>
    <?php
    $this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>array(
        Yii::t('app', 'Existierende Gruppen')=>array('ajax'=>$this->createAbsoluteUrl('Group/overview')),
        Yii::t('app', 'Elternsprechtage und Gruppen')=>array('ajax'=>$this->createAbsoluteUrl('Date/dateHasGroupAdmin')),
        Yii::t('app', 'Benutzer und Gruppen')=>array('ajax'=>$this->createAbsoluteUrl('User/userHasGroupAdmin'))
    ),
    'options'=>array(
    ),
));
?>