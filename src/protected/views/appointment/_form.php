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
    $selectContent = '';
    $selectChildrenContent = '';
    if ($model->isNewRecord) {
//        $parentChild_value = '';
        $parentLabel = '';
        $teacherValue = '';
        $teacherLabel = '';
        if (isset($_GET['teacherId'])) {
            $userTemp = User::model()->findByPk($_GET['teacherId']);
            $teacherValue = $_GET['teacherId'];
            $teacherLabel = $userTemp->title." ".$userTemp->firstname." ".$userTemp->lastname;
            $this->createMakeAppointmentContent($this->getDatesWithTimes(3),$a_tabs, $selectContent, $user_value);
        }
        if (isset($_GET['parentId'])) {
//            $userTemp = ParentChild::model()->findByAttributes(array('user_id' => $_GET['parentId']));
            $userTemp = User::model()->findByPk($_GET['parentId']);
//            $parentChild_value = $_GET['parentId'];
//            $parentChild_label = $userTemp->user->firstname." ".$userTemp->user->lastname."; Kind: ".$userTemp->child->firstname." ".$userTemp->child->lastname;
            $parentLabel = $userTemp->firstname." ".$userTemp->lastname;
            $selectChildrenContent = $this->createChildrenSelect($userTemp->lastname);
        }
//        $dateAndTime_value = '';
//        $dateAndTime_label = '';
    } else {
//        $dateAndTime_value = $model->dateAndTime->id;
//        $parentChild_value = $model->parentChild->id;
        $teacherValue = $model->user->id; //
//        $dateAndTime_label = date('d.m.Y',  strtotime($model->dateAndTime->date->date))." ".date('H:i', strtotime($model->dateAndTime->time)); 
//        $parentChild_label = $model->parentChild->user->firstname." ".$model->parentChild->user->lastname."; Kind: ".$model->parentChild->child->firstname." ".$model->parentChild->child->lastname;
        $teacherLabel = $model->user->title." ".$model->user->firstname." ".$model->user->lastname;
        
        $a_tabs = null;
        $this->createMakeAppointmentContent($this->getDatesWithTimes(3),$a_tabs, $selectContent, $model->user->id);
        
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
                <input type="hidden" id="appointment_teacher_id" name="Appointment[user_id]" value="<?php echo $teacherValue ?>">
            </div>
	</div>
<?php print($model->user) ?>
        <div class="row collapse">
            <div class="two columns">
                <span class="prefix">Termin</span>
            </div>
            <div class="ten columns styled-select" id="appointment_dateAndTime_select">
                <?php echo $selectContent; ?>                
		<?php echo $form->error($model,'dateAndTime_id'); ?>
                
            </div>
	</div>
<br>

		<?php echo CHtml::submitButton($model->isNewRecord ? 'Anlegen' : 'Speichern',  array('class' => 'small button')); ?>
	

<?php $this->endWidget(); ?>