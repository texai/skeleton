<?php

/**
 * Description of User
 *
 * @author texai
 */
class Application_Model_User extends App_Db_Table_Abstract
{
    protected $_name = 'user';
    
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    
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