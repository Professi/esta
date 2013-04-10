<?php
/* @var $this AppointmentController */
/* @var $model Appointment */
/* @var $form CActiveForm */
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
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'appointment-form',
)); 
    $selectContent = array();
    $selectChildrenContent = '';
    $parentLabel = '';
    $a_tabs = array();
    if ($model->isNewRecord) {
        $teacherValue = '';
        $teacherLabel = '';
        $dateAndTimeId = '';
        if (isset($_GET['teacherId'])) {
            $userTemp = User::model()->findByPk($_GET['teacherId']);
            $teacherValue = $_GET['teacherId'];
            $teacherLabel = $userTemp->title." ".$userTemp->firstname." ".$userTemp->lastname;
            $selectContent = CHtml::listData($this->getDatesWithTimes(3, true), 'id', 'time', 'date');
        }
        if (isset($_GET['parentId'])) {
            $userTemp = User::model()->findByPk($_GET['parentId']);

            $parentLabel = $userTemp->firstname." ".$userTemp->lastname;
            $selectChildrenContent = $this->createChildrenSelect($userTemp->lastname);
        }
    } else {
        $parentLabel = $model->parentChild->user->firstname." ".$model->parentChild->user->lastname;
        $selectChildrenContent = $this->createChildrenSelect($model->parentChild->user->lastname, $model->parentChild->id);
        $teacherValue = $model->user->id; 
        $teacherLabel = $model->user->title." ".$model->user->firstname." ".$model->user->lastname;
        $dateAndTimeId = $model->dateAndTime->id;
        $selectContent = CHtml::listData($this->getDatesWithTimes(3, true), 'id', 'time', 'date');
        
    }
?>


        <div class="row collapse">
            <div class="two columns">
                <span class="prefix">Elternteil</span>
            </div>
            <div class="ten columns">
		            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'id' => 'appointment_parent',
                'name' => '',
                'value' => $parentLabel,
                'sourceUrl' => 'index.php?r=user/search&role=3',
                'options' => array(
                    'minLength' => '1',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Geben Sie einen Nachnamen ein',
                ),
            ));
            ?>
            </div>
	</div>


        <div class="row collapse">
            <div class="two columns">
                <span class="prefix">Kind</span>
            </div>
            <div class="ten columns styled-select" id="appointment_parent_select">
                <?php echo $selectChildrenContent; ?>
                <?php echo $form->error($model,'parent_child_id'); ?>
            </div>
        </div>
 

	

	<div class="row collapse">
            <div class="two columns">
                <span class="prefix">Lehrer</span>
            </div>
            <div class="ten columns">
                
		            <?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'id' => 'appointment_teacher',
                                'name'=>'',
                                'value' => $teacherLabel,
                                'sourceUrl'=>'index.php?r=user/search&role=2',
                                'options'=>array(
                                    'minLength'=>'1',
                                ),
                                'htmlOptions'=>array(
                                    'placeholder' => 'Geben Sie einen Nachnamen ein und wählen Sie einen Eintrag aus',
                                ),
                            ));
                            ?>
		<?php echo $form->error($model,'user_id'); ?>
                <?php echo $form->hiddenField($model, 'user_id', array('id' => 'appointment_teacher_id', 'value' => $teacherValue)); ?>
            </div>
	</div>
        <div class="row collapse">
            <div class="two columns">
                <span class="prefix">Termin</span>
            </div>
            <div class="ten columns styled-select" id="appointment_dateAndTime_select">
                <?php echo $form->dropDownList($model, 'dateAndTime_id',$selectContent, array('options' => array($dateAndTimeId => array('selected'=>true))) ); 
//                        echo $selectContent;  ?>                
		<?php echo $form->error($model,'dateAndTime_id'); ?>
                
            </div>
	</div>
<br>

		<?php echo CHtml::submitButton($model->isNewRecord ? 'Anlegen' : 'Speichern',  array('class' => 'small button')); ?>
	

<?php $this->endWidget(); ?>