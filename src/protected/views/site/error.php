<?php
/**
 * Errorseite
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
/* @var $this SiteController */
/* @var $error array */
$this->pageTitle = Yii::app()->name . ' - Error';
$this->breadcrumbs = array(
    'Error',
);
?>
<div class="row">
    <div class="twelve columns">
        <div class="push hide-for-small"></div>
        <div class="push hide-for-small"></div>
        <div class="panel">
            <div class="row">
                <div class="two columns text-center">
                    <span aria-hidden="true" data-icon="&#xe005;" style="font-size:6em;"></span>
                </div>
                <div class="ten columns">
                    <h2>Fehler <?php echo $code; ?></h2>   
                    <?php echo CHtml::encode($message); ?>
                </div>
            </div>
            
        </div>
        <p class="text-center"><?php
            echo CHtml::link('<b>Zurück zur Startseite</b>', Yii::app()->user->checkAccess('1') == TRUE ? 'index.php' :
                            'index.php?r=Appointment/index');
            ?> </p>
    </div>
</div>

