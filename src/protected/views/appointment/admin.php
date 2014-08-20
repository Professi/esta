<?php
/**
 * Terminverwaltung
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
/**
 *  @var $this AppointmentController 
 *  @var $model Appointment 
 *  @var $blockedApp BlockedAppointment 
 *  @var $dates 
 */
$this->setPageTitle(Yii::t('app', 'Terminverwaltung'));
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerCssFile( $this->assetsDir."/css/select2.min.css");
$this->breadcrumbs = array(
    'Appointments' => array('index'),
    'Manage',
);
$this->menu = array(
    array(  'label' => Yii::t('app', 'Termin anlegen'), 
            'url' => array('create'),
            'linkOptions' => array('class' => 'small button')),
    array(  'label' => Yii::t('app', 'Termin blockieren'), 
            'url' => array('createBlockApp'), 
            'visible' => (Yii::app()->params['allowBlockingAppointments']),
            'linkOptions' => array('class' => 'small button')),
);
?>

<div class="row">
    <div class="small-12 columns small-centered">
        <h2 class="text-center"><?php echo Yii::t('app', 'Terminverwaltung'); ?></h2>
    </div>
</div>
<?php
;
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'appointment-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array('name' => 'dateAndTime_id', 'value' => 'Yii::app()->dateFormatter->formatDateTime(strtotime($data->dateandtime->date->date . $data->dateandtime->time), "short", "short")'),
        array('name' => 'parent_child_id', 'value' => '$data->parentchild->user->firstname." ".$data->parentchild->user->lastname', 'header' => 'Erziehungsberechtigte/r'),
        array('name' => 'user_id', 'value' => '$data->user->title." ".$data->user->firstname." ".$data->user->lastname'),
        array('class' => 'CustomButtonColumn',),
    ),
));

if (Yii::app()->params['allowBlockingAppointments']) {
    ?>
    <div class="push"></div>
    <div class="row">
        <div class="small-12 columns small-centered">
            <h2 class="text-center"><?php echo Yii::t('app', 'Blockierte Termine'); ?></h2>
        </div>
    </div>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'appointmentBlock-grid',
        'dataProvider' => $blockedApp->search(),
        'filter' => $blockedApp,
        'columns' => array(
            array('name' => 'dateAndTime_id', 'value' => 'Yii::app()->dateFormatter->formatDateTime(strtotime($data->dateandtime->date->date . $data->dateandtime->time), "short", "short")'),
            array('name' => 'user_id', 'value' => '$data->user->title." ".$data->user->firstname." ".$data->user->lastname'),
            array('name' => 'reason'),
            array('class' => 'CustomButtonColumn', 'template' => '{delete}', 'buttons' => array(
                    'delete' => array(
                        'url' => '$this->grid->controller->createUrl("/appointment/deleteblockapp", array("id"=>$data->id))'
                    ),
                )),
        ),
    ));
}
?>
<div class="push"></div>
<div class="row">
    <div class="small-12 columns small-centered">
        <h2 class="text-center"><?php echo Yii::t('app','Druckansicht'); ?></h2>
    </div>
</div>
<div class="row">
    <div class="small-5 columns">
        <div class="row collapse">
            <div class="small-4 columns">
                <span class="prefix"><?php echo Yii::t('app','Lehrer'); ?></span>
            </div>
            <div class="small-8 columns">
                <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'id' => 'print-view-teacher',
                    'name' => '',
                    'sourceUrl' => 'index.php?r=user/search&role=2',
                    'options' => array(
                        'minLength' => '1',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => Yii::t('app','Geben Sie einen Nachnamen ein'),
                    ),
                )); ?>
            </div>
        </div>        
    </div>
    <div class="small-5 columns">
        <div class="row collapse">
            <div class="small-4 columns">
                <span class="prefix"><?php echo Yii::t('app','Elternsprechtag'); ?></span>
            </div>
            <div class="small-8 columns">
                <?php echo Select2::dropDownList('','',$dates,array('id' => 'print-view-date')); ?>
            </div>
        </div>
    </div>
    <div class="small-2 columns">
        <div class="small button" id="print-view-button"><?php echo Yii::t('app','Anzeigen'); ?></div>
    </div>
</div>
