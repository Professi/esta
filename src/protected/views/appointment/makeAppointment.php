<?php
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
/* @var $model Appointment */
/** @var $a_child Array Of Childs */
/** @todo MVC anpassen */
?>
<div class="row">
    <div class="twelve columns">
        <h2 class="subheader">Termine f&uuml;r&nbsp;
            <?php echo $model->user->title . " " . $model->user->firstname . " " . $model->user->lastname; ?></h2>
        <hr>
        <?php if (empty($a_dates)) { ?>
            <div class="panel">
                In n&auml;chster Zeit ist kein Elternsprechtag geplant, f&uuml;r den Sie Termine vereinbaren k&ouml;nnten.
            </div>
        <?php } else { ?>
            <div class="panel js_show">
                Hier k&ouml;nnen Sie Termine mit dem Lehrer vereinbaren. 
                Klicken Sie einfach auf ein Feld mit "Verf&uuml;gbar" und best&auml;tigen Sie am Ende der Seite den Termin.
            </div>
            <div class="js_show">
                <?php
                $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => $a_tabs,
                    'options' => array(
                        'collapsible' => false,
                    ),
                    'htmlOptions' => array(
                        'style' => 'border:none;'
                    ),
                    'cssFile' => false,
                ));
                ?>
            </div>
            <div class="row js_hide">
                <?php foreach ($a_tabs as $date => $table) { ?>
                    <div class="<?php echo $columnCount ?> columns">
                        <h4 class="subheader text-center"><?php echo $date ?></h4>
                        <?php echo $table; ?>
                    </div>
                <?php } ?>
            </div>
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'appointment-form',)); ?>
            <fieldset>
                <legend>Termin</legend>
                <div class="row collapse">
                    <div class="two columns">
                        <span class="prefix">Mit</span>
                    </div>
                    <div class="ten columns mobile-input">
                        <?php
                        echo $form->textField($model, 'user_id', array(
                            'value' => $model->user->title . " " . $model->user->firstname . " " . $model->user->lastname,
                            'disabled' => true));
                        ?>
                    </div>
                </div>
                <div class="row collapse js_show">
                    <div class="two columns">
                        <span class="prefix">Am</span>
                    </div>
                    <div class="ten columns mobile-input">
                        <input id="form_date" type="text" disabled value="<?php echo $postDate; ?>" />
                        <?php echo $form->error($model, 'dateAndTime_id'); ?>
                    </div>
                </div>
                <div class="row collapse js_show">
                    <div class="two columns">
                        <span class="prefix">Um</span>
                    </div>
                    <div class="ten columns mobile-input">
                        <input id="form_time" type="text" disabled  value="<?php echo $postTime; ?>" />
                        <?php echo $form->error($model, 'dateAndTime_id'); ?>
                    </div>
                </div>
                <div class="row collapse js_hide">
                    <div class="two columns">
                        <span class="prefix">Termin</span>
                    </div>
                    <div class="ten columns mobile-input">
                        <div class="styled-select">
                            <?php echo $this->createSelectTeacherDates($model->user->id, get_class($model), 'dateAndTime_id', $model->attributes['dateAndTime_id']) ?>
                            <?php echo $form->error($model, 'dateAndTime_id'); ?>
                        </div>
                    </div>
                </div>
                <div class="row collapse">
                    <div class="two columns">
                        <span class="prefix">Für</span>
                    </div>
                    <div class="ten columns mobile-input">
                        <div class="styled-select">
                            <?php echo $this->createSelectChildren(Yii::app()->user->getId(), get_class($model), 'parent_child_id'); ?>
                            <?php echo $form->error($model, 'parent_child_id'); ?>
                        </div>
                    </div>
                </div>
                <?php echo CHtml::submitButton('Bestätigen', array('class' => 'button right')); ?>
            </fieldset>
            <?php $this->endWidget(); ?>
        </div>
    </div>
<?php } //End else: atleast one Elternsprechtag  ?>
