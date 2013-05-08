<?php
/**
 * Konfigurationsseite
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
/* @var $this SiteController */
/* @var $model DeleteAllForm */
/* @var $form CActiveForm */
?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'deleteAll-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <div class="row">
        <div class="twelve columns centered">
            <h2 class="text-center">Anwendung zur&uuml;cksetzen</h2>
        </div>
    </div>
    <div class="row">
        <fieldset>
            <div class="row collapse">
                <div class="three columns">
                    <span class="prefix"><?php echo $form->label($model, 'tans'); ?></span>
                </div>
                <div class="nine columns styled-select">
                    <?php
                    echo Select2::activeDropDownList($model, 'tans', array('1' => 'Ja', '0' => 'Nein'));
                    echo $form->error($model, 'tans');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="three columns">
                    <span class="prefix"><?php echo $form->label($model, 'appointments'); ?></span>
                </div>
                <div class="nine columns styled-select">
                    <?php
                    echo Select2::activeDropDownList($model, 'appointments', array('1' => 'Ja', '0' => 'Nein'));
                    echo $form->error($model, 'appointments');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="three columns">
                    <span class="prefix"><?php echo $form->label($model, 'teachers'); ?></span>
                </div>
                <div class="nine columns styled-select">
                    <?php
                    echo Select2::activeDropDownList($model, 'teachers', array('1' => 'Ja', '0' => 'Nein'));
                    echo $form->error($model, 'teachers');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="three columns">
                    <span class="prefix"><?php echo $form->label($model, 'dates'); ?></span>
                </div>
                <div class="nine columns styled-select">
                    <?php
                    echo Select2::activeDropDownList($model, 'dates', array('1' => 'Ja', '0' => 'Nein'));
                    echo $form->error($model, 'dates');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="three columns">
                    <span class="prefix"><?php echo $form->label($model, 'management'); ?></span>
                </div>
                <div class="nine columns styled-select">
                    <?php
                    echo Select2::activeDropDownList($model, 'management', array('1' => 'Ja', '0' => 'Nein'));
                    echo $form->error($model, 'management');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="three columns">
                    <span class="prefix"><?php echo $form->label($model, 'childs'); ?></span>
                </div>
                <div class="nine columns styled-select">
                    <?php
                    echo Select2::activeDropDownList($model, 'childs', array('1' => 'Ja', '0' => 'Nein'));
                    echo $form->error($model, 'childs');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="three columns">
                    <span class="prefix"><?php echo $form->label($model, 'parents'); ?></span>
                </div>
                <div class="nine columns styled-select">
                    <?php
                    echo Select2::activeDropDownList($model, 'parents', array('1' => 'Ja', '0' => 'Nein'));
                    echo $form->error($model, 'parents');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="three columns">
                    <span class="prefix"><?php echo $form->label($model, 'groups'); ?></span>
                </div>
                <div class="nine columns styled-select">
                    <?php
                    echo Select2::activeDropDownList($model, 'groups', array('1' => 'Ja', '0' => 'Nein'));
                    echo $form->error($model, 'groups');
                    ?>
                </div>
            </div>
        </fieldset>
    </div><!-- row -->
    <div class="row">
        <div class="twelve columns">
            <?php echo CHtml::submitButton(Yii::t('app', 'Entfernen'), array('class' => 'button')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->