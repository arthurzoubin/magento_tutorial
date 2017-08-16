<?php

/**
 * Created by PhpStorm.
 * User: imaginato
 * Date: 17-7-31
 * Time: 上午8:35
 */
class Tutorial_HelloWorld_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction() {
        if(Mage::getStoreConfig('tutorialmodule/general/enabled')) {
            $params = $this->getRequest()->getParams();
            echo '--- Url params ---<br/>';
            print_r($params);
            echo '<br/>';
            echo '--- Hello World ---<br/>';
            echo 'Hello World!';
        } else {
            echo 'This module is disabled.';
        }
    }
}