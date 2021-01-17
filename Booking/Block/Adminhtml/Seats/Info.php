<?php

namespace Ticket\Booking\Block\Adminhtml\Seats;

use Magento\Backend\Block\Template;
use Ticket\Booking\Model\ResourceModel\Orders\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Model\ProductFactory;

class Info extends Template
{
    protected $orderCollection;
    protected $productFactory;
    protected $request;

    public function __construct(
        Template\Context $context,
        CollectionFactory $orderCollection,
        ProductFactory $productFactory,
        RequestInterface $request,
        array $data = [])
    {
        $this->orderCollection = $orderCollection;
        $this->productFactory = $productFactory;
        $this->request = $request;
        parent::__construct($context, $data);
    }

    public function getSeatInfo($bookingItemId)
    {
        $seats = [];
        $orders = $this->orderCollection->create()->addFieldToFilter('order_item_id', ['eq' => $bookingItemId])->getData();
        if (!empty($orders)) {
            foreach ($orders as $item) {
                $seats[$item['customer_name']] = explode(', ', $item['seats']);
            }
        }
        return $seats;
    }

    public function getProductInfo()
    {
        $productId =  $this->request->getParam('id');
        $data = [];
        $product = $this->productFactory->create()->load($productId);
        $data = [
            'product_id' => $productId,
            'name' => $product->getName(),
            'start_location' => $product->getStartLocation(),
            'end_location' => $product->getEndLocation(),
            'time' => $product->getTime(),
            'date' => $product->getDate(),
            'number_plate' => $product->getNumberPlate(),
            'info' => $product->getInfo()
        ];
        return $data;
    }
}
