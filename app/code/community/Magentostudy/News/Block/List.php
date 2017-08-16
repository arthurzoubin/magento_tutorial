<?php

/**
 * Created by PhpStorm.
 * User: imaginato
 * Date: 17-8-8
 * Time: 上午10:55
 */
class Magentostudy_News_Block_list extends Mage_Core_Block_Template
{
    protected $_newsCollection = null;

    protected function _getCollection()
    {
        return Mage::getResourceModel('magentostudy_news/news_collection');
    }

    public function getCollection()
    {
        if(is_null($this->_newsCollection))
        {
            $this->_newsCollection = $this->_getCollection();
            $this->_newsCollection->prepareForList($this->getCurrentPage());
        }

        return $this->_newsCollection;
    }

    public function getItemUrl($newsItem)
    {
        return $this->getUrl('*/*/view', array('id' => $newsItem->getId()));
    }

    public function getCurrentPage()
    {
        return $this->getData('current_page') ? $this->getData('current_page') : 1;
    }

    public function getPager()
    {
        $pager = $this->getChild('news_list_pager');
        if($pager)
        {
            $newsPerPage = Mage::helper('magentostudy_news')->getNewsPerPage();

            $pager->setAvailableLimit(array($newsPerPage => $newsPerPage));
            $pager->setTotalNum($this->getCollection()->getSize());
            $pager->setCollection($this->getCollection());
            $pager->setShowPerPage(true);

            return $pager->toHtml();
        }

        return null;
    }

    public function getImageUrl($item, $width)
    {
        return Mage::helper('magentostudy_news/image')->resize($item, $width);
    }
}