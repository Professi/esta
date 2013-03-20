<?php
/**   Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 *   This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 * 
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/* @var $this AppointmentController */
/* @var $model Appointment */
?>
<div class="row">
    <div class="twelve columns">
        <h2 class="subheader">Termine f&uuml;r&nbsp;
            <?php echo $model->user->title." ".$model->user->firstname." ".$model->user->lastname; ?>
        </h2>
        <hr>
        <div class="panel js_show">
            Hier k&ouml;nnen Sie Termine mit dem Lehrer vereinbaren. 
            Klicken Sie einfach auf ein Feld mit "Verf&uuml;gbar" und best&auml;tigen Sie am Ende der Seite den Termin.
        </div>
        <?php
        $user_id_temp = Yii::app()->user->getId(); //ID of the teacher, whose appointments we are viewing.
        $arr_parent_dates = $this->getDatesWithTimes(3); //Magic Number: only the next 3 dates are presented.
        $arr_tabs = null;
        $tabs_ui_id = 0; //id element of the tables, important for jquery from custom.js
        $select_content = '<select id="form_dateAndTime" name="Appointment[dateAndTime_id]">'; //the select element which transmits the actual dateAndTime_id
        foreach ($arr_parent_dates as $arr_dates) {
            $tabs_ui_id++;
            $tabs_name = date('d.m.Y',  strtotime($arr_dates[0]->date->date));
            $tabs_content = '<table><thead><th class="table-text" width="40%">Uhrzeit</th><th class="table-text" width="60%">Termin</th></thead><tbody>';
            $select_content .= '<optgroup label="'.$tabs_name.'">';
            $dates_ui_id = 0;
            foreach ($arr_dates as $key => $arr_times) {
                $dates_ui_id++;
                $arr_times = $this->isAppointmentAvailable($model->user->id,$arr_dates[$key]->id); //Array in dem gespeichert wird ob ein Termin Belegt oder Frei ist.
                $tabs_content .= '<tr><td id="time-ui-id-'.$tabs_ui_id.'_'.$dates_ui_id.'" class="table-text">'.date('H:i', strtotime($arr_dates[$key]->time)).'</td>';
                $select_content .= '<option value="'.$arr_dates[$key]->id.'"';
                if ($arr_times[1]) {
                    $tabs_content .= '<td id="ui-id-'.$tabs_ui_id.'_'.$dates_ui_id.'" class="avaiable table-text">'.$arr_times[0].'</td>';
                } else {
                    $tabs_content .= '<td class="occupied table-text">'.$arr_times[0].'</td>';
                    $select_content .= ' disabled ';
                }
                $tabs_content .= '</tr>';
                $select_content .= '>'.$tabs_name." - ".date('H:i', strtotime($arr_dates[$key]->time)).'</option>';
            }   
            $select_content .= '</optgroup>';
            $tabs_content .= '</tbody></table>';
            $arr_tabs[$tabs_name] = $tabs_content;
        }
        $select_content .= '</select>';
        ?>
        <div class="js_show">
        <?php
        $this->widget('zii.widgets.jui.CJuiTabs',array(
            'tabs'=>$arr_tabs,
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
                switch (count($arr_tabs)) {
                    case 1: 
                        $column_count = 'twelve';
                        break;
                    case 2: 
                        $column_count = 'six';
                        break;
                    case 3:
                        $column_count = 'four';
                        break;
                }
                foreach ($arr_tabs as $key => $value) {
                    ?>
            <div class="<?php echo $column_count ?> columns">
                <h4 class="subheader text-center"><?php echo $key ?></h4>
                <?php echo $value; //Tabelle ?>
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
                                <input id="teacher" type="text" disabled name="Appointment[user_id]"
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
                            <?php echo $select_content; ?>
                        </div>
                    </div>
                </div>
                <div class="row .'_collapse">
                        <div class="two columns">
                                <span class="prefix">Für</span>
                        </div>
                        <div class="ten columns mobile-input">
                                <div class="styled-select">
                                        <select name="Appointment[parent_child_id]">
                                            <?php
                                            
                                            $arr_child = $this->getChilds($user_id_temp);
                                                for ( $i = 0; $i < ParentChild::model()->countByAttributes(array('user_id' => $user_id_temp)); $i++) {
                                            ?>
                                            <option value="<?php echo CHtml::encode($arr_child[$i]['value']); ?>"><?php echo CHtml::encode($arr_child[$i]['label']); ?></option>
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