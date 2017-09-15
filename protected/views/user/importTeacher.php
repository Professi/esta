<?php
/**
 * CSV Upload Form um Lehrer zu importieren
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
 * @var $this UserController
 * @var $model CsvUpload
 * @var $form CActiveForm
 */
$this->setPageTitle(Yii::t('app', 'Lehrer importieren'));
Yii::app()->clientScript->registerCssFile($this->assetsDir."/css/select2.min.css");
?>

<div class="row">
    <div class="small-10 columns small-centered">
        <div class="panel">
            <?php echo Yii::t('app', 'Man kann derzeit nur eine CSV Datei zum Import nutzen. Die CSV Datei muss folgende Informationen liefern:'); ?>
            <br/>
            <?php echo Yii::t('app', 'Nachname, Vorname, Email und Titel. Die Spaltennamen müssen in einer Kopfzeile angegeben sein.'); ?>
            <br/>
            <?php
            echo Yii::t('app', 'Falls ein Lehrer keine eingetragene E-Mail Adresse hat, so wird diesem eine E-Mail Adresse im Stil von m.mustermann@{domainname} generiert.', array('{domainname}' => $model->getDomainLink()));
            ?>
            <br/>
            <?php
            echo Yii::t('app', 'Die Maximalgröße einer Datei beträgt {size}.', array('{size}' => ByteConverter::getMaxSize()));
            ?>
        </div>
    </div>
</div>
<?php if (Yii::app()->params['randomTeacherPassword']) {
                ?>
    <div class="row">
        <div class="small-10 columns small-centered">
            <div class="panel">
                <div class="row">

                    <div class="small-2 columns text-center">
                        <i class="fi-alert callout-icon"></i>
                    </div>
                    <div class="small-10 columns">
                        <?php
                        echo Yii::t('app', 'Da Sie in der Konfiguration die Option "Lehrerpasswörter bei deren Erstellung zufällig generieren?" aktiviert haben, kann der Lehrerimport sehr lange dauern.'). '<br>';
                echo Yii::t('app', 'Sollten Sie bei dem Import der Lehrer eine Fehlermeldung von PHP oder Ihrem Webserver erhalten, müssen Sie in der php.ini die "maximum_execution_time" hochsetzen oder Ihre CSV Datei aufteilen.'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
            } ?>
<div class="row">
    <div class="small-10 columns small-centered">
        <?php
        $form = $this->beginWidget('CActiveForm', array('id' => 'csv-form', 'enableAjaxValidation' => true,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
            'errorMessageCssClass' => 'error',
            'skin' => false,
        ));
        ?>
        <fieldset>
            <legend><?php echo Yii::t('app', 'Lehrer importieren'); ?></legend>
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
                        <script type="text/javascript">
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
        </fieldset>
        <fieldset>
            <legend><?php echo Yii::t('app', 'Spaltennamen in der Datei'); ?></legend>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'title'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'title');
                    echo $form->error($model, 'title');
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
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'email'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'email');
                    echo $form->error($model, 'email');
                    ?>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend><?php echo Yii::t('app', 'E-Mail Generierung'); ?></legend>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix infofeld"><?php echo $form->label($model, 'mailMask', array('class' => 'infolabel')); ?></span>

                    <div class="infotext">
                        <span aria-hidden="true" data-icon="&#xe012;"></span>
                        <?php echo Yii::t('app', 'Vorname und Nachname müssen exakt so geschrieben sein wie es der Standardwert in diesem Textfeld vorgibt.'); ?>
                    </div>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'mailMask');
                    echo $form->error($model, 'mailMask');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'firstNameMailMask'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'firstNameMailMask', $model->selectableNameMask('firstname'), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'firstNameMailMask');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'lastNameMailMask'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'lastNameMailMask', $model->selectableNameMask('lastname'), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'lastNameMailMask');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix"><?php echo $form->label($model, 'mailDomain'); ?></span>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo $form->textField($model, 'mailDomain');
                    echo $form->error($model, 'mailDomain');
                    ?>
                </div>
            </div>
            <div class="row collapse">
                <div class="small-8 columns">
                    <span class="prefix infofeld"><?php echo $form->label($model, 'doubleNameSeperator', array('class' => 'infolabel')); ?></span>
                    <div class="infotext">
                        <span aria-hidden="true" data-icon="&#xe012;"></span>
                        <?php echo Yii::t('app', 'Beispiel: Max Heinz; Wenn ja: max-heinz; Wenn nein: maxheinz'); ?>
                    </div>
                </div>
                <div class="small-4 columns">
                    <?php
                    echo Select2::activeDropDownList($model, 'doubleNameSeperator', $model->getBooleanSelectables(), array('select2Options' => array('minimumResultsForSearch' => 10)));
                    echo $form->error($model, 'doubleNameSeperator');
                    ?>
                </div>
            </div>
        </fieldset>
        <?php
        echo CHtml::submitButton(Yii::t('app', 'Importieren'), array('class' => 'button'));
        $this->endWidget();
        ?>
    </div>
</div>
