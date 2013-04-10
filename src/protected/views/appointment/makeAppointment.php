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
            <?php echo $model->user->title." ".$model->user->firstname." ".$model->user->lastname; ?></h2>
        <hr>
        <?php
        $a_dates = $this->getDatesWithTimes(3); //Magic Number: nur die nächsten 3 Elternsprechtage werden geladen.
        if (empty($a_dates)) {
        ?>
        <div class="panel">
            In n&auml;chster Zeit ist kein Elternsprechtag geplant, f&uuml;r den Sie Termine vereinbaren k&ouml;nnten.
        </div>
        <?php
        } else {
        ?>
        <div class="panel js_show">
            Hier k&ouml;nnen Sie Termine mit dem Lehrer vereinbaren. 
            Klicken Sie einfach auf ein Feld mit "Verf&uuml;gbar" und best&auml;tigen Sie am Ende der Seite den Termin.
        </div>
        <?php
        $a_tabs = null;
        $selectContent = null;
        $this->createMakeAppointmentContent($a_dates, $a_tabs, $selectContent, $model->user->id);
        ?>
        <div class="js_show">
        <?php
        $this->widget('zii.widgets.jui.CJuiTabs',array(
            'tabs'=>$a_tabs,
            'options'=>array(
                'collapsible'=>false,
            ),
            'htmlOptions' => array(
                'style'=>'border:none;'
                ),
            'cssFile' => false,
        )); 
        ?>
        </div>
        <div class="row js_hide">
        <?php
                switch (count($a_tabs)) {
                    case 1: 
                        $columnCount = 'twelve';
                        break;
                    case 2: 
                        $columnCount = 'six';
                        break;
                    case 3:
                        $columnCount = 'four';
                        break;
                    default :
                        $columnCount = 'twelve';
                        break;
                }
                foreach ($a_tabs as $date => $table) {
                    ?>
            <div class="<?php echo $columnCount ?> columns">
                <h4 class="subheader text-center"><?php echo $date ?></h4>
                <?php echo $table; ?>
            </div>
                    <?php
                }
        ?>
        </div>
        <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'appointment-form',
)); ?>
            <fieldset>
                <legend>Termin</legend>
                <div class="row collapse">
                        <div class="two columns">
                                <span class="prefix">Mit</span>
                        </div>
                        <div class="ten columns mobile-input">
                                <input id="Appointment[user_id]" type="text" disabled name="Appointment[user_id]"
                                 value="<?php echo $model->user->title." ".$model->user->firstname." ".$model->user->lastname ?>" />                                
                        </div>
                </div>
                <div class="row collapse js_show">
                        <div class="two columns">
                                <span class="prefix">Am</span>
                        </div>
                        <div class="ten columns mobile-input">
                                <input id="form_date" type="text" disabled value="" />
                        </div>
                </div>
                <div class="row collapse js_show">
                        <div class="two columns">
                                <span class="prefix">Um</span>
                        </div>
                        <div class="ten columns mobile-input">
                                <input id="form_time" type="text" disabled  value="" />
                        </div>
                </div>
                <div class="row collapse js_hide">
                    <div class="two columns">
                        <span class="prefix">Termin</span>
                    </div>
                    <div class="ten columns mobile-input">
                        <div class="styled-select">
                            <?php echo $selectContent; ?>
                        </div>
                    </div>
                </div>
                <div class="row collapse">
                        <div class="two columns">
                                <span class="prefix">Für</span>
                        </div>
                        <div class="ten columns mobile-input">
                                <div class="styled-select">
                                        <select name="Appointment[parent_child_id]">
                                            <?php
                                                for ( $i = 0; $i < count($a_child); $i++) {
                                            ?>
                                            <option value="<?php echo CHtml::encode($a_child[$i]['value']); ?>"><?php echo CHtml::encode($a_child[$i]['label']); ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                </div>
                        </div>
                </div>
                <input type="submit" class="button right" value="Best&auml;tigen" />
            </fieldset>
            <input type="hidden" value="<?php echo $model->user->id; ?>" />
      <?php $this->endWidget(); ?>
    </div>
</div>
        <?php } //End else: atleast one Elternsprechtag ?>