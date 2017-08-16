<?php
class Magentostudy_News_Block_Adminhtml_News_Edit_Form_Element_Image extends Varien_Data_Form_Element_Image
{
    protected function _getUrl()
    {
        $url = false;
        if($this->getValue())
        {
            $url = Mage::helper('magentostudy_news/image')->getBaseUrl() . '/' .$this->getValue();
        }
        return $url;
    }
}