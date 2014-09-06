<?php
/**
 * Mainlayout
 */
/* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
$menu = array(//icon,label,url,visible(bool)
    array('fi-home', Yii::t('app', 'Ihre Termine'), array('Appointment/index'), !Yii::app()->user->isAdmin() && Yii::app()->user->checkAccessRole(TEACHER, PARENTS)),
    array('fi-calendar', Yii::t('app', 'Termine vereinbaren'), array('Appointment/getTeacher'), Yii::app()->user->checkAccess(PARENTS) && !Yii::app()->user->isAdmin()),
    array('fi-plus', Yii::t('app', 'Termine anlegen'), array('Appointment/create'), Yii::app()->user->checkAccessNotAdmin(TEACHER) && Yii::app()->params['teacherAllowBlockTeacherApps']),
    array('fi-lock', Yii::t('app', 'Termine blockieren'), array('Appointment/createBlockApp'), Yii::app()->user->checkAccessNotAdmin(TEACHER) && Yii::app()->params['allowBlockingAppointments'] && !(Yii::app()->params['allowBlockingOnlyForManagement'])),
    array('fi-widget', Yii::t('app', 'Elternsprechtage'), array('Date/admin'), Yii::app()->user->isAdmin()),
    array('fi-calendar', Yii::t('app', 'Termine'), array('Appointment/admin'), Yii::app()->user->checkAccess(MANAGEMENT)),
    array('fi-torsos', Yii::t('app', 'Eltern und Kinder'), array('ParentChild/admin'), Yii::app()->user->checkAccess(MANAGEMENT)),
    array('fi-heart', Yii::t('app', 'Ihre Kinder'), array('ParentChild/index'), Yii::app()->user->checkAccess(PARENTS) && !Yii::app()->user->isAdmin()),
    array('fi-torso', Yii::t('app', 'Benutzer'), array('User/admin'), Yii::app()->user->checkAccess(MANAGEMENT)),
    array('fi-torsos-all', Yii::t('app', 'Gruppen'), array('Group/admin'), Yii::app()->user->checkAccess(MANAGEMENT) && Yii::app()->params['allowGroups']),
    array('fi-key', Yii::t('app', 'Tan'), array('Tan/genTans'), Yii::app()->user->checkAccessRole(TEACHER, MANAGEMENT) || Yii::app()->user->isAdmin()),
    array('fi-wrench', Yii::t('app', 'Konfiguration'), array('site/config'), Yii::app()->user->checkAccess(ADMIN)),
    array('fi-torso', Yii::t('app', 'Ihr Benutzerkonto'), array('User/account'), !Yii::app()->user->checkAccess(ADMIN)),
    array('fi-torso-business', Yii::t('app', 'Ihr Benutzerkonto'), array('User/account'), Yii::app()->user->checkAccess(ADMIN)),
    array('fi-power', Yii::t('app', 'Logout'), array('site/logout'), true),
);
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="icon" href="<?php echo $this->assetsDir; ?>/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->assetsDir; ?>/favicon.ico">
    <?php $this->registerScripts(); ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
    <nav class="top-bar" data-topbar data-options="is_hover: false">
        <ul class="title-area">
            <li class="name esta-logo">
                <h2>
                    <?php echo CHtml::link(Yii::t('app', 'Elternsprechtag'), 'index.php'); ?>
                </h2>
            </li>
            <li class="toggle-topbar menu-icon"><a href=""><span>Menu</span></a></li>
        </ul>
        <section class="top-bar-section">
            <ul class="right">
                <li>
                    <a href="http://<?php echo Yii::app()->params['schoolWebsiteLink']; ?>" target="_blank">
                        <img id="logo_school" 
                             src="<?php echo $this->assetsDir . Yii::app()->params['logoPath']; ?>" 
                             alt="<?php echo Yii::app()->params['schoolName'] ?>">
                             <?php echo Yii::app()->params['schoolName'] ?>
                    </a>
                </li>
            </ul>
            <ul class="left show-for-small-only">
                <?php
                if (!Yii::app()->user->isGuest) {
                    echo $this->generateFoundation5Menu($menu, true);
                }
                ?>
                <li>
                    <a onClick="window.print();">
                        <i class="fi-print"></i><?php echo Yii::t('app', 'Drucken'); ?>
                    </a>
                </li>
            </ul>
        </section>
    </nav>
    <div class="sticky sticky-nav hide-for-small">
        <ul class="medium-block-grid-6 large-block-grid-8 text-center ul-nav" data-topbar>
            <?php
            if (!Yii::app()->user->isGuest) {
                echo $this->generateFoundation5Menu($menu, false);
            }
            ?>
            <li>
                <a onClick="window.print();">
                    <i class="fi-print"></i><span><?php echo Yii::t('app', 'Drucken'); ?></span>
                </a>
            </li>
            <li class="no-highlight">
                <div id="language-selector">
                    <i class="fi-comment-quotes"></i>
                    <?php $this->widget('application.components.widgets.LanguageSelector'); ?>
                </div>
            </li>
        </ul>
    </div>
    <section role="main" class="content-wrapper">
        <div class="row hide-on-print">
            <div class="small-12 columns small-centered">
                <?php if (Yii::app()->user->hasFlash('success')) { ?>
                    <div data-alert class="alert-box" tabindex="0" aria-live="assertive" role="dialogalert">
                        <?php echo Yii::app()->user->getFlash('success'); ?>
                    </div>
                <?php } if (Yii::app()->user->hasFlash('failMsg')) { ?>
                    <div data-alert class="alert-box alert" tabindex="0" aria-live="assertive" role="dialogalert">
                        <?php echo Yii::app()->user->getFlash('failMsg'); ?>            
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php echo $content; ?>
    </section>
    <div class="footer row">
        <hr>
        <div class="small-6 large-4 columns">
            <p>
                <?php echo Yii::t('app', 'Copyright'); ?> &copy; <?php
                echo date('Y') . ' ';
                echo (!empty(Yii::app()->params['schoolName'])) ? Yii::app()->params['schoolName'] : Yii::t('app', 'ESTA-Team');
                ?>
            </p>
        </div>
        <div class="large-4 columns hide-for-small js_hide"></div>
        <div class="large-4 columns hide-for-small js_show">
            <p>
                <?php echo Yii::t('app', 'Drücken Sie <kbd>Esc</kbd> um das Navigationsmenü ein- bzw. auszublenden.'); ?> 
            </p>
        </div>
        <div class="small-6 large-4 columns">
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'htmlOptions' => array('class' => 'right inline-list'),
                'items' => array(
                    array('label' => Yii::t('app', 'Statistik'), 'url' => array('/site/statistics'),
                        'visible' => (!Yii::app()->user->isGuest() && Yii::app()->user->checkAccess(ADMIN))),
                    array('label' => Yii::t('app', 'FAQ'), 'url' => array('/site/page', 'view' => 'faq')),
                    array('label' => Yii::t('app', 'Impressum'), 'url' => array('/site/page', 'view' => 'impressum')),
                    array('label' => Yii::t('app', 'Kontakt'), 'url' => array('/site/contact')),
            )));
            ?>
        </div>
    </div> 
    <div class="infobox" style="display: none;">
        <p></p>
    </div>
</body>
</html>
