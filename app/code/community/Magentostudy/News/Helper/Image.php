<?php

/**
 * Created by PhpStorm.
 * User: imaginato
 * Date: 17-8-8
 * Time: 下午12:39
 */
class Magentostudy_News_Helper_Image extends Mage_Core_Helper_Abstract
{
    const MEDIA_PATH = 'news';

    const MAX_FILE_SIZE = 1048576;

    const MIN_HEIGHT = 50;

    const MAX_HEIGHT = 800;

    const MIN_WIDTH = 50;

    const MAX_WIDTH = 800;

    protected $_imageSize = array(
        'minheight' => self::MIN_HEIGHT,
        'minwidth'  => self::MIN_WIDTH,
        'maxheight' => self::MAX_HEIGHT,
        'maxwidth'  => self::MAX_WIDTH,
    );

    protected $_allowedExtensions = array('jpg', 'gif', 'png');

    public function getBaseDir()
    {
        return Mage::getBaseDir('media') . DS . self::MEDIA_PATH;
    }

    public function getBaseUrl()
    {
        return Mage::getBaseUrl('media') . '/' . self::MEDIA_PATH;
    }

    public function removeImage($imageFile)
    {
        $io = new Varien_Io_File();
        $io->open(array('path' => $this->getBaseDir()));
        if($io->fileExists($imageFile))
        {
            return $io->rm($imageFile);
        }
        return false;
    }

    public function uploadImage($scope)
    {
        $adapter = new Zend_File_Transfer_Adapter_Http();
        $adapter->addValidator('ImageSize', true, $this->_imageSize);
        $adapter->addValidator('Size', true, self::MAX_FILE_SIZE);
        if($adapter->isUploaded($scope))
        {
            if(!$adapter->isValid($scope))
            {
                Mage::throwException(Mage::helper('magentostudy_news'))->__('Uploaded image is not vaild');
            }
            $upload = new Varien_File_Uploader($scope);
            $upload->setAllowCreateFolders(true);
            $upload->setAllowedExtensions($this->_allowedExtensions);
            $upload->setAllowRenameFiles(true);
            $upload->setFilesDispersion(false);
            if($upload->save($this->getBaseDir()))
            {
                return $upload->getUploadedFileName();
            }
        }
        return false;
    }

    public function resize(Magentostudy_News_Model_News $item, $width, $height = null)
    {
        if(!$item->getImage())
        {
            return false;
        }

        if($width < self::MIN_WIDTH || $width > self::MAX_WIDTH)
        {
            return false;
        }

        if(!is_null($height))
        {
            if($height < self::MIN_HEIGHT || $height > self::MAX_HEIGHT)
            {
                return false;
            }
            $height = (int)$height;
        }

        $imageFile = $item->getImage();
        $cacheDir = $this->getBaseDir() . DS . 'cache' . DS . $width;
        $cacheUrl = $this->getBaseUrl() . '/' . 'cache' . '/' . $width . '/';

        $io = new Varien_Io_File();
        $io->checkAndCreateFolder($cacheDir);
        $io->open(array('path' => $cacheDir));
        if($io->fileExists($imageFile))
        {
            return $cacheUrl . $imageFile;
        }

        try{
            $image = new Varien_Image($this->getBaseDir() . DS . $imageFile);
            $image->resize($width, $height);
            $image->save($cacheDir . DS . $imageFile);
            return $cacheUrl . $imageFile;
        }
        catch (Exception $e)
        {
            Mage::logException($e);
            return false;
        }
    }

    public function flushImagesCache()
    {
        $cacheDir = $this->getBaseDir() . DS . 'cache' . DS ;
        $io = new Varien_Io_File();
        if($io->fileExists($cacheDir, false))
        {
            return $io->rmdir($cacheDir, true);
        }
        return true;
    }
}