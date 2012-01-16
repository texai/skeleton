<?php

$projectPath = realpath(dirname(__FILE__) . '/..');
$configPath = $projectPath . "/application/configs/application.ini";
$libraryPath = $projectPath . "/library/";
$deltaPath = $projectPath . "/sql/";
$logPath = $projectPath . "/logs/sync.txt";

require 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('App_');
$loader->registerNamespace('Application_');
defined('APPLICATION_PATH') || define('APPLICATION_PATH', $projectPath.'/application');
$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/private.ini');
$env = 'development';

define ("APPLICATION_ENV", $env);
date_default_timezone_set('America/Lima');

$paths = array($libraryPath, get_include_path());
set_include_path(implode(PATH_SEPARATOR, $paths));


$config = new Zend_Config_Ini($configPath, $env);
$db = Zend_Db::factory($config->resources->db);
$log = new Zend_Log(new Zend_Log_Writer_Stream($logPath));

// Create application, bootstrap, and run
defined('APPLICATION_ENV') || define('APPLICATION_ENV', $env);
$application = new Zend_Application($env, $configPath);
$application->bootstrap();

$mmm = new App_Migration_Manager($db, $deltaPath, $log);
$mmm->sync();
