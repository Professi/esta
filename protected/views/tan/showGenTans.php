<?php
/**
 * Anzeige der generierten TANs
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
/* @var $this TanController */
/* @var $model tan */
$this->setPageTitle(Yii::t('app', 'Generierte TANs'));
?>
<div class="row">
    <div class="small-12 columns small-centered">
        <h2 class="text-center"><?php echo Yii::t('app', 'Generierte TANs');?></h2>
    </div>
</div>
<div class="row">
    <div class="small-5 columns small-centered">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $dataProvider,
            'columns' => array(
                array('name' => Yii::t('app', 'TAN'), 'value' => '$data->tan',),
                array('name' => Yii::t('app', 'Vorname'), 'value' => '$data->child->firstname', 'visible' => !Yii::app()->params['allowParentsToManageChilds']),
                array('name' => Yii::t('app', 'Nachname'), 'value' => '$data->child->lastname', 'visible' => !Yii::app()->params['allowParentsToManageChilds']),
            )
        ));
        ?>
        <p class="text-center"><?php echo CHtml::link('<b>' . Yii::t('app', 'Zurück zur vorherigen Seite') . '</b>', 'index.php?r=Tan/genTans'); ?> </p>
    </div>
</div>