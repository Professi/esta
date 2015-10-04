<?php
/**
 * Elternsprechtag anschauen
 */
/* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
/* @var $this DateController */
/* @var $model Date */
$this->setPageTitle(Yii::t('app', 'Detailansicht Elternsprechtag'));
$this->breadcrumbs = array(
    'Dates' => array('index'),
    $model->id,
);
$this->menu = array(
    array('label' => Yii::t('app', 'Elternsprechtag bearbeiten'),
        'url' => array('update', 'id' => $model->id),
        'linkOptions' => array('class' => 'small button')),
    array('label' => Yii::t('app', 'Elternsprechtag löschen'),
        'url' => '#',
        'linkOptions' => array('submit' => array('delete', 'id' => $model->id),
            'confirm' => Yii::t('app', 'Möchten Sie diesen Elternsprechtag wirklich löschen?'),
            'class' => 'small button',
            'csrf' => true)),
    array('label' => Yii::t('app', 'Elternsprechtage verwalten'),
        'url' => array('admin'),
        'linkOptions' => array('class' => 'small button')),
);
?>
<div class="row">
    <div class="small-12 columns small-centered">
        <h2 class="text-center"><?php echo Yii::t('app', 'Elternsprechtag - {id} - {title}', array('{id}' => Yii::app()->dateFormatter->formatDateTime(strtotime($model->date), "short", null), '{title}' => $model->title)); ?></h2>
    </div>
</div>
<div class="row">
    <div class="small-12 columns small-centered">
        <?php
        Yii::app()->dateFormatter->formatDateTime(strtotime($model->end), null, "short");
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                array('name' => 'date', 'value' => Yii::app()->dateFormatter->formatDateTime(strtotime($model->date), "short", null)),
                array('name' => 'begin', 'value' => Yii::app()->dateFormatter->formatDateTime(strtotime($model->begin), null, "short")),
                array('name' => 'end', 'value' => Yii::app()->dateFormatter->formatDateTime(strtotime($model->end), null, "short")),
                array('name' => 'lockAt', 'value' => Yii::app()->dateFormatter->formatDateTime($model->lockAt, "short", "short")),
                array('name' => 'title', 'visible' => !empty($model->title)),
                array('name' => 'groups', 'value' => $model->getGroupnames(), 'visible' => (Yii::app()->params['allowGroups']) && !empty($model->groups)),
            ),
        ));
        ?>
    </div>
</div>
