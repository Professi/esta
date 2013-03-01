<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<meta name="language" content="de" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/foundation.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/icons.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/app.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.foundation.js"></script>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer" class="footer">
		<div class="row">
			<div class="twelve columns"><hr />
				<div class="row">
					<div class="six columns">
						<p>Copyright &copy; <?php echo date('Y'); ?> by no one at all. Go to town.</p>
					</div>
					<div class="six columns">
						<ul class="link-list right">
							<li><a href="impressum.tpl">Impressum</a></li>
							<li><a href="#">Link 2</a></li>
							<li><a href="#">Link 3</a></li>
							<li><a href="#">Link 4</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div> 	<!-- /FOOTER -->
			<!-- MODALS -->
		<div id="MenuModal" class="reveal-modal [small]" style="padding:0;border-radius:5px;">
			<ul class="nav-bar vertical" style="margin-bottom:0;">
				<li class="active"><a href=""><span class="nav-icons" aria-hidden="true" data-icon="&#xe00b;">&nbsp;Termine vereinbaren</span></a></li>
				<li class=""><a href="./termine.tpl"><span class="nav-icons" aria-hidden="true" data-icon="&#xe002;">&nbsp;Ihre Termine</span></a></li>
				<li class=""><a href="./error.tpl"><span class="nav-icons" aria-hidden="true" data-icon="&#xe006;">&nbsp;Logout</span></a></li>
			</ul>
			<a class="close-reveal-modal" data-icon="&#xe014;" style="color:#fff;"></a>
		</div>
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
</body>
</html>
