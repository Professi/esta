<?php
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
$this->setPageTitle(Yii::t('app', 'Statistik'));
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
                <div class="eleven columns offset-by-one">
                    <h2><?php echo Yii::t('app', 'Statistik') ?></h2>
                    <ul class="faq-ul">
                        <li><?php echo Yii::t('app', 'Eingetragene Lehrer') . ':' . $teachers; ?> </li>
                        <li><?php echo Yii::t('app', 'Registrierte Eltern') . ':' . UserRole::model()->countByAttributes(array('role_id' => 3)); ?> </li>
                        <li><?php echo Yii::t('app', 'Eingetragene Sch&uuml;ler') . ':' . Child::model()->count(); ?> </li>
                        <li><?php echo Yii::t('app', 'Eingetragene Elternsprechtage') . ':' . Date::model()->count(); ?> </li>
                        <li><?php echo Yii::t('app', 'Vergebene Termine') . ':' . $apps; ?> </li>
                        <li><?php echo Yii::t('app', 'Freie Termine') . ':' . $freeApps ?> </li>
                        <?php if (!Yii::app()->user->isGuest()) { ?>
                            <li><?php echo Yii::t('app', 'Generierte TANs') . ':' . Tan::model()->count(); ?> </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <p class="text-center"><?php
            echo CHtml::link('<b>' . Yii::t('app', 'Zur&uuml;ck zur Startseite') . '</b>', 'index.php');
            ?> </p>
    </div>
</div>