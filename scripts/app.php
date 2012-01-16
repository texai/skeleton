<?php
    //date_default_timezone_set('Europe/London');

    define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
	
    set_include_path(
        implode(
            PATH_SEPARATOR,
            array(
                realpath(APPLICATION_PATH . '/../library'),
                get_include_path()
            )
        )
    );
    require_once 'Zend/Loader/Autoloader.php';

    $autoloader = Zend_Loader_Autoloader::getInstance();

	$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/private.ini');
	$env = count($argv)>1?$argv[1]:$config->env;
	define ("APPLICATION_ENV", $env);
	
    // Create application, bootstrap, and run
    $application = new Zend_Application(
        APPLICATION_ENV,
        APPLICATION_PATH . '/configs/application.ini'
    );
    $application->bootstrap();