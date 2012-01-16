<?php
/**
 * Description of Abstract
 */
class App_Db_Table_Abstract extends Zend_Db_Table_Abstract
{
    protected $_config;
    protected $_prefix;
    protected $_db;
    protected $_log;
    protected $_cache;

    public function __construct($config = array()) 
    {
        $this->_config = Zend_Registry::get('config');
        $this->_log = Zend_Registry::get('log');
        $this->_prefix = $this->_name.'_';
        $this->_db = $this->getAdapter();
        $this->_cache = Zend_Registry::get('cache');
        
        parent::__construct($config);
    }
    
    public function cache( $func, $cacheid, $variant = null )
    {
        $cacheid = $this->_prefix . $cacheid;
        $exp = $this->_config->cache->$cacheid;
        $cacheid = is_null($variant)?$cacheid:str_replace('ID', $variant, $cacheid);
        if($this->_cache->test($cacheid)){
            $value = $this->_cache->load($cacheid);
        } else {
            $value = $func();
            $this->_cache->save($value, $cacheid, array(), $exp);
        }
        return $value;
    }
     
}
