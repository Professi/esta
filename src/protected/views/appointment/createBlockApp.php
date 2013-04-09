<?php
/**
 * Appointment blockieren
 */
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
/* @var $model BlockedAppointment */
/* @var $form CActiveForm */
?>



<?php
$this->breadcrumbs = array(
    'Appointments' => array('index'),
    'BlockApp',
);

$this->menu = array(
    array('label' => 'Termine verwalten', 'url' => array('admin')),
);
?>

<div class="row">
    <div class="twelve columns centered">
        <fieldset>
            <legend>Termin blockieren</legend>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'blockAppointment-form',
            ));
            /**
             * @todo eindeutig gehört das in den Controller oder model
             */
            $selectContent = '';
            $teacherValue = '';
            $teacherLabel = '';
            if (isset($_GET['teacherId'])) { //Weiterleitung vom user/view; eventuell auch wenn der Lehrer dann im Menü auf Termin blockieren geht? haha -> möglicher intrusion point siehe #177 ;)
                $userTemp = User::model()->findByPk($_GET['teacherId']);
                $teacherValue = $_GET['teacherId'];
                $teacherLabel = $userTemp->title . " " . $userTemp->firstname . " " . $userTemp->lastname;
                $this->createMakeAppointmentContent($this->getDatesWithTimes(3), $a_tabs, $selectContent, $teacherValue);
            }
            ?>
            <div class="row collapse">
                <div class="two columns">
                    <span class="prefix">Lehrer</span>
                </div>
                <div class="ten columns">

<?php
$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
    'id' => 'appointment_teacher',
    'name' => '',
    'value' => $teacherLabel,
    'sourceUrl' => 'index.php?r=user/search&role=2',
    'options' => array(
        'minLength' => '1',
    ),
    'htmlOptions' => array(
        'placeholder' => 'Geben Sie einen Nachnamen ein und wählen Sie einen Eintrag aus',
    ),
));
?>
                    <?php echo $form->error($model, 'user_id'); ?>
                    <input type="hidden" id="appointment_teacher_id" name="Appointment[user_id]" value="<?php echo $teacherValue ?>">
                </div>
            </div>
            <div class="row collapse">
                <div class="two columns">
                    <span class="prefix">Termin</span>
                </div>
                <div class="ten columns styled-select" id="appointment_dateAndTime_select">
<?php echo $selectContent; ?>                
<?php echo $form->error($model, 'dateAndTime_id'); ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="two columns">
                    <span class="prefix">Grund</span>
                </div>
                <div class="ten columns">
<?php echo $form->textField($model, 'reason'); ?>                
<?php echo $form->error($model, 'reason'); ?>
                </div>
            </div>
            <br>

<?php echo CHtml::submitButton('Anlegen', array('class' => 'small button')); ?>
<?php $this->endWidget(); ?>
        </fieldset>
    </div>
</div>
