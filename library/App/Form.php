<?php
class App_Form extends Zend_Form
{
    public function init() {
        parent::init();
        $this->setAttrib('class', 'zfForm form-stacked');
    }
}