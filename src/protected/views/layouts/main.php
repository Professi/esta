<?php
/**
 * Mainlayout
 */
/* Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
/** @var $this Controller */
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="<?php echo Yii::app()->params['language']; ?>"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="<?php echo Yii::app()->params['language']; ?>"><!--<![endif]-->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="<?php echo $this->assetsDir; ?>/favicon.ico">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->assetsDir; ?>/favicon.ico">
        <script type="text/javascript" src="<?php echo $this->assetsDir; ?>/js/modernizr.foundation.js"></script>
        <script type="text/javascript">/*<![CDATA[*/ var path = '<?php echo $this->assetsDir; ?>';/*]]>*/</script>
        <?php $this->registerScripts(); ?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <div class="wrapper">
            <!-- HEADER -->
            <div class="row contain-to-grid" id="header_row">
                <div class="eleven columns offset-by-one">
                    <?php echo CHtml::link('<div class="header" title="' . Yii::app()->params['appName'] . '"></div>', 'index.php'); ?>
                    <div class="header-school-logo">
                        <div id="logo_artikel"><?php echo Yii::app()->params['textHeader']; ?>&nbsp;&nbsp;</div>
                        <div id="logo_school_border">
                            <a href="http://<?php echo Yii::app()->params['schoolWebsiteLink']; ?>" target="_blank"><img id="logo_school" src="<?php echo $this->assetsDir . Yii::app()->params['logoPath']; ?>" alt="<?php echo Yii::app()->params['schoolName'] ?>"></a>
                        </div>
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
                </div> <?php } ?>

            <?php
            if (!Yii::app()->user->isGuest) {
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array('class' => 'nav-bar js_hide nojs_menu'),
                    'encodeLabel' => false,
                    'items' => array(//0=Administration 1=Verwaltung 2= Lehrer 3=Eltern
                        $this->generateMenuItem("&#xe002;", Yii::t('app', "Ihre Termine"), "/Appointment/index", !Yii::app()->user->isAdmin() && Yii::app()->user->checkAccessRole("2", "3")),
                        $this->generateMenuItem("&#xe00b;", Yii::t('app', "Termine vereinbaren"), "/Appointment/getTeacher", Yii::app()->user->checkAccess('3') && !Yii::app()->user->isAdmin()),
                        $this->generateMenuItem("&#xe00b;", Yii::t('app', "Termine anlegen"), "/Appointment/create", Yii::app()->user->checkAccessNotAdmin('2') && Yii::app()->params['teacherAllowBlockTeacherApps']),
                        $this->generateMenuItem("&#xe00b;", Yii::t('app', "Termine blockieren"), "/Appointment/createBlockApp", Yii::app()->user->checkAccessNotAdmin('2') && Yii::app()->params['allowBlockingAppointments'] && !(Yii::app()->params['allowBlockingOnlyForManagement'])),
                        $this->generateMenuItem("&#xe007;", Yii::t('app', "Elternsprechtagsverwaltung"), "/Date/admin", Yii::app()->user->checkAccess('0')),
                        $this->generateMenuItem("&#xe007;", Yii::t('app', "Terminverwaltung"), "/Appointment/admin", Yii::app()->user->checkAccess('1')),
                        $this->generateMenuItem("&#xe00a;", Yii::t('app', "Eltern und Kinder"), "/ParentChild/admin", Yii::app()->user->checkAccess('1')),
                        $this->generateMenuItem("&#xe00a;", Yii::t('app', "Ihre Kinder"), "/ParentChild/index", Yii::app()->user->checkAccess('3') && !Yii::app()->user->isAdmin()),
                        $this->generateMenuItem("&#xe00a;", Yii::t('app', "Benutzerverwaltung"), "/User/admin", Yii::app()->user->checkAccess('1')),
                        $this->generateMenuItem("&#xe00a;", Yii::t('app', "Gruppenverwaltung"), "Group/admin", Yii::app()->user->checkAccess('1') && Yii::app()->params['allowGroups']),
                        $this->generateMenuItem("&#xe007;", Yii::t('app', "TAN- verwaltung"), "Tan/genTans", Yii::app()->user->checkAccessRole('2', '1') || Yii::app()->user->isAdmin()),
                        $this->generateMenuItem("&#xe007;", Yii::t('app', "Konfiguration"), "site/config", Yii::app()->user->checkAccess('0')),
                        $this->generateMenuItem("&#xe007;", Yii::t('app', "Ihr Benutzerkonto"), "/User/account", true),
                        $this->generateMenuItem("&#xe006;", Yii::t('app', "Logout"), "/site/logout", true)),
                    'activeCssClass' => 'active'
                ));
            }
            ?>
            <div class="push hide-on-print"></div>
            <div class="row hide-on-print">
                <div class="twelve columns centered">
                    <?php if (Yii::app()->user->hasFlash('success')) { ?>
                        <div class="alert-box">
                            <?php echo Yii::app()->user->getFlash('success'); ?>
                        </div>
                    <?php } if (Yii::app()->user->hasFlash('failMsg')) { ?>
                        <div class="alert-box">
                            <?php echo Yii::app()->user->getFlash('failMsg'); ?>            
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row print-only">
                <div class="twelve columns text-center">
                    <h5><?php
                        echo (!empty(Yii::app()->params['schoolName'])) ? Yii::t('app', 'Elternsprechtag') .
                                ' ' . Yii::t('app', 'der') . ' ' . Yii::app()->params['schoolName'] : Yii::t('app', 'ESTA') .
                                ' - ' . Yii::t('app', 'Elternsprechtagsanwendung');
                        ?></h5>
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
                <div class="twelve columns">
                    <span id="print_button" class="nav-icons small button js_show" aria-hidden="true" data-icon="&#xe001;" onClick="window.print();">&nbsp;Drucken</span>
                    <hr />
                    <div class="row">
                        <div class="six columns">
                            <p>Copyright &copy; <?php
                                echo date('Y') . ' ';
                                echo (!empty(Yii::app()->params['schoolName'])) ? Yii::app()->params['schoolName'] : 'ESTA - Team';
                                ?> <br>
                            </p>
                        </div>
                        <div class="six columns"> 
                            <?php
                            $this->widget('zii.widgets.CMenu', array(
                                'htmlOptions' => array('class' => 'link-list right'),
                                'items' => array(
                                    array('label' => Yii::t('app', 'Statistik'), 'url' => array('/site/statistics'), 'visible' => (!Yii::app()->user->isGuest() && Yii::app()->user->checkAccess('0'))),
                                    array('label' => Yii::t('app', 'FAQ'), 'url' => array('/site/page', 'view' => 'faq')),
                                    array('label' => Yii::t('app', 'Impressum'), 'url' => array('/site/page', 'view' => 'impressum')),
                                    array('label' => Yii::t('app', 'Kontakt'), 'url' => array('/site/contact')),
                            )));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> 	<!-- /FOOTER -->
        <!-- MODALS -->
        <div id="MenuModal" class="reveal-modal [small] nav-menu">
        </div>
        <div class="infobox" style="display: none;">
            <p></p>
        </div>
        <script type="text/javascript" src="<?php echo $this->assetsDir; ?>/js/foundation.min.js"></script>
    </body>
</html>
