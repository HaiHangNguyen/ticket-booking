<?php

namespace Ticket\Booking\Controller\Adminhtml\Orders;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $_resultPageFactory;

    public function __construct(Context $context, PageFactory $pageFactory)
    {
        $this->_resultPageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $pageResult = $this->_resultPageFactory->create();
        $pageResult->addBreadcrumb(__('Ticket Booking Orders'), __('Ticket Booking Orders'));
        $pageResult->getConfig()->getTitle()->prepend(__('Ticket Booking Orders'));
        return $pageResult;
    }
}