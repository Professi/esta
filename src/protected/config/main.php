<?php

/** Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
$params = Yii::app()->params;
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => array_key_exists('appName', $params) ? 'ESTA' : $params['appName'],
    'sourceLanguage' => 'de',
    'language' => array_key_exists('language', $params) ? 'de' : $params['language'],
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.select2.Select2',
    ),
    'components' => array(
        'request' => array(
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
        ),
        'user' => array(
            'class' => 'WebUser',
            'allowAutoLogin' => true,
            'autoUpdateFlash' => false,
        ),
        'clientScript' => array(
            'coreScriptPosition' => CClientScript::POS_END,
            'scriptMap' => array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery.cookie.js' => false,
                'core.css' => false,
                'styles.css' => false,
                'pager.css' => false,
                'default.css' => false,
                'jquery-ui.css' => false,
            ),
        ),
        'urlManager' => array(
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<action>' => 'site/<action>'
            ),
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
        ),
        'db' => array(
            'connectionString' => 'mysql:host=' . $params['databaseHost'] . ';port=' . $params['databasePort'] . ';dbname=' . $params['databaseName'], //entsprechen der eigenen Datenbank anpassen  Beispiel: mysql:host=HOST;dbname=DBNAME
            'emulatePrepare' => true,
            'enableProfiling' => YII_DEBUG,
            'username' => $params['databaseUsername'], //DB User bitte anpassen
            'password' => $params['databasePassword'],
            'charset' => 'utf8',
            'tablePrefix' => '',
            'schemaCachingDuration' => YII_DEBUG ? 0 : 86400, //3600 oder 86400
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters' => array('*'),
                    'categories' => '*',
                    'enabled' => YII_DEBUG,
                ),
                array('class' => 'CFileLogRoute',
                    'levels' => 'error,warning,info',),
                array('class' => 'CProfileLogRoute',
                    'report' => 'summary',
                    'enabled' => YII_DEBUG,
                ),
            ),
        ),
        'cache' => array(
            'class' => 'system.caching.CDbCache',
            'connectionID' => 'db',
            'autoCreateCacheTable' => false,
            'cacheTableName' => 'YiiCache',
            'enabled' => !YII_DEBUG,
        ),
        'session' => array('sessionName' => 'SiteSession',
            'class' => 'CDbHttpSession',
            'autoCreateSessionTable' => false,
            'sessionTableName' => 'YiiSession',
            'connectionID' => 'db',
            'autoStart' => true,),
        'widgetFactory' => array(// nicht ändern
            'widgets' => array(// nicht ändern
                'CBaseListView' => array(
                    '$pagerCssClass' => 'pagination-centered',
                ),
                'CLinkPager' => array(// nicht ändern
                    'header' => '',
                    'nextPageLabel' => '&rsaquo;',
                    'prevPageLabel' => '&lsaquo;',
                    'firstPageLabel' => '&laquo;',
                    'lastPageLabel' => '&raquo;',
                    'firstPageCssClass' => 'arrow',
                    'lastPageCssClass' => 'arrow',
                    'hiddenPageCssClass' => 'unavailable',
                    'selectedPageCssClass' => 'current',
                    'htmlOptions' => array('class' => 'pagination'),
                ),
                'CCaptcha' => array(
                    'buttonOptions' => array('class' => 'tiny button captcha-button'),
                ),
            ),
        ),
    ),
    'params' => $params,
);


