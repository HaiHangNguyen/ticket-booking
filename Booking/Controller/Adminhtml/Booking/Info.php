<?php

namespace Ticket\Booking\Controller\Adminhtml\Booking;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Info extends Action
{
    private $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory
    ) {
        $this->resultPageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Show Information Seats')));

        return $resultPage;
    }
}
