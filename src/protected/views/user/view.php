<?php
/**
 * View für einen einzelnen Benutzer
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
/* @var $model User */
$this->setPageTitle(Yii::app()->name . ' - ' .'Benutzerkonto');
$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->id,
);
$this->menu = array(
    array('label' => 'Benutzer anlegen', 'url' => array('create'),
        'visible' => Yii::app()->user->checkAccess(1)),
    array('label' => 'Benutzer bearbeiten', 'url' => array('update',
            'id' => $model->id), 'visible' => Yii::app()->user->checkAccess('1')),
    array('label' => 'Meine Daten aktualisieren', 'url' => array('update',
            'id' => $model->id), 'visible' => Yii::app()->user->checkAccessNotAdmin('2') || Yii::app()->user->checkAccessNotAdmin('3')),
    array('label' => 'Benutzer löschen', 'url' => '#',
        'linkOptions' => array('submit' => array('delete', 'id' => $model->id),
            'confirm' => 'Sind Sie sich sicher, dass Sie diesen Benutzer löschen möchten?'),
        'visible' => Yii::app()->user->checkAccess(1)),
    array('label' => 'Eltern-Kind-Verknüpfung anlegen', 'url' => array('parentChild/create', 'id' => $model->id),
        'visible' => (Yii::app()->user->checkAccess('1') && $model->role == 3)),
    array('label' => 'Termin anlegen', 'url' => array('appointment/create', 'parentId' => $model->id),
        'visible' => (Yii::app()->user->checkAccess('1') && $model->role == 3)),
    array('label' => 'Termin anlegen', 'url' => array('appointment/create', 'teacherId' => $model->id),
        'visible' => (Yii::app()->user->checkAccess('1') && $model->role == 2)),
    array('label' => 'Termin blockieren', 'url' => array('appointment/createBlockApp', 'teacherId' => $model->id),
        'visible' => (Yii::app()->user->checkAccess('1') && $model->role == 2)),
    array('label' => 'Benutzer verwalten', 'url' => array('admin'),
        'visible' => Yii::app()->user->checkAccess(1)),
);
?>
<div class="row">
    <div class="twelve columns centered">
        <h2 class="subheader">Benutzerdaten für <?php echo isset($model->email) ? $model->email : $model->username; ?> </h2>
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                array('name' => 'id', 'value' => $model->id,
                    'visible' => Yii::app()->user->checkAccess('0')),
                'email',
                array('name' => 'username',
                    'value' => $model->username, 'visible' => Yii::app()->user->checkAccess('0')),
                'firstname',
                'lastname',
                array('name' => 'stateName',
                    'value' => $model->getStateName()),
                array('name' => 'userRole',
                    //    'value' => Role::model()->findByAttributes(array('id' => $model->role))->title),
                    'value' => $model->userRole->role->title),
                array('name' => 'createtime',
                    'value' => date(Yii::app()->params['dateTimeFormat'], strtotime($model->createtime))),
                array('name' => 'badLogins',
                    'value' => $model->badLogins == null ? '0' : $model->badLogins,
                ),
                array('name' => 'groups',
                    'value' => $model->getGroupnames(),
                    'visible' => $model->role == '3' && Yii::app()->params['allowGroups'] && $model->groupCount > 0,
                ),
            ),
        ));
        if (Yii::app()->user->checkAccess('0') && empty($_GET['id'])) {
            ?> 
            <fieldset class="text-center">
                <p>Mit dem Dr&uuml;cken dieses Knopfes werden alle Daten aus der Datenbank gel&ouml;scht. Bet&auml;tigen Sie ihn nur wenn Sie sich absolut sicher sind!</p>
                <p>Nur die Admin- und Verwaltungsbenutzer bleiben bestehen</p>
                <img id="red-button" src="<?php echo Yii::app()->request->baseUrl; ?>/img/redbutton.png" alt="Der Rote Knopf" style="cursor:pointer;" >
                <p>Wenn Sie nur bestimmte Daten l&ouml;schen m&ouml;chten klicken Sie <?php echo CHtml::link('hier', array('site/deleteAll')); ?></p>
            </fieldset>
            <?php
        }
        if ($model->role == 3) {
            if (Yii::app()->user->getId() == $model->id && Yii::app()->params['allowGroups']) {
                ?>
                <h4 class="subheader">Weitere TAN hinzufügen</h4>
                <fieldset>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'user-form',
                    ));
                    ?>
                    <div class="row collapse">
                        <div class="three columns">
                            <span class="prefix"><?php echo $form->label($model, 'tan'); ?></span>
                        </div>
                        <div class="nine columns mobile-input">
                            <?php
                            echo $form->textField($model, 'tan', array('size' => 45, 'maxlength' => Yii::app()->params['tanSize']));
                            echo $form->error($model, 'tan');
                            ?>
                        </div>
                    </div>
                    <?php
                    echo CHtml::submitButton('Absenden', array('class' => 'button'));
                    $this->endWidget();
                    ?>
                </fieldset>

            <?php } if ($model->childCount > 0 && Yii::app()->user->checkAccess('1')) {
                ?>
                <h4 class="subheader">Kinder</h4>
                <?php foreach (ParentChild::model()->findAllByAttributes(array('user_id' => $model->id)) as $parentChild) {
                     $this->renderPartial('/parentChild/_view', array('data' => $parentChild));
                }
            }
        }
        ?>
    </div>
</div>
