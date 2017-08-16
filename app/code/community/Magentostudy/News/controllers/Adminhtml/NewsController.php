<?php

/**
 * Created by PhpStorm.
 * User: imaginato
 * Date: 17-8-8
 * Time: 下午2:44
 */
class Magentostudy_News_Adminhtml_NewsController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('news/manage')
            ->_addBreadcrumb(
                Mage::helper('magentostudy_news')->__('News'),
                Mage::helper('magentostudy_news')->__('News')
            )
            ->_addBreadcrumb(
                Mage::helper('magentostudy_news')->__('Manage News'),
                Mage::helper('magentostudy_news')->__('Manage News')
            );
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__('News'))
            ->_title($this->__('Manage News'));
        $this->_initAction();
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('News'))
            ->_title($this->__('Manage News'));

        $model = Mage::getModel('magentostudy_news/news');

        $newsId = $this->getRequest()->getParam('id');
        if($newsId)
        {
            $model->load($newsId);

            if(!$model->getId())
            {
                $this->_getSession()->addError(Mage::helper('magentostudy_news')->__('News item does not exist.'));
                return $this->_redirect('*/*/');
            }
            $this->_title($model->getTitle());
            $breadCrumb = Mage::helper('magentostudy_news')->__('Edit Item');
        }
        else{
            $this->_title(Mage::helper('magentostudy_news')->__('New Item'));
            $breadCrumb = Mage::helper('magentostudy_news')->__('New Item');
        }

        $this->_initAction()->_addBreadcrumb($breadCrumb, $breadCrumb);

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if(!empty($data))
        {
            $model->addData($data);
        }

        Mage::register('news_item', $model);

        $this->renderLayout();
    }

    public function saveAction()
    {
        $redirectPath = '*/*';
        $redirectParams = array();

        $data = $this->getRequest()->getPost();
        if($data)
        {
            $data = $this->_filterPostData($data);
            $model = Mage::getModel('magentostudy_news/news');

            $newsId = $this->getRequest()->getParam('news_id');
            if($newsId)
            {
                $model->load($newsId);
            }
            if(isset($data['image']))
            {
                $imageData = $data['image'];
                unset($data['image']);
            }
            else
            {
                $imageData = array();
            }
            $model->addData($data);

            try{
                $hasError = false;
                $imageHelper = Mage::helper('magentostudy_news/image');
                if(isset($imageData['delete']) && $model->getImage())
                {
                    $imageHelper->removeImage($model->getImage());
                    $model->setImage(null);
                }

                $imageFile = $imageHelper->uploadImage('image');
                if($imageFile)
                {
                    if($model->getImage())
                    {
                        $imageHelper->removeImage($model->getImage());
                    }
                    $model->setImage($imageFile);
                }
                $model->save();
                $this->_getSession()->addSuccess(
                    Mage::helper('magentostudy_news')->__('The news item has been saved.')
                );

                if($this->getRequest()->getParam('back'))
                {
                    $redirectPath = '*/*/edit';
                    $redirectParams = array('id' => $model->getId());
                }
            }
            catch (Mage_Core_Exception $e)
            {
                $hasError = true;
                $this->_getSession()->addError($e->getMessage());
            }
            catch (Exception $e)
            {
                $hasError = true;
                $this->_getSession()->addException($e, Mage::helper('magentostudy_news')->__('An error occured while saving the news item.'));
            }

            if($hasError)
            {
                $this->_getSession()->setFormData($data);
                $redirectPath = '*/*/edit';
                $redirectParams = array('id' => $this->getRequest()->getParam('id'));
            }
        }

        $this->_redirect($redirectPath, $redirectParams);
    }

    public function deleteAction()
    {
        $itemId = $this->getRequest()->getParam('id');
        if($itemId)
        {
            try{
                $model = Mage::getModel('magentostudy_news/news');
                $model->load($itemId);
                if(!$model->getId())
                {
                    Mage::throwException(Mage::helper('magentostudy_news')->__('Unable to find a news item.'));
                }
                $model->delete();
                $this->_getSession()->addSuccess(Mage::helper('magentostudy_news')->__('The news item has been deleted.'));
            }
            catch (Mage_Core_Exception $e)
            {
                $this->_getSession()->addError($e->getMessage());
            }
            catch (Exception $e)
            {
                $this->_getSession()->addException($e, Mage::helper('magentostudy_news')->__('An error occured while deleting the news item.'));
            }
        }

        $this->_redirect('*/*/');
    }

    protected function _isAllowed()
    {
        switch ($this->getRequest()->getActionName())
        {
            case 'new':
            case 'save':
                return Mage::getSingleton('Admin/session')->isAllowed('news/manage/save');
                break;
            case 'delete':
                return Mage::getSingleton('Admin/session')->isAllowed('news/manage/delete');
                break;
            default:
                return Mage::getSingleton('Admin/session')->isAllowed('news/manage');
                break;
        }
    }

    protected function _filterPostData($data)
    {
        $data = $this->_filterDates($data, array('time_published'));
        return $data;
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function flushAction()
    {
        if(Mage::helper('magentostudy_news/image')->flushImageCache())
        {
            $this->_getSession()->addSuccess('Cache successfully flushed');
        }
        else
        {
            $this->_getSession()->addError('There was error during flushing cache');
        }
        $this->_forward('index');
    }
}