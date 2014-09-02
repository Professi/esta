<?php
/**
 * Anzeige der eingetragenen Kinder eines Benutzers
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
/* @var $this ParentChildController */
/* @var $dataProvider CActiveDataProvider */
$this->setPageTitle(Yii::t('app', "Ihre Kinder"));
$this->breadcrumbs = array(
    'Parent Children',
);
$this->menu = array(
    array(  'label' => Yii::t('app', 'Kind hinzufügen'), 
            'url' => array('create'), 
            'visible' => Yii::app()->params['allowParentsToManageChilds'] || Yii::app()->user->checkAccess(MANAGEMENT),
            'linkOptions' => array('class' => 'small button')),
    array(  'label' => Yii::t('app', 'Termin vereinbaren'), 
            'url' => array('appointment/getTeacher'),
            'linkOptions' => array('class' => 'small button')),
    array(  'label' => Yii::t('app', 'Verwalte Elternkindverknüpfungen'), 
            'url' => array('admin'), 'visible' => Yii::app()->user->checkAccess(MANAGEMENT),
            'linkOptions' => array('class' => 'small button')),
);
?>
<div class="row">
    <div class="small-12 columns">
        <h2 class="subheader">Ihre Kinder</h2>
        <hr/>
        <div class="paper panel hide-for-print">
            <?php
            if (Yii::app()->params['allowParentsToManageChilds']) {
                echo Yii::t('app', 'Falls Sie bei der Eingabe Ihrer Kinder einen Fehler gemacht haben sollten, drücken Sie einfach auf das "x" neben dem Namen. Der Eintrag wird daraufhin entfernt und Sie können eine neue Eingabe über "Kind hinzufügen" tätigen.');
            } else {
                echo Yii::t('app', 'Falls die Daten Ihrer Kinder fehlerhaft oder Kinder nicht eingetragen sind, können Sie sich über das Kontaktformular an die Verwaltung wenden. Bitte beachen Sie, dass Sie weitere TANs unter "Ihr Benutzerkonto" hinzufügen können. Jede TAN ist mit einem Kind verknüpft.');
            }
            ?>
        </div>
        <?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'summaryText' => '',
            'itemView' => '_view',
        ));
        ?>
    </div>
</div>