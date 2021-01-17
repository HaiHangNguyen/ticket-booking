<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Controller\Adminhtml;

use Ticket\Directory\Helper\Data;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Ticket\Directory\Model\WardFactory;
use Magento\Backend\App\Action;
use Ticket\Directory\Model\District as WardModel;
use Magento\Framework\App\Cache\Type\Config;

/**
 * Class Ward
 * @package Ticket\Directory\Controller\Adminhtml
 */
abstract class Ward extends Action
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Ticket_Directory::ward';

    /**
     * @type PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var WardFactory
     */
    protected $_wardFactory;
    /**
     * @var Config
     */
    protected $configCacheType;

    /**
     * Constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param WardFactory $wardFactory
     * @param Config $configCacheType
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        WardFactory $wardFactory,
        Config $configCacheType
    ) {

        $this->_resultPageFactory = $resultPageFactory;
        $this->_wardFactory = $wardFactory;
        $this->configCacheType = $configCacheType;
        parent::__construct($context);
    }

    /**
     * Init layout, menu and breadcrumb
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Ticket_Directory::ward');
        $resultPage->addBreadcrumb(__('Ward'), __('Ward'));
        $resultPage->addBreadcrumb(__('Ward'), __('Ward'));

        return $resultPage;
    }

    /**
     * Init District
     *
     * @return bool|WardModel
     */
    protected function _initObject()
    {
        $wardId = (int)$this->getRequest()->getParam('id');
        $ward = $this->_wardFactory->create();

        if ($wardId) {
            $ward->load($wardId);
            if (!$ward->getId()) {
                $this->messageManager->addErrorMessage(__('This ward no longer exists.'));

                return false;
            }
        }

        return $ward;
    }

    /**
     * Get ward collection
     *
     * @return mixed
     */
    protected function _getWardCollection()
    {
        return $this->_wardFactory->create()->getCollection();
    }

    protected function reInitObject(){
        $this->configCacheType->clean(\Zend_Cache::CLEANING_MODE_MATCHING_TAG,[Data::CACHE_TAG_WARD, Data::CACHE_TAG_DATA]);
    }
}
