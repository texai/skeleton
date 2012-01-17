<?php

class App_Auth_Adapter_DbTable_Salted extends Zend_Auth_Adapter_DbTable
{
    
    protected $_where = null;
    
    public function __construct(
        Zend_Db_Adapter_Abstract $zendDb = null,
        $tableName = null,
        $identityColumn = null,
        $credentialColumn = null,
        $credentialTreatment = null,
        $where = null
    ) {
        parent::__construct(
            $zendDb,
            $tableName,
            $identityColumn,
            $credentialColumn,
            $credentialTreatment
        );
        if (null !== $where) {
            $this->_where = $where;
        }
        
    }

    public function authenticate()
    {
        $this->_authenticateSetup();

        $sql = $this->_zendDb->select()->from($this->_tableName)
                ->where($this->_identityColumn . ' = ?', $this->_identity);
        if(!is_null($this->_where)){
            $sql->where($this->_where);
        }
        
        $row = $this->_zendDb->fetchRow($sql, array(), Zend_Db::FETCH_ASSOC);
        $row['zend_auth_credential_match'] = 0;
        if (
            array_key_exists($this->_credentialColumn, $row)
            && self::checkPassword($this->_credential, $row[$this->_credentialColumn])
        ){
            $row['zend_auth_credential_match'] = 1;
        }

        return $this->_authenticateValidateResult($row);
    }
    
    /**
     * Genera contraseña
     * 
     * @param string $rawPassword
     * @param string $algo Algoritmo usado para generar la contraseña. md5, sha1
     * @return string
     */
    public static function generatePassword($rawPassword, $algo='sha1')
    {
        $salt = substr(md5(rand(0, 999999) + time()), 6, 5);
        $passw = '';
        
        if ($algo == 'sha1') {
            $passw = $algo . '$' . $salt . '$' . sha1($salt . $rawPassword);
        } else {
            $passw = $algo . '$' . $salt . '$' . md5($salt . $rawPassword);
        }
        
        return $passw;
    }
    
    /**
     * Retorna true si el password es correcto
     * 
     * @param string $rawPassword
     * @param string $encPassword
     * @return bool
     */
    public static function checkPassword($rawPassword, $encPassword)
    {
        $parts = explode('$', $encPassword);
        if (count($parts) != 3) {
            return false;
        }
        
        $algo = strtolower($parts[0]);
        $salt = $parts[1];
        $encPass = $parts[2];
        
        $credentialEnc = '';
        if ($algo == 'sha1') {
            $credentialEnc = sha1($salt . $rawPassword, false);
        } else {
            $credentialEnc = md5($salt . $rawPassword, false);
        }
        
        return $credentialEnc == $encPass;
    }
    
}