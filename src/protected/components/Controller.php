<?php

/**
 * Controller ist die angepasste Basis CController Klasse
 */
/* * Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
define('ADMIN', '0');
define('MANAGEMENT', '1');
define('TEACHER', '2');
define('PARENTS', '3');

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
    
    /**
     * 
     * @param string $icon
     * @param string $label
     * @param string $url
     * @param bool $visible
     * @param bool $mobile
     * @author David Mock
     * @access public
     * @return string 
     */
    public function generateFoundation5MenuItem($icon, $label, $url, $visible,$mobile) {
        $link = '';
        $labelTag = ($mobile) ? $label : "<span>{$label}</span>";
        if($visible) {
            $link = '<li>' . CHtml::link("<i class={$icon}></i>{$labelTag}", $url) . '</li>';
        }
        return $link;
    }
    
    /**
     * 
     * @param mixed $menuArray
     * @param bool $mobile
     * @author David Mock
     * @access public
     * @return string[]
     */
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
        
        $cs->registerCssFile($this->assetsDir . '/css/app.css');
        $cs->registerCssFile($this->assetsDir . '/css/print.min.css', 'print');
        
        if(Yii::app()->user->checkAccess(ADMIN)) {
            $cs->registerCssFile( $this->assetsDir."/css/select2.min.css");
        }
        
        $cs->scriptMap['jquery.js'] = $this->assetsDir . '/js/jquery.js';
        $cs->scriptMap['jquery.min.js'] = $this->assetsDir . '/js/jquery.min.js';
        $cs->scriptMap['jquery-ui.js'] = $this->assetsDir . '/js/jquery-ui.js';
        $cs->scriptMap['jquery-ui.min.js'] = $this->assetsDir . '/js/jquery-ui.min.js';
        
        $cs->registerCoreScript('jquery.js');
        
        $cs->registerScriptFile($this->assetsDir . '/js/fastclick.js', CClientScript::POS_END);
        $cs->registerScriptFile($this->assetsDir . '/js/modernizr.js', CClientScript::POS_END);
        $cs->registerScriptFile($this->assetsDir . '/js/placeholder.js', CClientScript::POS_END);
        $cs->registerScriptFile($this->assetsDir . '/js/foundation.min.js', CClientScript::POS_END);

        if(YII_DEBUG) {
            $cs->registerScriptFile($this->assetsDir . '/js/app.js', CClientScript::POS_END);
        } else {
            $cs->registerScriptFile($this->assetsDir . '/js/app.min.js', CClientScript::POS_END);
        }
        
        if ( preg_match('/MSIE [1-7]/', $_SERVER['HTTP_USER_AGENT']) === 1) {
            $cs->enableJavaScript = false;
        }
        
    }

    /**
     * registers css and js files for admin Sites, 
     * checks for adminUser, when $admin true, checkAccess ignored
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param boolean $admin
     * @deprecated since version 1.3
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
