<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <?php Yii::app()->clientScript->registerPackage('css'); ?>
    <?php Yii::app()->clientScript->registerPackage('javascript'); ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
    <div class="wrapper">
        <!-- HEADER -->
        <div class="row contain-to-grid">
            <div class="five mobile-four columns offset-by-one">
                <h1 class="header">Elternsprechtag</h1>
            </div>
        </div>
        <?php if (!Yii::app()->user->isGuest) { ?>
            <div class="row contain-to-grid sticky" id="js_menu" style="visibility:hidden">
                <div class="twelve columns text-center">
                    <a href="" data-reveal-id="MenuModal" >
                        <span class="menu-icon" aria-hidden="true" data-icon="&#xe016;">&nbsp;Menü</span>
                    </a>
                </div>
            </div> <? } ?>
        <div class="push"></div>
        <?php if (!Yii::app()->user->isGuest) { ?>
            <div class="row hide-for-small" id="nojs_menu">
                <div class="three columns">
                    <?
                    $this->widget('zii.widgets.CMenu', array(
                        'htmlOptions' => array('class' => 'nav-bar vertical'),
                        'encodeLabel' => false,
                        'items' => array(//0=Administration 1=Verwaltung 2= Lehrer 3=Eltern
                            array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe00b;">&nbsp;Termine vereinbaren</span>', 'url' => array('/Appointment/create'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe002;">&nbsp;Ihre Termine</span>', 'url' => array('/Appointment/index',), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Schülerverwaltung', 'url' => array('/Child/index'), 'visible' => Yii::app()->user->checkAccess('1')),
                            array('label' => 'Datumsverwaltung', 'url' => array('/Date/admin'), 'visible' => Yii::app()->user->checkAccess('0')),
                            array('label' => 'Terminverwaltung', 'url' => array('/Appointment/index'), 'visible' => Yii::app()->user->checkAccess('1')),
                            array('label' => 'Elternkindverknüpfung', 'url' => array('/ParentChild/admin'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => 'Rollenverwaltung', 'url' => array('/Role/index'), 'visible' => Yii::app()->user->checkAccess('0')),
                            array('label' => 'Benutzerverwaltung', 'url' => array('/User/admin'), Yii::app()->user->checkAccess('1')),
                            array('label' => 'Rollenzuweisung', 'url' => array('/UserRole/admin'), Yii::app()->user->checkAccess('1')),
                            array('label' => 'Ihr Account', 'url' => array('/User/view&id=' . Yii::app()->user->getId()), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe006;">&nbsp;Logout (' . Yii::app()->user->name . ')</span>', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)),
                        'activeCssClass' => 'active'
                    ));
                    ?>

                </div>
            </div> <? } ?>
        <?php echo $content; ?>
        <div class="push"></div>
    </div> <!-- /WRAPPER -->
    <!-- FOOTER -->
    <div id="footer">
        <div class="row">
            <div class="twelve columns"><hr />
                <div class="row">
                    <div class="six columns">
                        <p>Copyright &copy; <?php echo date('Y'); ?> BWS Brühlwiesenschule Hofheim<br/></p>
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
    <div id="MenuModal" class="reveal-modal [small] nav-menu">
    </div>
</body>
</html>
