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
    <div class="small-12 columns small-centered">
        <h2 class="text-center"><?php echo Yii::t('app', 'Schülerimport'); ?></h2>
    </div>
</div>
<div class="row">
    <div class="small-8 columns small-centered">
            <fieldset>
                <div>
                    <?php echo CHtml::submitButton(Yii::t('app', 'Absenden'), array('class' => 'small button')); ?>
                </div>
            </fieldset>
            <?php
            echo CHtml::endForm();
        ?>
    </div>
</div>

