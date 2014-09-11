<?php
/**
 * Formular um Tans zu generieren
 */
/* * Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
 * @var $this TanController 
 * @var $model tan 
 */
$this->setPageTitle(Yii::t('app', 'TAN Generierung'));
Yii::app()->clientScript->registerCssFile($this->assetsDir . "/css/select2.min.css");
?>
<div class="row">
    <div class="small-12 columns small-centered">
        <h2 class="text-center"><?php echo Yii::t('app', 'TAN Generierung'); ?></h2>
    </div>
</div>
<div class="row">
    <div class="small-8 columns small-centered">

        <?php
        if (Yii::app()->params['allowParentsToManageChilds']) {
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'tan-form',
                'errorMessageCssClass' => 'error',
                'skin' => false,
            ));
            ?>        <fieldset>
                <div class="row collapse">
                    <div class="small-3 columns">
                        <span class="prefix"><?php echo Yii::t('app', 'Anzahl TANs');?></span>
                    </div>
                    <div class="small-9 columns">
                        <?php
                        echo $form->numberField($model, 'tan_count', array(
                            'min' => 0,
                            'max' => Yii::app()->params['maxTanGen'],
                        ));
                        echo $form->error($model, 'tan_count');
                        ?>
                    </div>
                </div>
                <?php
                if (Yii::app()->params['allowGroups'] && !empty($groups)) {
                    ?>
                    <div class="row collapse">
                        <div class="small-3 columns">
                            <span class="prefix"><?php echo $form->label($model, 'group'); ?></span>
                        </div>
                        <div class="small-9 columns">
                            <?php
                            echo Select2::activeDropDownList($model, 'group_id', $groups, array(
                                'prompt' => Yii::t('app', 'Hier können Sie eine Gruppe auswählen...'))
                            );
                            echo $form->error($model, 'group_id');
                            ?>
                        </div>
                    </div>
                <?php } echo CHtml::submitButton(Yii::t('app', 'Absenden'), array('class' => 'small button'));
                ?>
            </fieldset>
            <?php
            $this->endWidget();
        } else if (!Yii::app()->params['allowParentsToManageChilds']) {
            echo CHtml::beginForm();
            ?>
            <fieldset>
                <?php
                foreach ($model as $i => $tanObj) {
                    ?>
                    <div class="customChild">
                        <div class="row collapse">
                            <div class="small-3 columns">
                                <span class="prefix"><?php echo CHtml::activeLabel($tanObj, "childFirstname"); ?></span>
                            </div>
                            <div class="small-9 columns">
                                <?php
                                echo CHtml::activeTextField($tanObj, "[$i]childFirstname");
                                echo CHtml::error($tanObj, "[$i]childFirstname");
                                ?>
                            </div>
                        </div>
                        <div class="row collapse">
                            <div class="small-3 columns">
                                <span class="prefix"><?php echo CHtml::activeLabel($tanObj, "childLastname"); ?></span>
                            </div>
                            <div class="small-9 columns">
                                <?php
                                echo CHtml::activeTextField($tanObj, "[$i]childLastname", array('size' => 60));
                                echo CHtml::error($tanObj, "[$i]childLastname");
                                ?>
                            </div>
                        </div>
                        <?php
                        if (Yii::app()->params['allowGroups'] && !empty($groups)) {
                            ?>
                            <div class="row collapse">
                                <div class="small-3 columns">
                                    <span class="prefix"><?php echo CHtml::activeLabel($tanObj, "group"); ?></span>
                                </div>
                                <div class="small-9 columns">
                                    <?php
                                    echo Select2::activeDropDownList($tanObj, "[$i]group_id", $groups, array(
                                        'prompt' => Yii::t('app', 'Hier können Sie eine Gruppe auswählen...'))
                                    );
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="tiny button add-child-tan">+</div>
                <div>
                    <?php echo CHtml::submitButton(Yii::t('app', 'Absenden'), array('class' => 'small button')); ?>
                </div>
            </fieldset>
            <?php
            echo CHtml::endForm();
        }
        ?>
    </div>
</div>
