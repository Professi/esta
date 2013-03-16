<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..', //nicht ändern
    'name' => 'Elternsprechtagsplattform der Brühlwiesenschule', //entsprechend den eigenen Bedürfnissen anpassen
    'language' => 'de', //Sprache
    'preload' => array('log'), //Logkomponente - nicht ändern
    'import' => array(//nicht ändern
        'application.models.*', //nicht ändern
        'application.components.*', //nicht ändern
    ),
// application components
    'components' => array(//nicht ändern
        'user' => array(//nicht ändern
            'class' => 'WebUser', //nicht ändern
            'allowAutoLogin' => true, //nicht ändern
        ),
        'clientScript' => array(//nicht ändern
            'coreScriptPosition' => CClientScript::POS_END, //nicht ändern
            'scriptMap' => array(//nicht ändern
                'jquery.js' => false, //nicht ändern
                'jquery.js.min' => false, //nicht ändern
                'jquery.cookie.js' => false, //nicht ändern
                'jquery.ba-bbq.js' => false, //nicht ändern
                'jquery.yiigridview.js' => false, //nicht ändern
                'core.css' => false, //nicht ändern
                'styles.css' => false, //nicht ändern
                'pager.css' => false, //nicht ändern
                'default.css' => false, //nicht ändern
            ),
            'packages' => array(//nicht ändern
                'javascript' => array(//nicht ändern
                    'baseUrl' => 'js/', //nicht ändern
                    'js' => array('foundation.min.js', 'app.js', 'custom.js'), //nicht ändern
                ),
                'css' => array(//nicht ändern
                    'baseUrl' => 'css/', //nicht ändern
                    'css' => array('foundation.min.css', 'icons.css', 'app.css') //nicht ändern
                ),
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
            'enableProfiling' => true, //nicht ändern
            'username' => 'estdb', //DB User bitte anpassen
            'password' => 'qwertzuiop', //DB Passwort bitte anpassen
            'charset' => 'utf8', //eventuell anpassen im optimalfall dabei belassen
            'tablePrefix' => '', //nicht ändern
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error', //nicht ändern
        ),
        'log' => array(
            'class' => 'CLogRouter', //nicht ändern
            'routes' => array(//nicht ändern
                array(
                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute'), //auskommentieren
                array('class' => 'CFileLogRoute', //jenachdem ob ein DateiLog benötigt wird auskommentieren - empfohlen
                    'levels' => 'error,warning,watch',
                    'categories'=>'system.*'), // auskommentieren wird auch hier empfohlen
                array('class' => 'CProfileLogRoute',
                    'report' => 'summary',),
            ),
        ),
        'cache' => array(// nicht ändern , kommt eventuell noch wegen da aktuell nichts gecached wird
            'class' => 'system.caching.CDbCache',
            'connectionID' => 'db'
        ),
        'session' => array(// nicht ändern
            'sessionName' => 'SiteSession', // nicht ändern
            'class' => 'CHttpSession', // nicht ändern
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
    'modules' => array(//wird noch entfernt
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'test',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application-level parameters that can be accessed
// using Yii::app()->params['paramName']
    'params' => array(
// this is used in contact page
        'adminEmail' => 'c.ehringfeld@t-online.de', //Administrator E-Mail Adresse
        'salt' => 'e9HOiJFfDhyvcBMin5G8CBTR98wK', //der Applikationssalt sollte mindestens 30 Zeichen lang sein und nur aus alphanumerischen Zeichen bestehen 
        'dateTimeFormat' => 'd.m.Y H:i', //Datumsformat -  muss nicht geändert werden
        'emailHost' => 'localhost', //Sofern der SMTP Server auf dem selben Server läuft einfach localhost
        'fromMailHost' => 'est@h1963533.stratoserver.net', //Absender der Mails wird wohl später dann EST@bws-hofheim.de
        'fromMail' => 'ESTA-BWS', //Der Absendername bsp. BWS-Hofhei,
        'teacherMail' => 'bws-hofheim.de',
        'schoolName'=> 'Brühlwiesenschule Hofheim',
        'virtualHost' => '/~est/est_trunk/', //unbedingt anpassen damit E-Mails mit korrektem Aktivierungslink versendet werden können
        'mailsActivated' => true, //ob Mails versendet werden solen
        'maxChild' => 3, //Maximal Anzahl von eintragbaren Kindern pro Benutzer mit Elternrolle
        'tanSize' => 6, //Länge der Tans
        'maxTanGen' => 100, //Maximal auf einmal generierbare Anzahl an TANs
        'maxAppointmentsPerChild' => 5, //Maximal Anzahl an Terminen pro Kind
    )
);


