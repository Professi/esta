<?php
/**
 * Auswahl der Lehrer
 *
 * Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
 * @var $model Appointment
 * @var $date 
 * @var $columnCount
 * @var $isTab
 */


if ( ! $isTab) {
?>
<div class="<?php echo $columnCount ?> columns">
    <h4 class="subheader text-center">
        <?php 
            echo $this->formatAppointmentTitle($date[0]->date);
        ?>
    </h4>
<?php } ?>
    <table class="appointment-create-table" data-date="<?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($date[0]->date->date), 'short', null); ?>">
        <thead>
            <tr>
                <th class="text-center"><?php echo Yii::t('app','Uhrzeit'); ?></th>
                <th class="text-center"><?php echo Yii::t('app','Termin'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($date as $key => $value) {
                    $time = $this->isAppointmentAvailable($model->user->id, $date[$key]->id);
            ?>
            <tr>
                <td class="text-center">
                    <?php echo Yii::app()->dateFormatter->formatDateTime(strtotime($date[$key]->time), null, 'short'); ?>
                </td>
                <td class="<?php echo ($time[1]) ? 'avaiable' : 'occupied'; ?> text-center"
                    data-id="<?php echo $date[$key]->id; ?>">
                        <?php echo $time[0]; ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="paper panel text-center hide-for-print">
        <p>
            <?php echo Yii::t('app','Bedenken Sie, dass Termine nur bis zum {date} gebucht werden können.',
                    array('{date}' => Yii::app()->dateFormatter->formatDateTime($date[0]->date->lockAt, 'full', 'short'))
                    ); ?>
        </p>
    </div>
    <?php if ( ! $isTab) { ?>
</div>
    <?php } ?>
