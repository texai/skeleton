<?php

class UserController extends App_Controller_Action
{
    
    /**
     *
     * @var Application_Model_User
     */
    protected $mUser;

    public function init() {
        parent::init();
        $this->mUser = new App_Model_User();
        $this->indexUrl = $this->view->url(array('controller'=>'user','action'=>'index'),null,true);
    }
    
    public function indexAction()
    {
        $this->view->list = $this->mUser->fetchAll();
    }
    
    public function newAction()
    {
        $form = new App_Form_User();
        if($this->_request->isPost()){
            $params = $this->_getAllParams();
            if($form->isValid($params)){
                $this->mUser->create($form->getValues(), $this->authData->id);
                $this->getMessenger()->success('New User Added');
                $this->_redirect($this->indexUrl);
            }
        }
        $this->view->form = $form;
    }
    
    public function activateAction() {
        $this->changeActiveFlag('1', 'User Activated');
    }

    public function deactivateAction() {
        $this->changeActiveFlag('0', 'User Deactivated');
    }
    
    private function changeActiveFlag($value, $msg){
        $db = $this->mUser->getAdapter();
        $where = $db->quoteInto('id = ?', $this->_getParam('id'));
        $this->mUser->update(array('active'=>$value), $where);
        $this->getMessenger()->success($msg);
        $this->_redirect($this->indexUrl);
    }
    
    


}