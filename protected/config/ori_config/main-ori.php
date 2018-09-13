<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'MES-Ambiente',
        'defaultController'=>'Index',
        'theme'=>'blackboot',
	// preloading 'log' component
	'preload'=>array(
            'log',
            'bootstrap'
        ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
                        'generatorPaths' => array(
                        'bootstrap.gii'
                    ),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
                        //'class'=>'WebUser',
                       // 'loginUrl'=>array('authenticate/login'),
		),
                'bootstrap' => array(
                    'class' => 'ext.bootstrap.components.Bootstrap',
                    'responsiveCss' => true,
                ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			//'urlFormat'=>'path',
                        'showScriptName' => false,
			'rules'=>array(
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			),
		),
		
		//'db'=>array(
		//	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		//),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=dbtoko',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
       'db'=>array(
			'connectionString' => 'sqlsrv:server=BUDI_ASTANTO;database=mesdb;MultipleActiveResultSets=false;',
			'username' => 'mes',
			'password' => 'ba_321_indomo',
			'charset' => 'utf8',
		),
            /*
                'db'=>array(
			'connectionString' => 'sqlsrv:server=dbsindomo;database=imasset;MultipleActiveResultSets=false;',
			'username' => 'sa',
			'password' => 'ptim*328',
			'charset' => 'utf8',
		),*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@modena.co.id',
	),
);