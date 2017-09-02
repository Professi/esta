<?php
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
/**
 * @var $this AppointmentController
 * @var $data[time|status|text]
 * @var $teacher
 * @var $date
 */
$this->setPageTitle(Yii::t('app', 'Terminübersicht'));

$this->menu = array(
    array('label' => Yii::t('app', 'Termine verwalten'),
        'url' => array('admin'),
        'visible' => (Yii::app()->user->checkAccess(MANAGEMENT)),
        'linkOptions' => array('class' => 'small button'))
);
$roomOutput = (isset($room) && !empty($room) ? ' ' . Yii::t('app', 'in Raum') . ' ' . $room->name : '')
?>
<div class="row">
    <div class="small-12 columns">
        <h4 class="subheader">
            <?php echo Yii::t('app', 'Termine für') . " {$teacher} " . Yii::t('app', 'am') . " {$date}" . " {$roomOutput}"; ?>
        </h4>
        <hr>
        <table>
            <thead>
                <tr>
                    <th class="text-center"><?php echo Yii::t('app', 'Uhrzeit'); ?></th>
                    <th class="text-center"><?php echo Yii::t('app', 'Termin'); ?></th>
                    <th class="text-center"><?php echo Yii::t('app', 'Mit / Grund'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $show) { ?>
                    <tr>
                        <td class="text-center">
                            <?php echo $show['time']; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $show['status']; ?>
                        </td>
                        <td class="text-center">
                            <?php echo $show['text']; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
