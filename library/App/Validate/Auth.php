<?php

class App_Validate_Auth 
    extends Zend_Validate_Abstract
    implements Zend_Validate_Interface
{
    const LOGIN_FAILS = 'login_fails';

    protected $_identityElement;
    
    /**
     *
     * @var Zend_Auth_Adapter_DbTable
     */
    protected $_authAdapter;
    
    protected $_messageTemplates = array(
        self::LOGIN_FAILS => 'username or passwords are incorrect'
    );

    public function isValid($value, $context = null)
    {
        $value = (string) $value;
        $this->_setValue($value);

        $this->_authAdapter->setIdentity($context[$this->_identityElement]);
        $this->_authAdapter->setCredential($value);
        $result = Zend_Auth::getInstance()->authenticate($this->_authAdapter);
        if ( $result->isValid() ) {
            Zend_Auth::getInstance()->getStorage()->write(
                $this->_authAdapter->getResultRowObject(null, 'pwd')
            );
            return true;
        }

        $this->_error(self::LOGIN_FAILS);
        return false;
    }

    public function __construct($options = array())
    {
        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        }
        
        if (!array_key_exists('identity_element', $options)) {
            $options['identity_element'] = 'login';
        }
        
        if (!array_key_exists('adapter', $options)) {
            $options['adapter'] = null;
        }
        
        if (!array_key_exists('auth_table', $options)) {
            $options['auth_table'] = 'user';
        }
        
        if (!array_key_exists('identity_column', $options)) {
            $options['identity_column'] = 'login';
        }
        
        if (!array_key_exists('credential_column', $options)) {
            $options['credential_column'] = 'pwd';
        }
        
        if (!array_key_exists('where', $options)) {
            $options['where'] = null;
        }
        
        $this->_authAdapter = new App_Auth_Adapter_DbTable_Salted(
            $options['adapter'],
            $options['auth_table'],
            $options['identity_column'],
            $options['credential_column'],
            null,
            $options['where']
        );
        $this->_identityElement = $options['identity_element'];
    }

}