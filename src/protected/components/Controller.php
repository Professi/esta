<?php

/**
 * Controller ist die angepasste Basis CController Klasse
 */
/* * Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
define('ADMIN', 0);
define('MANAGEMENT', 1);
define('TEACHER', 2);
define('PARENTS', 3);

/*
 * Klasse Controller überschreibt die Standard Yii Controller Klasse
 */

class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $assetsDir;

    /**
     * @throws CHttpException 403
     */
    public function throwFourNullThree() {
        throw new CHttpException(403, Yii::t('app', 'Zugriff verweigert.'));
    }

    /**
     * @throws CHttpException 404
     */
    public function throwFourNullFour() {
        throw new CHttpException(404, Yii::t('app', 'Die angeforderte Seite konnte nicht gefunden werden.'));
    }

    /**
     * @throws CHttpException 400
     */
    public function throwFourNullNull() {
        throw new CHttpException(400, Yii::t('app', 'Ihre Anfrage ist ungültig.'));
    }

    /**
     * Generates a menu item
     * @param string $dataIcon Icon
     * @param string $name Anzuzeigender Name
     * @param string $url Ziel URL
     * @param phpCode $visible Bedingungen damit der Punkt angezeigt wird
     * @param string $cssClasses CSS Klassen
     * @param string $ariaHidden  true/false als String
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @return array
     */
    public function generateMenuItem($dataIcon, $name, $url, $visible, $cssClasses = '"nav-icons"', $ariaHidden = "true") {
        return array('label' => '<span class=' . $cssClasses . ' aria-hidden="' . $ariaHidden . '" data-icon="' . $dataIcon . '">&nbsp;' . $name . '</span>', 'url' => array($url,), 'visible' => $visible);
    }
    
    public function generateFoundation5MenuItem($icon, $label, $url, $visible,$mobile) {
        $link = '';
        $labelTag = ($mobile) ? $label : "<br><span>{$label}</span>";
        if($visible) {
            $link = '<li>' . CHtml::link("<i class={$icon}></i>{$labelTag}", $url) . '</li>';
        }
        return $link;
    }
    
    public function generateFoundation5Menu($menuArray,$mobile) {
        $menu = '';
        for($i = 0; $i < count($menuArray);$i++) {
            $menu .= $this->generateFoundation5MenuItem($menuArray[$i][0], 
                                                        $menuArray[$i][1], 
                                                        $menuArray[$i][2], 
                                                        $menuArray[$i][3],
                                                        $mobile);
        }
        return $menu;
    }

    /**
     * adds css and js packages
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     */
    public function registerScripts() {
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($this->assetsDir . '/css/print.min.css', 'print');
        $userAgent = preg_match('/MSIE [1-7]/', $_SERVER['HTTP_USER_AGENT']);
        $cs->addPackage('css', array(
            'baseUrl' => $this->assetsDir . '/css/',
            'css' => array('foundation.min.css', !YII_DEBUG ? 'icons.min.css' : 'icons.css', !YII_DEBUG ? 'app.min.css' : 'app.css') //nicht ändern
        ));
        $cs->addPackage('jquery.js', array(
            'baseUrl' => $this->assetsDir . '/js/',
            'js' => array(!YII_DEBUG ? 'app.min.js' : 'app.js'),
            'depends' => array('css'),
        ));
        $cs->registerPackage('css');
        if (empty($userAgent)) {
            $cs->registerCoreScript('jquery.js');
        }
        $this->registerAdminScripts();
    }

    /**
     * registers css and js files for admin Sites, 
     * checks for adminUser, when $admin true, checkAccess ignored
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param boolean $admin
     */
    public function registerAdminScripts($admin = false) {
        if (Yii::app()->user->checkAccess('1') || $admin || 
            Yii::app()->user->checkAccess('2') && Yii::app()->params['teacherAllowBlockTeacherApps']) {
            $cs = Yii::app()->getClientScript();
            $cs->addPackage('admin', array(
                'baseUrl' => $this->assetsDir,
                'css' => array(!YII_DEBUG ? '/css/select2.min.css' : '/css/select2.css'),
                'js' => array(!YII_DEBUG ? '/js/custom.min.js' : '/js/custom.js'),
                'depends' => array('jquery'),
            ));
            $cs->registerPackage('admin');
        }
    }

    /**
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * publishes all assets
     * @return parent::init
     */
    public function init() {
        $dir = dirname(__FILE__) . '/../assets';
        $this->assetsDir = Yii::app()->assetManager->publish($dir, false, -1, YII_DEBUG);
        return parent::init();
    }

    /**
     * sets Page Title with app->name and $name
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param string $name
     */
    public function setPageTitle($name) {
        parent::setPageTitle(Yii::app()->name . ' - ' . $name);
    }

}
