<?php

/**
 * Description of User
 *
 * @author texai
 */
class App_Model_User extends App_Db_Table_Abstract
{
    protected $_name = 'user';
    
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    
    public static function getRoles() {
        return array(
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_USER => 'User'
        );
    }
    
    public function create($values, $by){
        $extra = array(
            'pwd' => App_Auth_Adapter_DbTable_Salted::generatePassword($values['pwd']),
            'active' => '1',
            'created_at' => date(DATE_DB),
            'created_by' => $by
        );
        $this->insert($extra + $values);
    }
    
    
    public function test(){
        $p = 9;
        return $this->cache(function() use ($p) {
            return rand(0,$p);
        }, 'test');
    }
    
    public function test2($id){
        $this->getAdapter()->fetchAll("SELECT * FROM user");
        $p = 99;
        return $this->cache(function() use ($p) {
            return rand(0,$p);
        }, 'test2_ID', $id);
    }
    
}