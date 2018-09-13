<?php

// uncomment the following to define a path alias
Yii::setPathOfAlias('ptl',dirname(__FILE__).'/../portlets');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'PT. Indomo Mulia - Sub Portal',
	'defaultController'=>'site',
	'language'=>'en',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model, component and extension classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.components.database.*',
		'ext.widgets.portlet.XPortlet',
		'ext.helpers.XHtml',
		'ext.modules.help.models.*',
		'ext.modules.lookup.models.*',
                'application.modules.rights.*',
                'application.modules.rights.components.*',  
                'application.extensions.fpdf.*', //ini utk mengaktifkan fpdf nya
	),

	// modules
	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('192.168.1.170','::1'),
                        'generatorPaths' => array(
                        'bootstrap.gii'
                    ),
		),
                'rights'=>array(
                        'install'=>false,
                        'userClass'=>'User',
                        'userNameColumn' =>'username',
                        'userIdColumn'=>'userid',
                        'superuserName'=>'admin',
                ),
	),

	// application components
	'components'=>array(
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'CProfileLogRoute',
					'report'=>'summary',
				),
			),
		),
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'coreMessages'=>array(
			'basePath'=>'protected/messages',
		),
		'user'=>array(
			'allowAutoLogin'=>true,
                        'class'=>'RWebUser',
		),
                // Handling Session
                'session' => array (
                    'sessionName' => 'SiteSession',
                    'class' => 'system.web.CDbHttpSession',
                    'autoCreateSessionTable' => false,
                    'connectionID' => 'db',
                    'sessionTableName' => 'YiiSession',
                    'useTransparentSessionID' =>(!isset($_POST['PHPSESSID']) ? true : false),
                    'autoStart' => 'false',
                    'cookieMode' => 'only',
                    'timeout' => 1000
                ),
		'clientScript' => array(
			'scriptMap' => array(
				'jquery-ui.css'=> dirname($_SERVER['SCRIPT_NAME']).'/css/jui/custom/jquery-ui.css',
			),
		),
                'widgetFactory'=>array(
                    'enableSkin'=>true,
                ),
		'urlManager'=>array(
			'class' => 'ext.components.language.XUrlManager',
			'urlFormat'=>'path',
			'showScriptName'=>true,
			'appendParams'=>false,
			'rules'=>array(
				'<language:\w{2}>' => 'site/index',
				'<language:\w{2}>/<_c:\w+>' => '<_c>',
				'<language:\w{2}>/<_c:\w+>/<_a:\w+>'=>'<_c>/<_a>',
				'<language:\w{2}>/<_m:\w+>' => '<_m>',
				'<language:\w{2}>/<_m:\w+>/<_c:\w+>' => '<_m>/<_c>',
				'<language:\w{2}>/<_m:\w+>/<_c:\w+>/<_a:\w+>' => '<_m>/<_c>/<_a>',
			),
		),
		'authManager'=>array(
                        'class'=>'RDbAuthManager',
                        'connectionID'=>'db',
                        'itemTable'=>'AuthItem',
			'itemChildTable'=>'AuthItemChild',
			'assignmentTable'=>'AuthAssignment',
			'rightsTable'=>'Rights',
                        'defaultRoles'=>array('Guest'),
                ),
		'db'=>array(
			'connectionString' => 'sqlsrv:server=192.168.1.21;database=fpp;MultipleActiveResultSets=false;',
			'username' => 'sa',
			'password' => 'ptim*328',
			'charset' => 'utf8',
		),
                'dbTrial'=>array(
			'connectionString' => 'sqlsrv:server=192.168.1.21;database=trdat;MultipleActiveResultSets=false;',
			'username' => 'sa',
			'password' => 'ptim*328',
			'charset' => 'utf8',
                        'class'=>'CDbConnection',
		),
                'dbAccpac'=>array(
			'connectionString' => 'sqlsrv:server=192.168.1.21;database=sgtdat;MultipleActiveResultSets=false;',
			'username' => 'sa',
			'password' => 'ptim*328',
			'charset' => 'utf8',
                        'class'=>'CDbConnection',
		),               
                'Smtpmail'=>array(
			'class'=>'application.extensions.smtpmail.PHPMailer',
			'SMTPDebug'=>false,
			'Debugoutput'=>'html',
			'Host'=>'smtp.modena.co.id',
			'Port'=>587,
                    
			'SMTPSecure'=> 'tls',
			'SMTPAuth'=>true, 
			'Username'=>'support@modena.co.id',
			'Password'=>'sp_328_indomo',
			'Mailer'=>'smtp',
			'SMTPOptions'=> array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			)
		),
                'ePdf' => array(
                    'class' => 'application.extensions.yii-pdf.EYiiPdf',
                    'params'=> array(  
                            'mpdf'=> array(
                                'librarySourcePath' => 'application.vendor.mpdf.*',
                                'constants'=> array(
                                        '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                                ),
                                'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder.
                                /*'defaultParams'	  => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                                        'mode'				=> '', //  This parameter specifies the mode of the new document.
                                        'format'			=> 'A4', // format A4, A5, ...
                                        'default_font_size' => 0, // Sets the default document font size in points (pt)
                                        'default_font'		=> '', // Sets the default font-family for the new document.
                                        'mgl'				=> 15, // margin_left. Sets the page margins for the new document.
                                        'mgr'				=> 15, // margin_right
                                        'mgt'				=> 16, // margin_top
                                        'mgb'				=> 16, // margin_bottom
                                        'mgh'				=> 9, // margin_header
                                        'mgf'				=> 9, // margin_footer
                                        'orientation'		=> 'P', // landscape or portrait orientation
                                )*/
                            ),                            
                    ),
		),
                /*'mailer' => array(
                    'class' => 'ext.swiftMailer.SwiftMailer',
                    // Using SMTP:
                    'mailer' => 'smtp',
                    // security is optional
                    // 'ssl' for "SSL/TLS" or 'tls' for 'STARTTLS'
                    //'security' => 'ssl', 
                    'host'=>'smtp.modena.co.id',
                    'from'=>'mes.support@modena.co.id',
                    //'username'=>'smptusername',
                    //'password'=>'123456',
                    // Using sendmail:
                    'mailer'=>'sendmail',
                    // Logging
                    // logs brief messages about message success or failhure
                    //logMailerActivity => true, 
                    // logs additional info from SwiftMailer about connection details 
                    // must be used in conjunction with logMailerActivity == true
                    // check the send() method for realtime logging to console if required
                    //logMailerDebug => true, 
                    
                    /*
                     * Yii::app()->mailer->addAddress($email);
                        Yii::app()->mailer->subject("Let's do this!");
                        Yii::app()->mailer->msgHTML("<a href='http://site.com'>test</a>");
                        Yii::app()->mailer->send();

                        or

                        Yii::app()->mailer->addAddress($email)
                            ->subject("Let's do this!")
                            ->msgHTML("<a href='http://site.com'>test</a>")
                            ->send();
                     */
                //),
		'cache'=>array(
			'class'=>'CDbCache',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);