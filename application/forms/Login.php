<?php

class App_Form_Login extends App_Form
{
    public function init() {
        parent::init();
        
        // email
        $e = new Zend_Form_Element_Text('email');
        $e->setLabel('E-Mail');
        $e->setRequired();
        $v = new Zend_Validate_StringLength(array('min'=>3,'max'=>45));
        $e->addValidator($v);
        $v = new Zend_Validate_EmailAddress();
        $e->addValidator($v);
        $this->addElement($e);

        // pwd
        $e = new Zend_Form_Element_Password('pwd');
        $e->setLabel('Password');
        $v = new App_Validate_Auth(array(
            'identity_element'=>'email',
            'identity_column'=>'email',
            'where'=>'active=1'
        ));
        $e->addValidator($v);
        $e->setRequired();
        $this->addElement($e);
        
        // auth_hash
        $e = new Zend_Form_Element_Hash('auth_hash');
        $this->addElement($e);
        
        // submit
        $e = new Zend_Form_Element_Submit('login');
        $e->setLabel('Login');
        $e->setAttrib('class', 'btn primary');
        $this->addElement($e);
        
    }
}

?>
