<?php

/**
 * Startpunkt der Yii Applikation
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

use SebastianBergmann\CodeCoverage;

require_once dirname(__FILE__) . '/protected/components/globals.php';
$yii = dirname(__FILE__) . '/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

if (file_exists(__DIR__ . $_SERVER['REQUEST_URI']) &&
    is_file(__DIR__ . $_SERVER['REQUEST_URI'])) {
    // Do not try to server static files – this is only important, if used
    // together with PHPs internal webserver.
    return false;
}

define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

if (YII_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
}

// Determine if we should collect functional test code coverage
require_once __DIR__ . '/vendor/autoload.php';
$calculateCoverage = file_exists(__DIR__ . '/.generate-functional-coverage');
if ($calculateCoverage) {
    $filter = new CodeCoverage\Filter();
    $filter->addDirectoryToWhitelist(__DIR__ . "/protected/");

    $coverage = new CodeCoverage\CodeCoverage(null, $filter);
    $coverage->start('Behat Test');
}

require_once($yii);
$app = Yii::createWebApplication($config);
$configs = ConfigEntry::model()->findAll();
foreach ($configs as $value) {
    $app->params->add($value->key, $value->value);
}
$app->setLanguage($app->params['language']);
$app->run();

if ($calculateCoverage) {
    $coverage->stop();

    $coverageDir = __DIR__ . '/build/functional-coverage';

    if (!is_dir($coverageDir)) {
        mkdir($coverageDir, 0755, true);
    }

    $writer = new CodeCoverage\Report\PHP;
    $writer->process($coverage, $coverageDir . '/' . microtime(true) . '.cov');
}
