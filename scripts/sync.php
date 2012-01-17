<?php

$projectPath = realpath(dirname(__FILE__) . '/..');
$configPath = $projectPath . "/application/configs/application.ini";
$libraryPath = $projectPath . "/library/";
$deltaPath = $projectPath . "/sql/";
$logPath = $projectPath . "/logs/sync.log";

$paths = array($libraryPath, get_include_path());
set_include_path(implode(PATH_SEPARATOR, $paths));

require 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('App_');
$loader->registerNamespace('Application_');
defined('APPLICATION_PATH') || define('APPLICATION_PATH', $projectPath.'/application');

define ("APPLICATION_ENV", 'development');
date_default_timezone_set('America/Lima');


$config = new Zend_Config_Ini($configPath, APPLICATION_ENV);
$db = Zend_Db::factory($config->resources->db);
$log = new Zend_Log(new Zend_Log_Writer_Stream($logPath));

// Create application, bootstrap, and run
$application = new Zend_Application(APPLICATION_ENV, $configPath);
$application->bootstrap();

$mmm = new App_Migration_Manager($db, $deltaPath, $log);
$mmm->sync();
