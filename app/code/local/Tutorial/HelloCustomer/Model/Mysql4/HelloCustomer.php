<?php

/**
 * Created by PhpStorm.
 * User: imaginato
 * Date: 17-7-31
 * Time: 下午12:19
 */
class Tutorial_HelloCustomer_Model_Mysql4_HelloCustomer extends Mage_Core_Model_Mysql4_Abstract {
    public function _construct() {
        $this->_init('hellocustomer/hellocustomer', 'id');
    }
}