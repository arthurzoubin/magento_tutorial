<?php

/**
 * Created by PhpStorm.
 * User: imaginato
 * Date: 17-8-8
 * Time: 上午10:14
 */
class Magentostudy_News_Model_Resource_News extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        // TODO: Implement _construct() method.
        $this->_init('magentostudy_news/news', 'news_id');
    }
}