<?php

/**
 * Created by PhpStorm.
 * User: imaginato
 * Date: 17-8-8
 * Time: 下午12:31
 */
class Magentostudy_News_Helper_Data extends Mage_Core_Helper_Data
{
    const XML_PATH_ENABLED = 'news/view/enabled';

    const XML_PATH_ITEMS_PER_PAGE = 'news/view/items_per_page';

    const XML_PATH_DAYS_DIFFERENCE = 'news/view/days_difference';

    protected $_newsItemInstance;

    public function isEnabled($store = null)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $store);
    }

    public function getNewsPerPage($store = null)
    {
        return abs((int)Mage::getStoreConfig(self::XML_PATH_ITEMS_PER_PAGE, $store));
    }

    public function getDaysDifference($store = null)
    {
        return abs((int)Mage::getStoreConfig(self::XML_PATH_DAYS_DIFFERENCE, $store));
    }

    public function getNewsItemInstance()
    {
        if(!$this->_newsItemInstance)
        {
            $this->_newsItemInstance = Mage::registry('news_item');

            if(!$this->_newsItemInstance)
            {
                Mage::throwException($this->__('News item instance does not exist in Registry'));
            }
        }

        return $this->_newsItemInstance;
    }
}