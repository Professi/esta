<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'Benutzerliste', 'url' => array('index')),
    array('label' => 'Benutzer erstellen', 'url' => array('create')),
    array('label' => 'Benutzer aktualisieren', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Benutzer löschen', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Benutzer verwalten', 'url' => array('admin')),
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
