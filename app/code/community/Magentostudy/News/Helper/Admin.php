<?php

/**
 * Created by PhpStorm.
 * User: imaginato
 * Date: 17-8-8
 * Time: 下午5:08
 */
class Magentostudy_News_Helper_Admin extends Mage_Core_Helper_Abstract
{
    public function isActionAllowed($action)
    {
        return Mage::getSingleton('Admin/session')->isAllowed('news/manage/' . $action);
    }
}