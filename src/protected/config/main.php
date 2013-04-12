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
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..', //nicht ändern
    'name' => 'Elternsprechtagsapplikation der Brühlwiesenschule', //entsprechend den eigenen Bedürfnissen anpassen
    'language' => 'de', //Sprache
    'preload' => array('log'), //Logkomponente - nicht ändern
    'import' => array(//nicht ändern
        'application.models.*', //nicht ändern
        'application.components.*', //nicht ändern
    ),
    'components' => array(//nicht ändern
        'user' => array(//nicht ändern
            'class' => 'WebUser', //nicht ändern
            'allowAutoLogin' => true, //nicht ändern
        ),
        'clientScript' => array(//nicht ändern
            'coreScriptPosition' => CClientScript::POS_END, //nicht ändern
            'packages' => array(//nicht ändern
                'css' => array(//nicht ändern
                    'baseUrl' => 'css/', //nicht ändern
                    'css' => array('foundation.min.css', 'icons.css', 'app.css') //nicht ändern
                ),
                'jquery' => array(//nicht ändern
                    'baseUrl' => 'js/', //nicht ändern
//                    'js' => array('foundation.min.js', 'app.js', 'custom.js'), //nicht ändern
                    'js' => array('foundation.min.js', 'app.js'),
                    'depends' => array('css'),
                ),
                'admin' => array(
                  'baseUrl' => 'js/',
                    'js' => array('custom.js'),
                ),
            ),
            'scriptMap' => array(//nicht ändern
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery.cookie.js' => false, //nicht ändern
                'core.css' => false, //nicht ändern
                'styles.css' => false, //nicht ändern
                'pager.css' => false, //nicht ändern
                'default.css' => false, //nicht ändern
            ),
        ),
        'urlManager' => array(//nicht ändern
            'rules' => array(//nicht ändern
                '<controller:\w+>/<id:\d+>' => '<controller>/view', //nicht ändern
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>', //nicht ändern
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>', //nicht ändern
                '<action>' => 'site/<action>' //nicht ändern
            ),
        ),
        'authManager' => array(//nicht ändern
            'class' => 'CDbAuthManager', //nicht ändern
            'connectionID' => 'db', //nicht ändern
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=estdb', //entsprechen der eigenen Datenbank anpassen  Beispiel: mysql:host=HOST;dbname=DBNAME
            'emulatePrepare' => true, //nicht ändern
            'enableProfiling' => true, //nicht ändern - Entwicklungsparameter wird später auf false gesetzt für Performancegewinn
            'username' => 'estdb', //DB User bitte anpassen
            'password' => 'qwertzuiop', //DB Passwort bitte anpassen
            'charset' => 'utf8', //eventuell anpassen im optimalfall dabei belassen
            'tablePrefix' => '', //nicht ändern
           // 'schemaCachingDuration'=> 3600, //Optimierung
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error', //nicht ändern
        ),
        'log' => array(
            'class' => 'CLogRouter', //nicht ändern
            'routes' => array(//nicht ändern
                array(
                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute', //auskommentieren
                    'ipFilters' => array('*'),
                    'categories' => '*'),
                array('class' => 'CFileLogRoute', //jenachdem ob ein DateiLog benötigt - empfohlen
                    'levels' => 'error,warning',
                    'categories' => 'system.'),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'trace, info',
                    'categories' => 'application.*',
                ),
                array('class' => 'CProfileLogRoute', // auskommentieren nur interesant für die Entwicklung
                    'report' => 'summary'),
//                array('class' => 'CEmailLogRoute',
//                    'levels' => 'error, warning',
//                    'emails' => array('c.ehringfeld@t-online.de'),)
            ),
        ),
//        'cache' => array(// nicht ändern , kommt eventuell noch weg da aktuell nichts gecached wird
//            'class' => 'system.caching.CDbCache',
//            'connectionID' => 'db',
//        ),
        'session' => array(// nicht ändern
            'sessionName' => 'SiteSession', // nicht ändern
            'class' => 'CDbHttpSession', // nicht ändern
            'autoCreateSessionTable'=>false, //nicht ändern
            'connectionID'=>'db',
            'autoStart' => true, // nicht ändern
        ),
        'widgetFactory' => array(// nicht ändern
            'widgets' => array(// nicht ändern
                'CBaseListView' => array(
                    '$pagerCssClass' => 'pagination-centered',
                ),
                'CLinkPager' => array(// nicht ändern
                    'header' => '', // nicht ändern
                    'nextPageLabel' => '&rsaquo;', // nicht ändern
                    'prevPageLabel' => '&lsaquo;', // nicht ändern
                    'firstPageLabel' => '&laquo;', // nicht ändern
                    'lastPageLabel' => '&raquo;', // nicht ändern
                    'firstPageCssClass' => 'arrow', // nicht ändern
                    'lastPageCssClass' => 'arrow', // nicht ändern
                    'hiddenPageCssClass' => 'unavailable', // nicht ändern
                    'selectedPageCssClass' => 'current', // nicht ändern
                    'htmlOptions' => array('class' => 'pagination'), // nicht ändern
                ),
                'CCaptcha' => array(
                    'buttonOptions' => array('class' => 'tiny button captcha-button'),
                ),
            ),
        ),
    ),
    'params' =>require(dirname(__FILE__).'/params.php'),
);


