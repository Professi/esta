<?php
/**
 * Appointment index
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
/* @var $dataProvider CActiveDataProvider */
$this->setPageTitle('Ihre Termine');
$this->breadcrumbs = array(
    'Appointments',
);
$this->menu = array(
    array('label' => 'Termine vereinbaren', 'url' => array('create'), 'visible' => Yii::app()->user->checkAccess('1')),
    array('label' => 'Termine verwalten', 'url' => array('admin'), 'visible' => Yii::app()->user->checkAccess('1')),
);
?>
<div class="row">
    <div class="twelve columns">
        <h2 class="subheader">Ihre Termine</h2>
        <hr>
        <?php if ($no_children) { ?>
            <div class="panel">
                <p><?php echo Yii::t('app', 'Es wurden noch keine Kinder angelegt. Ohne Kinder können keine Termine vereinbart werden.'); ?>
                    <br>
                    <?php
                    if (Yii::app()->params['allowParentsToManageChilds']) {
                        echo Yii::t('app', 'Klicken Sie ') . CHtml::link(Yii::t('app', 'hier'), array('parentChild/create')) . Yii::t('app', 'um Kinder anzulegen.');
                    } else {
                        echo Yii::t('app', 'Klicken Sie ') . CHtml::link(Yii::t('app', 'hier'), array('user/account')) . ' ' . Yii::t('app', 'um Kinder anzulegen.') . Yii::t('app', 'Sie müssen dafür nur TANs eingeben. Falls Sie über keine TAN verfügen, so wenden Sie sich bitte an die Verwaltung.');
                    }
                    ?>
                </p>
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
