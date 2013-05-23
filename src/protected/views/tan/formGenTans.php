<?php
/**
 * Formular um Tans zu generieren
 */
/* * Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
/* @var $this TanController */
/* @var $model tan */
$this->setPageTitle('TAN Generierung');
Yii::app()->clientScript->registerCssFile($this->assetsDir . "/css/select2.min.css");
$groups = array();
if (Yii::app()->params['allowGroups']) {
    $groups = Group::model()->getAllGroups('DESC');
}
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="text-center">Tan Generierung</h2>
    </div>
</div>
<div class="row">
    <div class="eight columns centered">

        <?php
        if (Yii::app()->params['allowParentsToManageChilds']) {
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'tan-form',
            ));
            ?>        <fieldset>
                <div class="row collapse">
                    <div class="three columns">
                        <span class="prefix">Anzahl TANs</span>
                    </div>
                    <div class="nine columns">
                        <?php
                        echo $form->textField($model, 'tan_count', array('size' => 60));
                        echo $form->error($model, 'tan_count');
                        ?>
                    </div>
                </div>
                <?php
                if (Yii::app()->params['allowGroups'] && !empty($groups)) {
                    ?>
                    <div class="row collapse">
                        <div class="three columns">
                            <span class="prefix"><?php echo $form->label($model, 'group'); ?></span>
                        </div>
                        <div class="nine columns">
                            <?php
                            echo Select2::activeDropDownList($model, 'group_id', $groups, array(
                                'prompt' => 'Hier können Sie eine Gruppe auswählen...')
                            );
                            echo $form->error($model, 'group');
                            ?>
                        </div>
                    </div>
                <?php } echo CHtml::submitButton('Absenden', array('class' => 'small button'));
                ?>
            </fieldset>
            <?php $this->endWidget(); ?><?php
        } else if (!Yii::app()->params['allowParentsToManageChils']) {
            echo CHtml::beginForm();
            foreach ($model as $i => $tanObj) {
                ?>
                <div class="customChild">
                    <div class="row collapse">
                        <div class="three columns">
                            <span class="prefix"><?php  echo CHtml::activeLabel($tanObj, "childFirstname"); ?></span>
                        </div>
                        <div class="nine columns">
                            <?php
                            echo CHtml::activeTextField($tanObj, "[$i]childFirstname");
                            ?>
                        </div>
                    </div>
                    <div class="row collapse">
                        <div class="three columns">
                            <span class="prefix"><?php  echo CHtml::activeLabel($tanObj, "childLastname"); ?></span>
                        </div>
                        <div class="nine columns">
                            <?php
                            echo CHtml::activeTextField($tanObj, "[$i]childLastname", array('size' => 60));
                            ?>
                        </div>
                    </div>
                    <?php
                    if (Yii::app()->params['allowGroups'] && !empty($groups)) {
                        ?>
                        <div class="row collapse">
                            <div class="three columns">
                                <span class="prefix"><?php  echo CHtml::activeLabel($tanObj, "group"); ?></span>
                            </div>
                            <div class="nine columns">
                                <?php
                                echo Select2::activeDropDownList($tanObj, "[$i]group_id", $groups, array(
                                    'prompt' => 'Hier können Sie eine Gruppe auswählen...')
                                );
                                ?>
                            </div>
                        </div>
                    <?php } echo CHtml::submitButton('Absenden', array('class' => 'small button')); ?>
                </div>
                <?php
            }
            echo CHtml::endForm();
        }
        ?>
    </div>
</div>
