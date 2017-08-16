<?php

class Tutorial_HelloCustomer_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('sales')->_addBreadcrumb('sales', 'sales');
    }

    public function indexAction()
    {
        $this->_initAction();

        $this->renderLayout();
    }
}