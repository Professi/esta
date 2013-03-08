<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <!-- Foundation Styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/foundation.min.css" />
    <!-- Symbole & Fonts -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/icons.css" />
    <!-- Overrides -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/app.css" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.foundation.js"></script>
</head>
<body>
    <div class="wrapper">
        <!-- HEADER -->
        <div class="row contain-to-grid">
            <div class="five mobile-four columns offset-by-one">
                <h1 class="header">Elternsprechtag</h1>
            </div>
        </div>
		<div class="row contain-to-grid sticky" id="js_menu" style="visibility:hidden">
			<div class="twelve columns text-center">
				<a href="" data-reveal-id="MenuModal" >
					<span class="menu-icon" aria-hidden="true" data-icon="&#xe016;">&nbsp;Menü</span>
				</a>
			</div>
		</div>
        <div class="push"></div>
		<div class="row hide-for-small" id="nojs_menu">
			<div class="three columns">
				<?php 
				if (!Yii::app->userIsGuest) {
					$this->widget('zii.widgets.CMenu', array(
						'htmlOptions' => array('class' => 'nav-bar vertical'),
						'encodeLabel' => false,
						'items' => array(
							array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe00b;">&nbsp;Termine vereinbaren</span>', 'url' => array('/Appointment/create'), 'visible' => !Yii::app()->user->isGuest),
							array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe002;">&nbsp;Ihre Termine</span>', 'url' => array('/Appointment/index',), 'visible' => !Yii::app()->user->isGuest),
							array('label' => 'Schülerverwaltung', 'url' => array('/Child/index'), 'visible' => !Yii::app()->user->isGuest),
							array('label' => 'Datumsverwaltung', 'url' => array('/Date/index'), 'visible' => !Yii::app()->user->isGuest),
							array('label' => 'Terminverwaltung', 'url' => array('/Appointment/index'), 'visible' => !Yii::app()->user->isGuest),
							array('label' => 'Elternkindverknüpfung', 'url' => array('/ParentChild/index'), 'visible' => !Yii::app()->user->isGuest),
							array('label' => 'Rollenverwaltung', 'url' => array('/Role/index'), 'visible' => !Yii::app()->user->isGuest),
							array('label' => 'Benutzerverwaltung', 'url' => array('/User/index'), 'visible' => !Yii::app()->user->isGuest),
							array('label' => 'Rollenzuweisung', 'url' => array('/UserRole/index'), 'visible' => !Yii::app()->user->isGuest),
							array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe006;">&nbsp;Logout (' . Yii::app()->user->name . ')</span>', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)),
						'activeCssClass' => 'active'
					));
				} ?>
			</div>
		</div>
			<?php echo $content; ?>
        <div class="push"></div>
    </div> <!-- /WRAPPER -->
    <!-- FOOTER -->
    <div id="footer">
        <div class="row">
            <div class="twelve columns"><hr />
                <div class="row">
                    <div class="six columns">
                        <p>Copyright &copy; <?php echo date('Y'); ?> by no one at all. Go to town.<br/></p>
                        <?php echo Yii::powered(); ?>
                    </div>
                    <div class="six columns">
                        <?php
                        $this->widget('zii.widgets.CMenu', array(
                            'htmlOptions' => array('class' => 'link-list right'),
                            'items' => array(
                                array('label' => 'Über', 'url' => array('/site/page', 'view' => 'about')),
                                array('label' => 'Impressum', 'url' => array('/site/page', 'view' => 'impressum')),
                                array('label' => 'Kontakt', 'url' => array('/site/contact')
                        ))));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div> 	<!-- /FOOTER -->
    <!-- MODALS -->
    <div id="MenuModal" class="reveal-modal [small]" style="padding:0;border-radius:5px;">
        <?php
		if (!Yii::app->userIsGuest) {
			$this->widget('zii.widgets.CMenu', array(
				'htmlOptions' => array('class' => 'nav-bar vertical'),
				'encodeLabel' => false,
				'items' => array(
					array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe00b;">&nbsp;Termine vereinbaren</span>', 'url' => array('/Appointment/create'), 'visible' => !Yii::app()->user->isGuest),
					array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe002;">&nbsp;Ihre Termine</span>', 'url' => array('/Appointment/index',), 'visible' => !Yii::app()->user->isGuest),
					array('label' => 'Schülerverwaltung', 'url' => array('/Child/index'), 'visible' => !Yii::app()->user->isGuest),
					array('label' => 'Datumsverwaltung', 'url' => array('/Date/index'), 'visible' => !Yii::app()->user->isGuest),
					array('label' => 'Terminverwaltung', 'url' => array('/Appointment/index'), 'visible' => !Yii::app()->user->isGuest),
					array('label' => 'Elternkindverknüpfung', 'url' => array('/ParentChild/index'), 'visible' => !Yii::app()->user->isGuest),
					array('label' => 'Rollenverwaltung', 'url' => array('/Role/index'), 'visible' => !Yii::app()->user->isGuest),
					array('label' => 'Benutzerverwaltung', 'url' => array('/User/index'), 'visible' => !Yii::app()->user->isGuest),
					array('label' => 'Rollenzuweisung', 'url' => array('/UserRole/index'), 'visible' => !Yii::app()->user->isGuest),
					array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe006;">&nbsp;Logout (' . Yii::app()->user->name . ')</span>', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)),
				'activeCssClass' => 'active'
			));
        } ?> 
        <a class="close-reveal-modal" data-icon="&#xe014;" style="color:#fff;"></a>
    </div>
    <!-- SKRIPTE -->
    <!-- Einbinden der JS Files (Minified) -->
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation.min.js"></script>
    <!-- Initialisieren der JS Plugins -->
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
	<!--Einbinden eigener Funktionalitäten -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js"></script>
</body>
</html>
