<?php
/**
 * Formular um Schüler zu importieren
 */
/* * Copyright (C) 2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
$this->setPageTitle(Yii::t('app', 'Schülerimport'));
Yii::app()->clientScript->registerCssFile($this->assetsDir . "/css/select2.min.css");
?>
<div class="row">
    <div class="small-10 columns small-centered">
        <div class="panel">
            <?php echo Yii::t('app', 'Man kann derzeit nur eine CSV Datei zum Import nutzen. Die CSV Datei muss folgende Informationen liefern:'); ?>
            <br/>
            <?php echo Yii::t('app', 'Nachname und Vorname. Die Spaltennamen müssen in einer Kopfzeile angegeben sein.'); ?>
            <br/>
            <br/>
            <?php
            echo Yii::t('app', 'Die Maximalgröße einer Datei beträgt {size}.', array('{size}' => ByteConverter::getMaxSize()));
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="small-10 columns small-centered">
        <fieldset>
            <legend><?php echo Yii::t('app', 'Schüler importieren'); ?></legend>
            <?php
            $form = $this->beginWidget('CActiveForm', array('id' => 'csv-form', 'enableAjaxValidation' => true,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'errorMessageCssClass' => 'error',
                'skin' => false,
            ));
            ?>
            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix"><?php echo $form->label($model, 'file'); ?></span>
                </div>
                <div class="small-4 columns">
                    <div class="prefix button file-input">
                        <i class="fi-upload"></i><span>&nbsp;<?php echo Yii::t('app', 'Datei auswählen'); ?></span>
                        <?php
                        echo $form->fileField($model, 'file');
                        echo $form->error($model, 'file');
                        ?>
                        <script>
                            var maxFileSize = '<?php echo ByteConverter::getMaxSizeInBytes(); ?>';
                            var errorMessage = '<?php echo Yii::t('app', 'Die ausgewählte Datei übersteigt die maximale Dateigröße.'); ?>';
                        </script>
                    </div>
                </div>
                <div class="small-4 columns">
                    <input type="text" value="" name="" id="file-input-name" readonly="readonly">
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'delimiter'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'delimiter');
                    echo $form->error($model, 'delimiter');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'firstname'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'firstname');
                    echo $form->error($model, 'firstname');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'lastname'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'lastname');
                    echo $form->error($model, 'lastname');
                    ?>
                </div>
            </div>
        </fieldset>

        <?php
        echo CHtml::submitButton(Yii::t('app', 'Importieren'), array('class' => 'button'));
        $this->endWidget();
        ?>
    </div>

