<?php
/** Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
// specify how many levels of call stack should be shown in each log message
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
$params = require(dirname(__FILE__) . '/params.php');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'ESTA',
    'sourceLanguage' => 'de',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.models.forms.*',
        'application.components.*',
        'ext.select2.Select2',
    ),
    'components' => array(
        'request' => array(
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
        ),
        'db' => array(
            'connectionString' => 'mysql:host=' . $params['databaseHost'] . ';port=' . $params['databasePort'] . ';dbname=' . $params['databaseName'],
            'emulatePrepare' => true,
            'enableParamLogging' => YII_DEBUG,
            'enableProfiling' => YII_DEBUG,
            'username' => $params['databaseUsername'],
            'password' => $params['databasePassword'],
            'charset' => 'utf8',
            'tablePrefix' => '',
            'schemaCachingDuration' => YII_DEBUG ? 0 : 86400, //3600 or 86400
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array('class' => 'CFileLogRoute',
                    'levels' => YII_DEBUG ? 'trace,error,warning,info' : 'error,warning',),
                array('class' => 'CProfileLogRoute',
                    'report' => 'summary',
                    'enabled' => YII_DEBUG),
            ),
        ),
        'cache' => array(
            'class' => 'system.caching.CDbCache',
            'connectionID' => 'db',
            'autoCreateCacheTable' => false,
            'cacheTableName' => 'YiiCache',
            'enabled' => !YII_DEBUG,
        ),
    ),
    'params' => $params,
);


