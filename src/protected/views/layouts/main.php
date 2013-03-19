<?php
/**
 * Mainlayout
 */
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
 *
 * @var $this Controller */ ?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <?php Yii::app()->clientScript->registerPackage('css'); ?>
    <?php Yii::app()->clientScript->registerPackage('javascript'); ?>
    <link rel="stylesheet" type="text/css" media="print" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css">
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.foundation.js"></script>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
    <div class="wrapper">
        <!-- HEADER -->
        <div class="row contain-to-grid">
            <div class="five mobile-four columns offset-by-one">
                <div class="header">Elternsprechtag&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <div class="header-school-logo">
                    <div id="logo_artikel">der&nbsp;&nbsp;</div>
                    <img id="logo_school" src="<?php echo Yii::app()->request->baseUrl; ?>/img/logo.svg" alt="<?php echo Yii::app()->params['schoolName']?>">
                </div>
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
                            array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe002;">&nbsp;Ihre Termine</span>', 'url' => array('/Appointment/index',), 'visible' => !Yii::app()->user->isAdmin() && Yii::app()->user->checkAccessRole('2', '3')),
                            array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe00b;">&nbsp;Termine vereinbaren</span>', 'url' => array('/Appointment/getTeacher'), 'visible' => Yii::app()->user->checkAccess('3') && !Yii::app()->user->isAdmin()),
                            array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe007;">&nbsp;Elternsprechtagsverwaltung', 'url' => array('/Date/admin'), 'visible' => Yii::app()->user->checkAccess('0')),
                            array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe007;">&nbsp;Terminverwaltung', 'url' => array('/Appointment/admin'), 'visible' => Yii::app()->user->checkAccess('1')),
                            array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe00a;">&nbsp;Eltern und Kinder', 'url' => array('/ParentChild/admin'), 'visible' => Yii::app()->user->checkAccess('1')),
                            array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe00a;">&nbsp;Ihre Kinder', 'url' => array('/ParentChild/index'), 'visible' => Yii::app()->user->checkAccess('3') && !Yii::app()->user->isAdmin()),
                            array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe00a;">&nbsp;Benutzerverwaltung', 'url' => array('/User/admin'), 'visible' => Yii::app()->user->checkAccess('1')),
                            array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe007;">&nbsp;Tanverwaltung', 'url' => array('Tan/admin'), 'visible' => Yii::app()->user->checkAccess('1')),
                            array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe007;">&nbsp;Tanverwaltung', 'url' => array('Tan/genTans'), 'visible' => Yii::app()->user->checkAccess('2') && !Yii::app()->user->isAdmin()),
                            array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe007;">&nbsp;Ihr Account', 'url' => array('/User/account'), 'visible' => !Yii::app()->user->isGuest),
                            array('label' => '<span class="nav-icons" aria-hidden="true" data-icon="&#xe006;">&nbsp;Logout</span>', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)),
                        'activeCssClass' => 'active'
                    ));
                    ?>

                </div>
            </div> <? } ?>
        <div class="row">
            <div class="twelve columns centered">
                <?php if (Yii::app()->user->hasFlash('success')) { ?>
                    <div class="alert-box">
                        <?php echo Yii::app()->user->getFlash('success'); ?>
                    </div>
                <?php } else if (Yii::app()->user->hasFlash('failMsg')) { ?>
                    <div class="alert-box">
                        <?php echo Yii::app()->user->getFlash('failMsg'); ?>            
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php
        echo $content;
        ?>
        <div class="push"></div>
    </div> <!-- /WRAPPER -->
    <!-- FOOTER -->
    <div id="footer">
        <div class="row">
            <div class="twelve columns"><hr />
                <div class="row">
                    <div class="six columns">
                        <p>Copyright &copy; <?php echo date('Y'); ?> BWS Brühlwiesenschule Hofheim<br>
                        </p>
                    </div>
                    <div class="six columns">
                        <?php
                        $this->widget('zii.widgets.CMenu', array(
                            'htmlOptions' => array('class' => 'link-list right'),
                            'items' => array(
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