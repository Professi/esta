<?php
/**
 * Appointment index
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
/* @var $this AppointmentController */
/* @var $dataProvider CActiveDataProvider */
$this->setPageTitle(Yii::t('app', 'Ihre Termine'));
$this->breadcrumbs = array(
    'Appointments',
);
$this->menu = array(
    array(  'label' => Yii::t('app', 'Termine vereinbaren'), 
            'url' => array('create'), 
            'visible' => Yii::app()->user->checkAccess(MANAGEMENT),
            'linkOptions' => array('class' => 'small button')),
    array(  'label' => Yii::t('app', 'Termine verwalten'), 
            'url' => array('admin'), 
            'visible' => Yii::app()->user->checkAccess(MANAGEMENT),
            'linkOptions' => array('class' => 'small button')),
    array(  'label' => Yii::t('app','Termine im .ics Format exportieren'),
            'url' => array('exportIcs'),
            'visible' => Yii::app()->user->checkAccess(PARENTS),
            'linkOptions' => array('class' => 'small button', 'target' => '_blank'))
);
?>
<div class="row hide-for-print">
    <div class="small-12 columns">
        <h2 class="subheader"><?php echo Yii::t('app','Ihre Termine'); ?></h2>
        <hr>
        <?php if ($no_children) { ?>
            <div class="paper panel">
                <p><?php echo Yii::t('app', 'Es wurden noch keine Kinder angelegt. Ohne Kinder können keine Termine vereinbart werden.'); ?>
                    <br>
                    <?php
                    if (Yii::app()->params['allowParentsToManageChilds']) {
                        echo Yii::t('app', 'Klicken Sie {here} um Kinder anzulegen.', array('{here}' => CHtml::link(Yii::t('app', 'hier'), array('parentChild/create'))));
                    } else {
                        echo Yii::t('app', 'Klicken Sie {here} um Kinder anzulegen.', array('{here}' => CHtml::link(Yii::t('app', 'hier'), array('user/account')))) .' '. Yii::t('app', 'Sie müssen dafür nur TANs eingeben. Falls Sie über keine TAN verfügen, so wenden Sie sich bitte an die Verwaltung.');
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
<div class="hide show-for-print">
    <table>
        <thead>
            <tr>
                <th><?= Yii::t('app', 'Datum') ?></th>
                <th><?= Yii::t('app', 'Ihr Kind') ?></th>
                <th><?= Yii::t('app', 'Bei') ?></th>
                <th><?= Yii::t('app', 'In Raum') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $this->widget('zii.widgets.CListView',array(
                'dataProvider' => $dataProvider,
                'summaryText' => '',
                'itemView' => '_print'
            )); ?>
        </tbody>
    </table>
</div>