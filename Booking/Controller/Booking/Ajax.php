<?php


namespace Ticket\Booking\Controller\Booking;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Ajax extends Action
{
    protected $jsonFactory;

    protected $selectSeats;

    public function __construct(
        Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Ticket\Booking\Block\Product\SelectSeats $selectSeats
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->selectSeats = $selectSeats;
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
        $selectedSeats = $this->selectSeats->getSelectedSeats($productId, $date);

        $result = $this->jsonFactory->create();
        $result->setData($selectedSeats);

        return $result;
    }
}
