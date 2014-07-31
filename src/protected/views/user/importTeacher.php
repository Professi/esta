<?php
/**
 * CSV Upload Form um Lehrer zu importieren
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
/* @var $this UserController */
/* @var $model CsvUpload */
/* @var $form CActiveForm */
$this->setPageTitle('Lehrer importieren');
?>
<div class="row">
    <?php if (Yii::app()->params['randomTeacherPassword']) { ?>
        <div class="panel">
            <div class="row">
                <div class="two columns text-center">
                    <span aria-hidden="true" data-icon="&#xe011;" style="font-size:2.5em;"></span>
                </div>
                <div class="ten columns">
                    Da Sie in der Konfiguration die Option "Lehrerpasswörter bei deren Erstellung zufällig generieren?" aktiviert haben, kann der Lehrerimport sehr lange dauern.
                    Sollten Sie bei dem Import der Lehrer eine Fehlermeldung von PHP oder Ihrem Webserver erhalten, müssen Sie entweder zum Beispiel die "maximum_execution_time" hochsetzen oder Ihre CSV Datei aufteilen.
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="five columns centered">
        <fieldset>
            <legend>Lehrer importieren</legend>
            <?php
            $form = $this->beginWidget('CActiveForm', array('id' => 'csv-form', 'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),));
            echo $form->fileField($model, 'file');
            echo $form->error($model, 'file');
            echo CHtml::submitButton('Importieren', array('class' => 'button'));
            $this->endWidget();
            ?>
        </fieldset>
    </div>
</div>



