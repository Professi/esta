<?php
/**
 * View für die Lehrerterminübersicht
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
/* @var $data Appointment */
$this->setPageTitle(Yii::t('app', 'Ihre Termine'));
$this->menu = array(
    array('label' => Yii::t('app', 'Termine im .ics Format exportieren'),
        'url' => array('exportIcs'),
        'linkOptions' => array('class' => 'small button'))
);
?>
<div class="row">
    <div class="small-12 columns">
        <h2 class="subheader">Ihre Termine</h2>
        <hr>
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'appointment-grid',
            'dataProvider' => $dataProvider,
            'columns' => array(
                array('name' => 'dateAndTime_id',
                    'value' => 'Yii::app()->dateFormatter->formatDateTime(strtotime($data->dateandtime->date->date . $data->dateandtime->time), "short", "short")'),
                array('name' => 'Titel',
                    'value' => '$data->dateandtime->date->title',
//                    'visible' => !empty($data->dateandtime->date->title)
                ),
                array('name' => 'parent_child_id',
                    'value' => '$data->parentchild->user->firstname." ".$data->parentchild->user->lastname'),
                array('name' => 'child',
                    'value' => '$data->parentchild->child->firstname." ".$data->parentchild->child->lastname'),
                                array('name' => 'contact',
                    'value' => '$data->parentchild->user->email'),
                array(
                    'class' => 'CustomButtonColumn',
                    'template' => '{delete}'
                ),
            )
        ));
        ?>
        <div class="push"></div>
        <ul class="button-group hide-for-print">
            <?php
            foreach ($dates as $date) {
                $desc = Yii::app()->dateFormatter->formatDateTime(strtotime($date->date), 'short', null);
                $desc .= (empty($date->title)) ? '' : " ({$date->title})";
                echo '<li>' . CHtml::link(Yii::t('app', 'Druckansicht für den {date}', array('{date}' => $desc)), array('appointment/overview', 'id' => Yii::app()->user->id, 'date' => $date->id), array('class' => 'small button')) . '</li>';
            }
            ?>
        </ul>
        <div class="push"></div>
    </div>
</div>

<?php if (Yii::app()->params['allowBlockingAppointments']) {
                ?>
    <div class="row">
        <div class="small-12 columns">
            <h2 class="subheader"><?php echo Yii::t('app', 'Ihre blockierten Termine'); ?></h2>
            <hr>
            <?php if (Yii::app()->params['allowBlockingOnlyForManagement']) {
                    ?>

                <div class="paper panel">
                    <p><?php echo Yii::t('app', 'Termine können zurzeit nur von der Verwaltung und der Administration blockiert werden.'); ?></p>
                </div>

                <?php
                }
                $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'blockedAppointment-grid',
                'dataProvider' => $blockedApp,
                'columns' => array(
                    array('name' => 'dateAndTime_id', 'value' => 'Yii::app()->dateFormatter->formatDateTime(strtotime($data->dateandtime->date->date . $data->dateandtime->time), "short", "short")'),
                    array('name' => 'reason'),
                    array('class' => 'CustomButtonColumn', 'template' => '{delete}', 'buttons' => array(
                            'delete' => array('url' => '$this->grid->controller->createUrl("/appointment/deleteblockapp", array("id"=>$data->id))'),
                        )),
                )
            )); ?>
        </div>
    </div>
    <br/>
    <?php
            }
if (UserHasRoom::model()->countByAttributes(array('user_id' => Yii::app()->user->getId())) > 0) {
    ?>
    <div class="row">
        <div class="small-12 columns">
            <h2 class="subheader"><?php echo Yii::t('app', 'Ihre Räume'); ?></h2>
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'rooms-grid',
                'dataProvider' => $rooms,
                'columns' => array(
                    array('name' => 'date_id', 'value' => '$data->date->title'),
                    array('name' => 'room_id', 'value' => '$data->room->name'),
                )
            )); ?> 
        </div>
    </div>
    <?php
}
?>

