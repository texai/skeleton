<?php

class IndexController extends App_Controller_Action
{

    public function indexAction()
    {
        // action body
    }

    public function xAction()
    {
        
        $this->log->debug('hellowww');
        $m = new Application_Model_User();
        $id = rand(1,5);
        echo $id.":".$m->test2($id);
        
    }


}

