<?php
$this->breadcrumbs=array(
	UserModule::t('Profile Fields')=>array('admin'),
	UserModule::t('Create'),
);
$this->widget('zii.widgets.CMenu', array(
    'htmlOptions' => array('class' => 'button-group'),
    'activeCssClass' => 'disabled',
    'items' => array(
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin')),
)));
?>
<h1><?php echo UserModule::t('Create Profile Field'); ?></h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>