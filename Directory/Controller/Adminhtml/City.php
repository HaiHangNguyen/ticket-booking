<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Controller\Adminhtml;

use Ticket\Directory\Helper\Data;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Ticket\Directory\Model\CityFactory;
use Magento\Backend\App\Action;
use Ticket\Directory\Model\City as CityModel;
use Magento\Framework\App\Cache\Type\Config;

/**
 * Class City
 * @package Ticket\Directory\Controller\Adminhtml
 */
abstract class City extends Action
{
    /**
     * {@inheritdoc}
     */
    const ADMIN_RESOURCE = 'Ticket_Directory::city';

    /**
     * @type PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var CityFactory
     */
    protected $_cityFactory;

    /**
     * @var Config
     */
    protected $configCacheType;

    /**
     * Constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param CityFactory $cityFactory
     * @param Config $configCacheType
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        CityFactory $cityFactory,
        Config $configCacheType
    ) {

        $this->_resultPageFactory = $resultPageFactory;
        $this->_cityFactory = $cityFactory;
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
        $resultPage->setActiveMenu('Ticket_Directory::city');
        $resultPage->addBreadcrumb(__('City'), __('City'));
        $resultPage->addBreadcrumb(__('City'), __('City'));

        return $resultPage;
    }

    /**
     * Init City
     *
     * @return bool|CityModel
     */
    protected function _initObject()
    {
        $cityId = (int)$this->getRequest()->getParam('id');
        $city = $this->_cityFactory->create();

        if ($cityId) {
            $city->load($cityId);
            if (!$city->getId()) {
                $this->messageManager->addErrorMessage(__('This city no longer exists.'));

                return false;
            }
        }

        return $city;
    }

    /**
     * Get city collection
     *
     * @return mixed
     */
    protected function _getCityCollection()
    {
        return $this->_cityFactory->create()->getCollection();
    }

    protected function reInitObject(){
        $this->configCacheType->clean(\Zend_Cache::CLEANING_MODE_MATCHING_TAG,[Data::CACHE_TAG_CITY, Data::CACHE_TAG_DATA]);
    }
}
