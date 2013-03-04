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
<body class="off-canvas hide-extras">
    <div class="wrapper">
        <!-- HEADER -->
        <div class="row contain-to-grid">
            <div class="five mobile-four columns offset-by-one">
                <h1 class="header">Elternsprechtag</h1>
            </div>
        </div>
        <a href="" data-reveal-id="MenuModal">
            <div class="row contain-to-grid sticky">
                <div class="twelve columns text-center">
                    <span class="" aria-hidden="true" data-icon="&#xe016;" style="font-size:2em;color:#fff;">&nbsp;Menü</span>
                </div>
            </div></a>
        <div class="push"></div>
        <div class="row">
            <!-- CONTENT -->
            <div class="twelve columns">
                <?php echo $content; ?>
            </div><!-- /CONTENT -->
        </div><!-- /ROW MAIN LEVEL -->
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
        $this->widget('zii.widgets.CMenu', array(
            'htmlOptions' => array('class' => 'nav-bar vertical', 'style' => 'margin-bottom:0;'),
            'encodeLabel' => false,
            'items' => array(
                array('label' => 'Home', 'url' => array('/site/index')),
            //    array('label' => 'Rechteverwaltung', 'url' => array('/rights'), 'visible'=>!Yii::app()->user->isGuest&&Yii::app()->user->getIsSuperuser()),
                array('label' => 'Benutzerverwaltung', 'url' => array('user/user/admin'), 'visible' => !Yii::app()->user->isAdmin()),
          
                array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe00b;">&nbsp;Termine vereinbaren</span>', 'url' => array(''), 'visible' => !Yii::app()->user->isGuest),
                array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe002;">&nbsp;Ihre Termine</span>', 'url' => array(''), 'visible' => !Yii::app()->user->isGuest),
                array('label' => 'Login', 'url' => array('/user/login'), 'visible' => Yii::app()->user->isGuest),
                array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe006;">&nbsp;Logout (' . Yii::app()->user->name . ')</span>', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)),
            'activeCssClass' => 'active'
        ));
        ?> 
        <a class="close-reveal-modal" data-icon="&#xe014;" style="color:#fff;"></a>
    </div>
    <!-- SKRIPTE -->
    <!-- Einbinden der JS Files (Minified) -->
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation.min.js"></script>
    <!-- Initialisieren der JS Plugins -->
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
</body>
</html>
