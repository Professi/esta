<?php
/**
 * Errorseite
 */
/* * Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
$this->setPageTitle(Yii::t('app', 'Fehler'));
$this->breadcrumbs = array(
    'Error',
);
?>
<div class="push"></div>
<div class="push"></div>
<div class="row">
    <div class="small-8 columns small-centered">
        <div class="panel">
            <div class="row">
                <div class="small-2 columns text-center">
                    <i class="fi-alert callout-icon"></i>
                </div>
                <div class="small-10 columns">
                    <h2><?php echo Yii::t('app', 'Fehler') . ' ' . $code; ?></h2>   
                    <?php echo CHtml::encode($message); ?>
                </div>
            </div>
            
        </div>
        <p class="text-center"><?php
            echo CHtml::link('<b>' . Yii::t('app', 'Zurück zur Startseite') . '</b>', Yii::app()->user->checkAccess(MANAGEMENT) == true ? 'index.php' :
                            'index.php?r=Appointment/index');
            ?> </p>
    </div>
</div>

