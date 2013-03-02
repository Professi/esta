<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('admin'),
	UserModule::t('Create'),
);

$this->widget('zii.widgets.CMenu', array(
    'htmlOptions' => array('class' => 'button-group'),
    'activeCssClass' => 'disabled',
    'items' => array(
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
)));
?>
<h1><?php echo UserModule::t("Create User"); ?></h1>

<?php
	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile));
?>