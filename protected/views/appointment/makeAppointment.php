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
 * @var $model Appointment
 * @var $a_child Array Of Childs
 * @var $dates
 * @var $columnCount
 * @var $postDate
 * @var $postTime
 */
/** @todo MVC anpassen */
$this->setPageTitle(Yii::t('app', 'Termin vereinbaren'));
Yii::app()->clientScript->registerCssFile($this->assetsDir . "/css/select2.min.css");
?>
<div class="row">
    <div class="small-12 columns">
        <h2 class="subheader">
            <?php echo Yii::t('app', 'Termine für') ?>
            <?php echo(empty($model->user->title) ? "" : $model->user->title . " ") . "{$model->user->firstname} {$model->user->lastname}"; ?>
        </h2>
        <hr>
        <?php if (empty($dates) || empty($dates[0])) {
    ?>
            <div class="paper panel">
                <?php echo Yii::t('app', 'In nächster Zeit ist kein Elternsprechtag geplant, für den Sie Termine vereinbaren könnten.'); ?>
            </div>
        <?php
} else {
        ?>
            <div class="paper panel js_show hide-for-print">
                <?php echo Yii::t('app', 'Hier können Sie Termine mit dem Lehrer vereinbaren.'); ?>
                <?php echo Yii::t('app', 'Klicken Sie zuerst auf ein Datum und dann einfach auf ein Feld mit "Verfügbar" und bestätigen Sie am Ende der Seite den Termin.'); ?>
                <?php if (sizeof($dates) > 1) {
            ?>
                <?php echo Yii::t('app', 'Achten Sie darauf, dass der korrekte Elternsprechtag ausgewählt ist. Der aktive Elterntag ist weiß und blau hinterlegt, andere Auswahlmöglichkeiten erscheinen grau und sind klickbar.'); ?>
                <?php
        } ?>
            </div>
            <div class="js_show">
                <?php
                echo '';
        $tabs = array();
        foreach ($dates as $date) {
            $tabs[$this->formatAppointmentTitle($date[0]->date)] = $this->renderPartial(
                            'dateTable',
                        array('date' => $date,
                        'model' => $model,
                        'columnCount' => $columnCount,
                        'isTab' => true),
                        true
                    );
        }
        $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => $tabs,
                    'options' => array(
                        'collapsible' => false,
                    ),
                    'htmlOptions' => array(
                        'style' => 'border:none;'
                    ),
                    'cssFile' => false,
                )); ?>
            </div>
            <div class="row js_hide">
                <?php
                foreach ($dates as $date) {
                    $this->renderPartial(
                        'dateTable',
                        array(
                        'date' => $date,
                        'model' => $model,
                        'columnCount' => $columnCount,
                        'isTab' => false)
                    );
                } ?>
            </div>
            <div class="push"></div>
            <div class="paper panel text-center hide-for-print"">
                <p>
                    <?php echo Yii::t('app', 'Keinen passenden Termin gefunden? Kontaktieren Sie '); ?>
                    <?php echo "{$model->user->title} {$model->user->firstname} {$model->user->lastname}"; ?>
                    <?php echo Yii::t('app', 'per'); ?> 
                    <a href="mailto:<?php echo $model->user->email; ?>">
                        <i class="fi-mail"></i>&nbsp;<?php echo Yii::t('app', 'E-Mail'); ?>
                    </a>
                </p>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'appointment-form',
                'errorMessageCssClass' => 'error',
                'skin' => false,)); ?>
            <fieldset class="hide-for-print">
                <legend><?php echo Yii::t('app', 'Termin'); ?></legend>
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix"><?php echo Yii::t('app', 'Mit'); ?></span>
                    </div>
                    <div class="small-8 columns mobile-input">
                        <?php
                        echo $form->textField($model, 'user_id', array(
                            'value' => $model->user->title . " " . $model->user->firstname . " " . $model->user->lastname,
                            'disabled' => true)); ?>
                    </div>
                </div>
                <div class="row collapse js_show">
                    <div class="small-4 columns">
                        <span class="prefix"><?php echo Yii::t('app', 'Am') ?></span>
                    </div>
                    <div class="small-8 columns mobile-input">
                        <input id="form_date" type="text" disabled value="<?php echo $postDate; ?>" />
                        <?php echo $form->error($model, 'dateAndTime_id'); ?>
                    </div>
                </div>
                <div class="row collapse js_show">
                    <div class="small-4 columns">
                        <span class="prefix"><?php echo Yii::t('app', 'Um'); ?></span>
                    </div>
                    <div class="small-8 columns mobile-input">
                        <input id="form_time" type="text" disabled  value="<?php echo $postTime; ?>" />
                        <?php echo $form->error($model, 'dateAndTime_id'); ?>
                    </div>
                </div>
                <div class="row collapse js_hide">
                    <div class="small-4 columns">
                        <span class="prefix"><?php echo Yii::t('app', 'Termin'); ?></span>
                    </div>
                    <div class="small-8 columns mobile-input">
                        <div class="styled-select">
                            <?php echo $this->createSelectTeacherDates($model->user->id, get_class($model), 'dateAndTime_id', $model->attributes['dateAndTime_id']) ?>
                            <?php echo $form->error($model, 'dateAndTime_id'); ?>
                        </div>
                    </div>
                </div>
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix"><?php echo Yii::t('app', 'Für'); ?></span>
                    </div>
                    <div class="small-8 columns mobile-input">
                        <?php echo $this->createSelectChildren(Yii::app()->user->getId(), get_class($model), 'parent_child_id'); ?>
                        <?php echo $form->error($model, 'parent_child_id'); ?>
                    </div>
                </div>
                <?php echo CHtml::submitButton(Yii::t('app', 'Bestätigen'), array('class' => 'button right')); ?>
            </fieldset>
            <?php $this->endWidget(); ?>
        <?php
    } //End else: atleast one Elternsprechtag?>
    </div>
</div>
