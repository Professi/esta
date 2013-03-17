<?php
/**Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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

$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'Benutzer anlegen', 'url' => array('create'), 'visible'=>Yii::app()->user->isGuest || Yii::app()->user->checkAccess(1)),
    array('label' => 'Benutzer bearbeiten', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Benutzer löschen', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Sind Sie sich sicher dass Sie diesen Benutzer löschen möchten?'), 'visible'=> Yii::app()->user->checkAccess(1)),
    array('label' => 'Benutzer verwalten', 'url' => array('admin'), 'visible'=>Yii::app()->user->checkAccess(1)),
);
?>

<div class="row">
    <div class="twelve columns centered">
<h2 class="subheader">Benutzerdaten für <?php echo $model->email; ?> </h2>
<?php 
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'email',
        'firstname',
        'lastname',
        array('label'=>'Status','value'=>$model->getStateName()),
        array('label'=>'Rolle','value'=>Role::model()->findByAttributes(array('id'=>$model->role))->title),
        array('label'=>'Benutzer-ID','value'=>$model->id,'visible'=>Yii::app()->user->checkAccess('0')),
        array('label'=>'Benutzername','value'=>$model->username,'visible'=>Yii::app()->user->checkAccess('0')),
        //array('label'=>'Passwort','value'=>$model->password,'visible'=>Yii::app()->user->checkAccess('0')),
        array('label'=>'Registrierung am','value'=>date(Yii::app()->params['dateTimeFormat'],$model->createtime)),
    ),
));
?>
<?php if (Yii::app()->user->checkAccess('0')) { ?>
<fieldset class="text-center">
    <p>Mit dem Dr&uuml;cken dieses Knopfes werden alle Daten aus der Datenbank gel&ouml;scht. Bet&auml;tigen Sie ihn nur wenn Sie sich absolut sicher sind!</p>
    <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/redbutton.png" alt="Der Rote Knopf" >
</fieldset>
<?php } ?>
    </div>
</div>
