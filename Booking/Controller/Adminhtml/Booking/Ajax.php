<?php


namespace Ticket\Booking\Controller\Adminhtml\Booking;


use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;


class Ajax extends Action
{
    protected $jsonFactory;
    protected $itemCollection;

    public function __construct(
        Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Ticket\Booking\Model\ResourceModel\Item\CollectionFactory $itemCollectionFactory
    ) {
        parent::__construct($context);
        $this->itemCollection = $itemCollectionFactory->create();
        $this->jsonFactory = $jsonFactory;

    }

    public function execute()
    {
        if (!$this->getRequest()->isAjax()) {
            $this->_redirect('/');
            return;
        }

        $post = $this->getRequest()->getPostValue();
        $productId = $post['productId'];
        $date = $post['date'];
        $itemId = $this->itemCollection->getBookingItem($productId, $date)->getId();

        $result = $this->jsonFactory->create();
        $result->setData( $itemId);

        return $result;
    }
}
