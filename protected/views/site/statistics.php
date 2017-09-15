<?php
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
$this->setPageTitle(Yii::t('app', 'Statistik'));
$this->breadcrumbs = array(
    'Error',
);
?>
<div class="row">
    <div class="small-12 columns small-centered text-center">
        <h2><?php echo Yii::t('app', 'Statistik') ?></h2>
        <table class="center">
            <tbody>
                <tr>
                    <td><?php echo Yii::t('app', 'Eingetragene Lehrer');?></td>
                    <td><?php echo $teachers;?></td>
                </tr>
                <tr>
                    <td><?php echo Yii::t('app', 'Registrierte Eltern');?></td>
                    <td><?php echo User::model()->countByAttributes(array('role' => 3));?></td>
                </tr>
                <tr>
                    <td><?php echo Yii::t('app', 'Eingetragene Schüler');?></td>
                    <td><?php echo Child::model()->count();?></td>
                </tr>
                <tr>
                    <td><?php echo Yii::t('app', 'Eingetragene Elternsprechtage');?></td>
                    <td><?php echo Date::model()->count();?></td>
                </tr>
                <tr>
                    <td><?php echo Yii::t('app', 'Vergebene Termine');?></td>
                    <td><?php echo $apps;?></td>
                </tr>
                <tr>
                    <td><?php echo Yii::t('app', 'Freie Termine');?></td>
                    <td><?php echo $freeApps;?></td>
                </tr>
                <?php if (!Yii::app()->user->isGuest()) {
    ?>
                <tr>
                    <td><?php echo Yii::t('app', 'Generierte TANs'); ?></td>
                    <td><?php echo Tan::model()->count(); ?></td>
                </tr>
                <?php
} ?>
            </tbody>
        </table>
        
    </div>
        <p class="text-center">
        <?php echo CHtml::link('<b>' . Yii::t('app', 'Zurück zur Startseite') . '</b>', 'index.php');?> 
        </p>
</div>
