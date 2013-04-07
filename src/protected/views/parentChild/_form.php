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

/* @var $this ParentChildController */
/* @var $model ParentChild */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'parent-child-form',
    'enableAjaxValidation' => false,
        ));
?>

<?php
if (Yii::app()->user->checkAccess('1')) {
    ?>
    <div class="row collapse">
        <div class="two columns">
            <span class="prefix">Elternteil</span>
        </div>
        <div class="ten columns">
            <?php
            if (isset($_GET['id'])) {
                $userTemp = User::model()->findByPk($_GET['id']);
                $userIdTemp = $_GET['id'];
                $userNameString = $userTemp->firstname." ".$userTemp->lastname;
            } else {
                $userIdTemp = '';
                $userNameString = '';
            }
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'id' => 'parentChild_user_display',
                'name' => '',
                'value' => $userNameString,
                'sourceUrl' => 'index.php?r=user/search&role=3',
                'options' => array(
                    'minLength' => '2',
                ),
                'htmlOptions' => array(
                ),
            ));
            ?>
            <?php echo $form->error($model, 'user_id'); ?>
            <input type="hidden" id="parentChild_user_id" name="ParentChild[user_id]" value="<?php echo $userIdTemp ?>"
        </div>
    </div>
<? } ?>
<div class="row collapse">
    <div class="two columns">
        <span class="prefix">Vorname</span>
    </div>
    <div class="ten columns mobile-input">
        <?php echo $form->textField($model, 'childFirstName'); ?>
        <?php echo $form->error($model, 'childFirstName'); ?>
    </div>
</div>

<div class="row collapse">
    <div class="two columns">
        <span class="prefix">Nachname</span>
    </div>
    <div class="ten columns mobile-input">
        <?php echo $form->textField($model, 'childLastName'); ?>
        <?php echo $form->error($model, 'childLastName'); ?>
    </div>
</div>            
<br>
<?php echo CHtml::submitButton($model->isNewRecord ? 'Anlegen' : 'Speichern', array('class' => 'small button')); ?>

<?php $this->endWidget(); ?>
