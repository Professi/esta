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
        $user_id_temp = Yii::app()->user->getId();
        $arr_parent_dates = $this->getDatesWithTimes(3);
        $arr_tabs = null;
        foreach ($arr_parent_dates as $arr_dates) {
            $tabs_name = date('d.m.Y',  strtotime($arr_dates[0][0]->date->date));
            $tabs_content = '<table><thead><th>Uhrzeit</th><th>&nbsp;</th></thead><tbody>';
            foreach ($arr_dates as $arr_times) {
                $arr_times_temp = $this->isAppointmentAvailable($model->user->id,$arr_times[0]->id); //array containing information if appointment is avaiable.
                                print_r($arr_times_temp);
                if ($arr_times_temp[1]) {
                    $tabs_content += '<tr><td class="avaiable table-text">'.$arr_times[0]->time.'</td><td>'.$arr_times_temp[0].'</td></tr>';
                } else {
                    $tabs_content += '<tr><td class="occupied table-text">'.$arr_times[0]->time.'</td><td>'.$arr_times_temp[0].'</td></tr>';
                }
            }
            $tabs_content += '</tbody></table>';
            $arr_tabs = array($tabs_name => $tabs_content);
        }
        print_r($arr_tabs);
        $this->widget('zii.widgets.jui.CJuiTabs',array(
            'tabs'=>$arr_tabs,
            'options'=>array(
                'collapsible'=>false,
            ),
            'htmlOptions' => array(
                'style'=>'border:none;'
                ),
        )); 
        ?>
        <table class="text-center">
            <thead>
                <?php
                switch (count($arr_dates[0])) {
                    case 1: 
                ?>
                <th width="20%">Uhrzeit</th>
                <th width="80%" id="date1"><?php echo CHtml::encode(date('d.m.Y',  strtotime($arr_dates[0][0][0]->date->date))); ?></th>
                <?php                            
                            break;
                    case 2: 
                ?>
                <th width="10%">Uhrzeit</th>
                <th width="45%" id="date1"><?php echo CHtml::encode(date('d.m.Y',  strtotime($arr_dates[0][0][0]->date->date))); ?></th>
                <th width="45%" id="date2"><?php echo CHtml::encode(date('d.m.Y',  strtotime($arr_dates[1][0][0]->date->date))); ?></th>
                <?php
                            break;
                    case 3: 
                ?>
                <th width="10%">Uhrzeit</th>
                <th width="30%" id="date1"><?php echo CHtml::encode(date('d.m.Y',  strtotime($arr_dates[0][0][0]->date->date))); ?></th>
                <th width="30%" id="date2"><?php echo CHtml::encode(date('d.m.Y',  strtotime($arr_dates[1][0][0]->date->date))); ?></th>
                <th width="30%" id="date3"><?php echo CHtml::encode(date('d.m.Y',  strtotime($arr_dates[2][0][0]->date->date))); ?></th>
                <?php
                            break;
                }
                ?>
            </thead>
            <tbody>
                <?php  ?>
            </tbody>
        </table>
        
        <form action="" method="post" accept-charset="UTF-8">
            <fieldset>
                <legend>Termin</legend>
                <div class="row collapse">
                        <div class="two columns">
                                <span class="prefix">Mit</span>
                        </div>
                        <div class="ten columns">
                                <input id="teacher" type="text" disabled 
                                 value="<?php echo $model->user->title." ".$model->user->firstname." ".$model->user->lastname ?>" />                                
                        </div>
                </div>
                <div class="row collapse " class="js_show">
                        <div class="two columns">
                                <span class="prefix">Am</span>
                        </div>
                        <div class="ten columns">
                                <input id="form_date" type="text" disabled value="" />
                        </div>
                </div>
                <div class="row collapse" class="js_show">
                        <div class="two columns">
                                <span class="prefix">Um</span>
                        </div>
                        <div class="ten columns">
                                <input id="form_time" type="text" disabled  value="" />
                        </div>
                </div>
                <div class="row collapse">
                        <div class="two columns">
                                <span class="prefix">Für</span>
                        </div>
                        <div class="ten columns">
                                <div class="styled-select">
                                        <select>
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
                <div class="row collapse">
                    <div class="two columns">
                        <span class="prefix">Datum</span>
                    </div>
                    <div class="ten columns">
                        <div class="styled-select">
                            <select>
                                <option>Test</option>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="submit" class="button right" value="Best&auml;tigen" />
            </fieldset>
            <input type="hidden" value="<?php echo $model->user->id; ?>" />
        </form>
    </div>
</div>