<?php

/**
 * Created by PhpStorm.
 * User: imaginato
 * Date: 17-8-8
 * Time: 下午1:56
 */
class Magentostudy_News_Model_Observer
{
    public function beforeNewsDisplayed(Varien_Event_Observer $observer)
    {
        $newsItem = $observer->getEvent()->getNewsItem();
        $currentDate = Mage::app()->getLocale()->date();
        $newsCreatedAt = Mage::app()->getLocale()->date(strtotime($newsItem->getCreatedAt()));
        $daysDifference = $currentDate->sub($newsCreatedAt)->getTimestamp() / (60 * 60 * 24);
        if($daysDifference < Mage::helper('magentostudy_news')->getDaysDifference())
        {
            Mage::getSingleton('core/session')->addSuccess(Mage::helper('magentostudy_news')->__('Recently added'));
        }
    }
}