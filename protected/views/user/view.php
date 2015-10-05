<?php
/**
 * View für einen einzelnen Benutzer
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
 * @var $model User 
 */
$this->setPageTitle(Yii::t('app', 'Benutzerkonto'));
$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->id,
);
$this->menu = array(
    array('label' => Yii::t('app', 'Benutzer anlegen'),
        'url' => array('create'),
        'visible' => Yii::app()->user->checkAccess(MANAGEMENT),
        'linkOptions' => array('class' => 'small button')),
    array('label' => Yii::t('app', 'Benutzer bearbeiten'),
        'url' => array('update',
            'id' => $model->id),
        'visible' => Yii::app()->user->checkAccess(MANAGEMENT),
        'linkOptions' => array('class' => 'small button')),
    array('label' => Yii::t('app', 'Meine Daten aktualisieren'),
        'url' => array('update',
            'id' => $model->id),
        'visible' => Yii::app()->user->checkAccessNotAdmin(TEACHER) || Yii::app()->user->checkAccessNotAdmin(PARENTS),
        'linkOptions' => array('class' => 'small button')),
    array('label' => Yii::t('app', 'Benutzer löschen'),
        'url' => '#',
        'linkOptions' => array('submit' => array('delete', 'id' => $model->id),
            'confirm' => Yii::t('app', 'Sind Sie sich sicher, dass Sie diesen Benutzer löschen möchten?'),
            'class' => 'small button',
            'csrf' => true),
        'visible' => Yii::app()->user->checkAccess(MANAGEMENT)),
    array('label' => Yii::t('app', 'Eltern-Kind-Verknüpfung anlegen'),
        'url' => array('parentChild/create', 'id' => $model->id),
        'visible' => (Yii::app()->user->checkAccess(MANAGEMENT) && $model->role == (int) PARENTS),
        'linkOptions' => array('class' => 'small button')),
    array('label' => Yii::t('app', 'Termin anlegen'),
        'url' => array('appointment/create', 'parentId' => $model->id),
        'visible' => (Yii::app()->user->checkAccess(MANAGEMENT) && $model->role == (int) PARENTS),
        'linkOptions' => array('class' => 'small button')),
    array('label' => Yii::t('app', 'Termin anlegen'),
        'url' => array('appointment/create', 'teacherId' => $model->id),
        'visible' => (Yii::app()->user->checkAccess(MANAGEMENT) && $model->role == (int) TEACHER),
        'linkOptions' => array('class' => 'small button')),
    array('label' => Yii::t('app', 'Termin blockieren'),
        'url' => array('appointment/createBlockApp', 'teacherId' => $model->id),
        'visible' => (Yii::app()->user->checkAccess(MANAGEMENT) && $model->role == (int) TEACHER),
        'linkOptions' => array('class' => 'small button')),
    array('label' => Yii::t('app', 'Benutzer verwalten'),
        'url' => array('admin'),
        'visible' => Yii::app()->user->checkAccess(MANAGEMENT),
        'linkOptions' => array('class' => 'small button')),
);
?>
<div class="row">
    <div class="small-12 columns small-centered">
        <h2 class="subheader text-center"><?php echo Yii::t('app', 'Benutzerdaten für {username}', array('{username}' => $model->email)); ?> </h2>
        <div class="row">
            <div class="small-12 columns small-centered">
                <?php
                $this->widget('zii.widgets.CDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array('name' => 'id', 'value' => $model->id,
                            'visible' => Yii::app()->user->checkAccess(ADMIN)),
                        'email',
                        'firstname',
                        'lastname',
                        array('name' => 'stateName',
                            'value' => $model->getStateName($model->state)),
                        array('name' => 'role',
                            'value' => User::getFormattedRole($model->role)),
                        array('name' => 'createtime',
                            'value' => Yii::app()->dateFormatter->formatDateTime($model->createtime, "short", "short")),
                        array('name' => 'lastLogin',
                            'value' => Yii::app()->dateFormatter->formatDateTime($model->lastLogin, "short", "short")),
                        array('name' => 'badLogins',
                            'value' => $model->badLogins == null ? '0' : $model->badLogins,
                            'visible' => $model->id != Yii::app()->user->getId()),
                        array('name' => 'groups',
                            'value' => $model->getGroupnames(),
                            'visible' => $model->role > 1 && Yii::app()->params['allowGroups'] && $model->groupcount > 0,
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
        <?php
        if (Yii::app()->user->checkAccess(ADMIN) && empty($_GET['id'])) {
            ?> 
            <fieldset class="text-center">
                <p><?php echo Yii::t('app', 'Mit dem Drücken dieses Knopfes werden alle Daten aus der Datenbank gelöscht. Betätigen Sie ihn nur wenn Sie sich absolut sicher sind!'); ?></p>
                <p><?php echo Yii::t('app', 'Nur die Admin- und Verwaltungsbenutzer bleiben bestehen'); ?></p>
                <img id="red-button" src="<?php echo $this->assetsDir; ?>/img/redbutton.png" alt="<?php echo Yii::t('app', 'Der Rote Knopf'); ?>" style="cursor:pointer;" >
                <p><?php echo Yii::t('app', 'Wenn Sie nur bestimmte Daten löschen möchten klicken Sie') . ' ' . CHtml::link(Yii::t('app', 'hier'), array('site/deleteAll')) . '.'; ?></p>
            </fieldset>
            <?php
        }
        if ($model->role == PARENTS) {
            if (Yii::app()->user->getId() == $model->id && Yii::app()->params['allowGroups']) {
                ?>
                <h4 class="subheader"><?php echo Yii::t('app', 'Weitere TAN hinzufügen'); ?></h4>
                <fieldset>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'user-form',
                        'errorMessageCssClass' => 'error',
                        'skin' => false,
                    ));
                    ?>
                    <div class="row collapse">
                        <div class="small-3 columns">
                            <span class="prefix"><?php echo $form->label($model, 'tan'); ?></span>
                        </div>
                        <div class="small-9 columns mobile-input">
                            <?php
                            echo $form->textField($model, 'tan', array('size' => 45, 'maxlength' => Yii::app()->params['tanSize']));
                            echo $form->error($model, 'tan');
                            ?>
                        </div>
                    </div>
                    <?php
                    echo CHtml::submitButton(Yii::t('app', 'Absenden'), array('class' => 'small button'));
                    $this->endWidget();
                    ?>
                </fieldset>
            <?php } if ($model->childcount > 0 && Yii::app()->user->checkAccess(MANAGEMENT)) {
                ?>
                <h4 class="subheader"><?php echo Yii::t('app', 'Kinder'); ?></h4>
                <?php
                foreach (ParentChild::model()->findAllByAttributes(array('user_id' => $model->id)) as $parentChild) {
                    $this->renderPartial('/parentChild/_view', array('data' => $parentChild));
                }
            }
        }
        ?>
    </div>
</div>
