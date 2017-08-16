<?php
class Magentostudy_News_Block_Adminhtml_News_Edit_Tab_Image extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        /**
         * Checking if user have permissions to save information
         */
        if (Mage::helper('magentostudy_news/Admin')->isActionAllowed('save'))
        {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('news_image_');
        $model = Mage::helper('magentostudy_news')->getNewsItemInstance();
        $fieldset = $form->addFieldset('image_fieldset', array('legend' => Mage::helper('magentostudy_news')->__('Image Thumbnail'), 'class' => 'fieldset-wide'
        ));
        $this->_addElementTypes($fieldset);
        $fieldset->addField('image', 'image', array(
            'name' => 'image',
            'label' => Mage::helper('magentostudy_news')->__('Image'),
            'title' => Mage::helper('magentostudy_news')->__('Image'),
            'required' => false,
            'disabled' => $isElementDisabled
        ));
        Mage::dispatchEvent('adminhtml_news_edit_tab_image_prepare_form', array('form' => $form));
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return Mage::helper('magentostudy_news')->__('Image Thumbnail');
    }

    public function getTabTitle()
    {
        return Mage::helper('magentostudy_news')->__('Image Thumbnail');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    protected function _getAdditionalElementTypes()
    {
        return array(
            'image' => Mage::getConfig()->getBlockClassName('magentostudy_news/adminhtml_news_edit_form_element_image')
        );
    }
}