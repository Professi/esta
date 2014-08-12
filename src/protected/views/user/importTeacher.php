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
$this->setPageTitle(Yii::t('app', 'Lehrer importieren'));
?>
<div class="row">
    <div class="panel">
        <div class="row">
            <div class="ten columns">
                <?php echo Yii::t('app', 'Man kann derzeit nur eine CSV Datei zum Import nutzen. Die CSV Datei muss folgende Informationen liefern:'); ?>
                <br/>
                <?php echo Yii::t('app', 'Nachname, Vorname, Email und Titel. Die Spaltennamen müssen in einer Kopfzeile angegeben sein.'); ?>
                <br/>
                <?php
                echo Yii::t('app', 'Falls ein Lehrer keine eingetragene E-Mail Adresse hat, so wird diesem eine E-Mail Adresse im Stil von m.mustermann@{domainname} generiert.', array('{domainname}' => $model->getDomainLink()));
                ?>
                <br/>
                <?php
                echo Yii::t('app', 'Die Maximalgröße einer Datei beträgt {size}.', array('{size}' => CsvUpload::getMaxSize()));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <?php if (Yii::app()->params['randomTeacherPassword']) { ?>
        <div class="panel">
            <div class="row">
                <div class="two columns text-center">
                    <span aria-hidden="true" data-icon="&#xe011;" style="font-size:2.5em;"></span>
                </div>
                <div class="ten columns">
                    <?php
                    echo Yii::t('app', 'Da Sie in der Konfiguration die Option "Lehrerpasswörter bei deren Erstellung zufällig generieren?" aktiviert haben, kann der Lehrerimport sehr lange dauern.');
                    echo Yii::t('app', 'Sollten Sie bei dem Import der Lehrer eine Fehlermeldung von PHP oder Ihrem Webserver erhalten, müssen Sie entweder zum Beispiel die "maximum_execution_time" hochsetzen oder Ihre CSV Datei aufteilen.');
                    ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="ten columns centered">
        <fieldset>
            <legend><?php echo Yii::t('app', 'Lehrer importieren'); ?></legend>
            <?php
            $form = $this->beginWidget('CActiveForm', array('id' => 'csv-form', 'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
            ));
            ?>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'file'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->fileField($model, 'file');
                    echo $form->error($model, 'file');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'delimiter'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'delimiter');
                    echo $form->error($model, 'delimiter');
                    ?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend><?php echo Yii::t('app', 'Spaltennamen in der Datei'); ?></legend>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'title'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'title');
                    echo $form->error($model, 'title');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'firstname'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'firstname');
                    echo $form->error($model, 'firstname');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'lastname'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'lastname');
                    echo $form->error($model, 'lastname');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="eight columns">
                    <span class="prefix"><?php echo $form->label($model, 'email'); ?></span>
                </div>
                <div class="four columns">
                    <?php
                    echo $form->textField($model, 'email');
                    echo $form->error($model, 'email');
                    ?>
                </div>
            </div>
            <?php
            echo CHtml::submitButton(Yii::t('app', 'Importieren'), array('class' => 'button'));
            $this->endWidget();
            ?>
        </fieldset>
    </div>
</div>




