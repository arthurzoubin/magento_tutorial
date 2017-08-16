<?php

/**
 * Created by PhpStorm.
 * User: imaginato
 * Date: 17-7-31
 * Time: 上午9:06
 */
class Tutorial_HelloCustomer_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction() {
        $_helloCustomer = Mage::getModel('hellocustomer/helloCustomer')->getCollection();
        print_r($_helloCustomer->getData());
    }
}