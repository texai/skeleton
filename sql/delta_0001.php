<?php
class Delta_0001 extends App_Migration_Delta
{
    protected $_author = "Ernesto Anaya";
    protected $_desc = "Admin user";

    public function up()
    {
//        $sql = "CREATE TABLE t(f INT); DROP TABLE t;";
//        $this->_db->query($sql);
        
        $mUser = new Application_Model_User();
        $mUser->insert(array(
            'name' => 'Admin',
            'lastname' => 'User',
            'email' => 'admin@example.com',
            'pwd' => App_Auth_Adapter_DbTable_Salted::generatePassword('admin'),
            'role' => Application_Model_User::ROLE_ADMIN,
            'active' => 1,
            'created_at' => date(DATE_DB),
            'created_by' => null
        ));
        
        return true;
    }
}