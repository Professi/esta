<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'Benutzer erstellen', 'url' => array('create'), 'visible'=>Yii::app()->user->isGuest || Yii::app()->user->checkAccess(1)),
    array('label' => 'Benutzer aktualisieren', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Benutzer löschen', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Sind Sie sich sicher dass Sie diesen Benutzer löschen möchten?'), 'visible'=> Yii::app()->user->checkAccess(1)),
    array('label' => 'Benutzer verwalten', 'url' => array('admin'), 'visible'=>Yii::app()->user->checkAccess(1)),
);
?>

<h1>Benutzerinformationen <?php echo $model->email; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'email',
        'firstname',
        'lastname',
        'state',
        array('label'=>'Rolle','value'=>Role::model()->findByAttributes(array('id'=>Yii::app()->user->role))->title),
        array('label'=>'Benutzerid','value'=>$model->id,'visible'=>Yii::app()->user->checkAccess('0')),
        array('label'=>'Benutzername','value'=>$model->username,'visible'=>Yii::app()->user->checkAccess('0')),
        array('label'=>'Passwort','value'=>$model->password,'visible'=>Yii::app()->user->checkAccess('0')),
        array('label'=>'Registrierung am','value'=>date(Yii::app()->params['dateTimeFormat'],$model->createtime)),
    ),
));
?>
