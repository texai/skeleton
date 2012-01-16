<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initConfig()
    {
        $config = new Zend_Config($this->getOptions(), true);
        $inifiles = array('app','cache','private');
        foreach($inifiles as $file){
            $inifile = APPLICATION_PATH."/configs/$file.ini";
            if (is_readable($inifile))
                $config->merge(new Zend_Config_Ini($inifile));
        }
        $config->setReadOnly();
        $this->setOptions($config->toArray());
        Zend_Registry::set('config', $config);
    }
    
    public function _initView()
    {
        
        $doctypeHelper = new Zend_View_Helper_Doctype();
        $doctypeHelper->doctype(Zend_View_Helper_Doctype::XHTML1_TRANSITIONAL);
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $config = Zend_Registry::get('config');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8');
        $view->headMeta()->appendName("robots", "noindex, nofollow"); // for development
        
        $view->headTitle($config->app->title)->setSeparator(' - ');
        
        $view->headLink()->appendStylesheet(
            $config->app->mediaUrl . '/css/main.css', 'all'
        );
        $view->headLink()->appendStylesheet(
            $config->app->mediaUrl . '/css/ie.css', 'all', 'lte IE 8'
        );
        $view->headLink(
            array(
                'rel' => 'shortcut icon',
                'href' => $config->app->mediaUrl . '/images/favicon.ico'
            )
        );
        
        $view->headLink(
            array(
                'rel' => 'image_src',
                'href' => $config->app->mediaUrl . '/images/fb_share.png',
                'id' => "image_src"
            )
        );
        
        $view->headScript()->appendFile(
            $config->app->mediaUrl . '/js/jquery.js'
        );
        $view->headScript()->appendFile(
            $config->app->mediaUrl . '/js/main.js'
        );            

        $js = sprintf(
            "var urls = {
                siteUrl : '%s'
            }",
            $config->app->siteUrl
        );
        $view->headScript()->appendScript($js);
        
        //Definiendo Constante para Partials
        define('MEDIA_URL', $config->app->mediaUrl);
        define('ELEMENTS_URL', $config->app->elementsUrl);
        define('SITE_URL', $config->app->siteUrl);
        
        $view->addHelperPath('App/View/Helper', 'App_View_Helper');
    }
    

    public function _initRegistries()
    {
        $config = Zend_Registry::get('config');
        
        $this->_executeResource('cachemanager');
        $cacheManager = $this->getResource('cachemanager');
        Zend_Registry::set('cache', $cacheManager->getCache($config->app->cache));

        $this->_executeResource('db');
        $adapter = $this->getResource('db');
        Zend_Registry::set('db', $adapter);

        $this->_executeResource('log');
        $log = $this->getResource('log');
        Zend_Registry::set('log', $log);

        //Creacion de un Log para BD
        $columnMapping = array(
            'idusuario' => 'idusuario',
            'email' => 'email',
            'rol' => 'rol',
            'message' => 'message',
            'timestamp' => 'timestamp',
            'userIp' => 'userip',
            'userHost' => 'userhost'
        );
        $logger = new Zend_Log(new Zend_Log_Writer_Db($adapter, "log", $columnMapping));
        Zend_Registry::set('logDb', $logger);
    }
    
    public function _initActionHelpers()
    {
        // Adding hook action helpers
        //Zend_Controller_Action_HelperBroker::addHelper(
        //    new App_Controller_Action_Helper_FooBar()
        //);
    }
    
    
    

}

