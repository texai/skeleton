<?php

class App_Controller_Action extends Zend_Controller_Action {

    /**
     *
     * @var Zend_Form_Element_Hash
     */
    protected $_hash = null;
    
    /**
     *
     * @var App_Controller_Action_Helper_FlashMessengerCustom
     */
    protected $_flashMessenger;

    public function init() {

        $this->_flashMessenger = $this->_helper->getHelper('FlashMessengerCustom');
        $this->view->fmsgs = $this->_flashMessenger->getMessages();
        $this->_hash = new Zend_Form_Element_Hash('csrf_hash', array('salt' => 'exitsalt'));
        $this->_hash->setTimeout(3600);
        $this->_hash->initCsrfToken();
        $csrfhash = $this->_hash->getValue();
        $this->view->csrfhash = $csrfhash;
        defined('CSRF_HASH')
                || define('CSRF_HASH', $csrfhash);
        parent::init();
    }

    /**
     * Pre-dispatch routines
     * Asignar variables de entorno
     *
     * @return void
     */
    public function preDispatch() {
        parent::preDispatch();
        $config = $this->getConfig();

        $this->config = $this->getConfig();
        $this->log = $this->getLog();
        $this->cache = $this->getCache();
        $this->siteUrl = $this->config->app->siteUrl;
        $this->view->assign('siteUrl', $config->app->siteUrl);

        if (APPLICATION_ENV != 'production') {
            $sep = sprintf('[%s]', strtoupper(substr(APPLICATION_ENV, 0, 3)));
            $this->view->headTitle()->prepend($sep);
        }
    }


    /**
     * Retorna la instancia personalizada de FlashMessenger
     * Forma de uso:
     * $this->getMessenger()->info('Mensaje de información');
     * $this->getMessenger()->success('Mensaje de información');
     * $this->getMessenger()->error('Mensaje de información');
     *
     * @return App_Controller_Action_Helper_FlashMessengerCustom
     */
    public function getMessenger() {
        return $this->_flashMessenger;
    }

    /**
     *
     * @see Zend/Controller/Zend_Controller_Action::getRequest()
     * @return Zend_Controller_Request_Http
     */
    public function getRequest() {
        return parent::getRequest();
    }

    /**
     * Retorna un objeto Zend_Config con los parámetros de la aplicación
     *
     * @return Zend_Config
     */
    public function getConfig() {
        return Zend_Registry::get('config');
    }

    /**
     * Retorna el objeto cache de la aplicación
     *
     * @return Zend_Cache_Core
     */
    public function getCache() {
        return Zend_Registry::get('cache');
    }

    /**
     * Retorna el adaptador
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public function getAdapter() {
        return Zend_Registry::get('db');
    }

    /**
     * Retorna el objeto Zend_Log de la aplicación
     *
     * @return Zend_Log
     */
    public function getLog() {
        return Zend_Registry::get('log');
    }

    public function getSession() {
        $session = new Zend_Session_Namespace();
        return $session;
    }

}