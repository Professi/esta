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

    private $_assetsBase;

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

    public function getAssetsBase() {
        if ($this->_assetsBase === null) {
            $this->_assetsBase = Yii::app()->assetManager->publish(
                    Yii::getPathOfAlias('application.assets'), false, -1, defined('YII_DEBUG') && YII_DEBUG
            );
        }
        return $this->_assetsBase;
    }

    public function beforeAction($action) {
        Yii::app()->clientScript->registerCssFile($this->assetsBase . '/css/print.css', 'print');
        Yii::app()->clientScript->registerCssFile($this->assetsBase . '/css/foundation.min.css');
        Yii::app()->clientScript->registerCssFile($this->assetsBase . '/css/icons.css');
        Yii::app()->clientScript->registerCssFile($this->assetsBase . '/css/app.css');
        Yii::app()->clientScript->registerScriptFile($this->assetsBase . '/js/modernizr.foundation.js', CClientScript::POS_HEAD);
        $ua = '';
        if (!(preg_match('/\bmsie [0-8]/i', $ua) && !preg_match('/\bopera/i', $ua))) {
        Yii::app()->clientScript->registerScriptFile($this->assetsBase . '/js/foundation.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsBase . '/js/app.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsBase . '/js/custom.js', CClientScript::POS_END);
        }
            Yii::app()->clientScript->registerLinkTag('icon',null,$this->assetsBase.'/img/favicon.ico');
        return parent::beforeAction($action);
    }

}
