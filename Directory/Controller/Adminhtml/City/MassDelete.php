<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Controller\Adminhtml\City;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\View\Result\PageFactory;
use Ticket\Directory\Model\CityFactory;
use Magento\Framework\Controller\ResultFactory;
use Ticket\Directory\Controller\Adminhtml\City;
use Magento\Framework\App\Cache\Type\Config;

/**
 * Class MassDelete
 * @package Ticket\Directory\Controller\Adminhtml\City
 */
class MassDelete extends City
{
    /**
     * @var Filter
     */
    protected $_filter;

    /**
     * Constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param CityFactory $cityFactory
     * @param Filter $filter
     * @param Config $config
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        CityFactory $cityFactory,
        Filter $filter,
        Config $config
    ) {
        $this->_filter = $filter;
        parent::__construct($context, $resultPageFactory, $cityFactory, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $collection = $this->_filter->getCollection($this->_getCityCollection());
        $deletedCounter = 0;

        foreach ($collection->getItems() as $city) {
            $city->delete();
            $deletedCounter++;
        }
        $this->reInitObject();
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $deletedCounter));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
