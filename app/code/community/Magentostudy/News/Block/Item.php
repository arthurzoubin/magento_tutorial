<?php

/**
 * Created by PhpStorm.
 * User: imaginato
 * Date: 17-8-8
 * Time: 上午11:08
 */
class Magentostudy_News_Block_Item extends Mage_Core_Block_Template
{
    protected $_item;

    protected function _getBackUrlQueryParams($additionalParams = array())
    {
        return array_merge(array('p' => $this->getPage()), $additionalParams);
    }

    public function getBaseUrl()
    {
        return $this->getUrl('*/', array('_query' => $this->_getBackUrlQueryParams()));
    }

    public function getImageUrl($item, $width)
    {
        return Mage::helper('magentostudy_news/image')->resize($item, $width);
    }
}