<?php
class Magentostudy_News_Block_Adminhtml_News_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('news_list_grid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('magentostudy_news/news')->getResourceCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('news_id', array(
            'header' => Mage::helper('magentostudy_news')->__('ID'),
            'width' => '50px',
            'index' => 'news_id',
        ));
        $this->addColumn('title', array(
            'header' => Mage::helper('magentostudy_news')->__('News Title'),
            'index' => 'title',
        ));
        $this->addColumn('author', array(
            'header' => Mage::helper('magentostudy_news')->__('Author'),
            'index' => 'author',
        ));
        $this->addColumn('published_at', array(
            'header' => Mage::helper('magentostudy_news')->__('Published On'),
            'sortable' => true,
            'width' => '170px',
            'index' => 'published_at',
            'type' => 'date',
        ));
        $this->addColumn('created_at', array(
            'header' => Mage::helper('magentostudy_news')->__('Created'),
            'sortable' => true,
            'width' => '170px',
            'index' => 'created_at',
            'type' => 'datetime',
        ));
        $this->addColumn('action', array(
            'header' => Mage::helper('magentostudy_news')->__('Action'),
            'width' => '100px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(array(
                    'caption' => Mage::helper('magentostudy_news')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                )),
            'filter' => false,
            'sortable' => false,
            'index' => 'news',
        ));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}