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
        throw new CHttpException(403, 'Zugriff verweigert.');
    }

    /**
     * @throws CHttpException 404
     */
    public function throwFourNullFour() {
        throw new CHttpException(404, 'Die angeforderte Seite konnte nicht gefunden werden.');
    }

    /**
     * @throws CHttpException 400
     */
    public function throwFourNullNull() {
        throw new CHttpException(400, 'Ihre Anfrage ist ungültig.');
    }

    /**
     * Generiert einen Menu Punkt
     * @param string $dataIcon Icon
     * @param string $name Anzuzeigender Name
     * @param string $url Ziel URL
     * @param phpCode $visible Bedingungen damit der Punkt angezeigt wird
     * @param string $cssClasses CSS Klassen
     * @param string $ariaHidden  true/false als String  
     * @return array
     */
    public function generateMenuItem($dataIcon, $name, $url, $visible, $cssClasses = '"nav-icons"', $ariaHidden = "true") {
        return array('label' => '<span class=' . $cssClasses . ' aria-hidden="' . $ariaHidden . '" data-icon="' . $dataIcon . '">&nbsp;' . $name . '</span>', 'url' => array($url,), 'visible' => $visible);
    }

    public function registerPackages() {
        Yii::app()->clientScript->registerPackage('css');
        $userAgent = preg_match('/MSIE [1-7]/', $_SERVER['HTTP_USER_AGENT']);
        if (empty($userAgent)) {
            if (YII_DEBUG) {
                Yii::app()->clientScript->registerPackage('javascript');
                Yii::app()->clientScript->registerPackage('jquery');
                if (Yii::app()->user->checkAccess('1')) {
                    Yii::app()->clientScript->registerPackage('admin');
                }
            } else {
                Yii::app()->clientScript->registerPackage('javascriptDebug');
                Yii::app()->clientScript->registerPackage('jqueryDebug');
                if (Yii::app()->user->checkAccess('1')) {
                    Yii::app()->clientScript->registerPackage('adminDebug');
                }
            }
        }
    }

    public function registerScripts() {
        $cs = Yii::app()->getClientScript();

        $cs->registerCssFile($this->assetsDir . '/css/print.min.css', 'print');
        $userAgent = preg_match('/MSIE [1-7]/', $_SERVER['HTTP_USER_AGENT']);
        $cs->addPackage('css', array(//nicht ändern
            'baseUrl' => $this->assetsDir . '/css/', //nicht ändern
            'css' => array('foundation.min.css', !YII_DEBUG ? 'icons.min.css' : 'icons.css', !YII_DEBUG ? 'app.min.css' : 'app.css') //nicht ändern
        ));
        $cs->addPackage('jqueryNew', array(//nicht ändern
            'baseUrl' => $this->assetsDir . '/js/', //nicht ändern
            'js' => array('foundation.min.js', !YII_DEBUG ? 'app.min.js' : 'app.js'),
            'depends' => array('css'),
        ));
        $cs->registerPackage('css');
        if (empty($userAgent)) {
            $cs->registerPackage('jqueryNew');
        }
        $this->registerAdminScripts();
    }

    public function registerAdminScripts($admin = false) {

        if (Yii::app()->user->checkAccess('1') || $admin) {
            $cs = Yii::app()->getClientScript();
            $cs->addPackage('admin', array(
                'baseUrl' => $this->assetsDir . '/css/',
                'css' => array(!YII_DEBUG ? 'select2.min.css' : 'select2.css'),
                'js' => array(!YII_DEBUG ? 'custom.min.js' : 'custom.js'),
                'depends' => array('jqueryNew'),
            ));
            $cs->registerPackage('admin');
        }
    }

    public function init() {
        $dir = dirname(__FILE__) . '/../assets';
        $this->assetsDir = Yii::app()->assetManager->publish($dir);
        return parent::init();
    }

}
