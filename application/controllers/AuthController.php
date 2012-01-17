<?php

class AuthController extends App_Controller_Action
{
    
    public function init() {
        parent::init();
        $this->view->headScript()->appendFile($this->view->s('/js/auth.js'));            
    }

    public function loginAction()
    {
        $this->_helper->layout->setlayout('login');
        $form = new App_Form_Login();
        if( $this->_request->isPost() ){
            $params = $this->_getAllParams();
            if($form->isValid($params)){
                $this->_helper->redirector->gotoUrl('/');
            }
        }
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector->gotoRoute(array(), 'login', true);
    }
}

