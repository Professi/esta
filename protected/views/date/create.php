<?php
/**
 * Elternsprechtag erstellen
 */
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
/* @var $this DateController */
/* @var $model Date */
$this->setPageTitle(Yii::t('app', 'Elternsprechtag anlegen'));
Yii::app()->clientScript->registerCssFile( $this->assetsDir."/css/select2.min.css");
$this->breadcrumbs = array(
    'Dates' => array('index'),
    'Create',
);
$this->menu = array(
    array(  'label' => Yii::t('app', 'Elternsprechtage verwalten'), 
            'url' => array('admin'),
            'linkOptions' => array('class' => 'small button')),
);
?>
<div class="row">
    <div class="small-12 columns">
        <fieldset>
            <legend><?php echo Yii::t('app', 'Elternsprechtag anlegen');?></legend>
            <?php
            echo $this->renderPartial('_form', array(
                'model' => $model,
                'a_disabled' => $a_disabled,
                'timeLabel' => $timeLabel,
                'dateLabel' => $dateLabel,
            ));
            ?>
        </fieldset>
    </div>
</div>