<?php

namespace Ticket\Booking\Block\Product;

use Magento\Framework\View\Element\Template;
use Ticket\Booking\Model\ResourceModel\BookingSeats\CollectionFactory;
use Magento\Catalog\Model\ProductFactory;

class SelectSeats extends Template
{
    private $bookingSeats;
    protected $productFactory;
    protected $itemCollection;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        \Ticket\Booking\Model\ResourceModel\Item\CollectionFactory $itemCollectionFactory,
        ProductFactory $productFactory,
        array $data = [])
    {
        $this->bookingSeats = $collectionFactory->create();
        $this->productFactory = $productFactory;
        $this->itemCollection = $itemCollectionFactory->create();
        parent::__construct($context, $data);
    }

    public function getSelectedSeats($productId, $date)
    {
        $itemId = $this->itemCollection->getBookingItem($productId, $date)->getId();
        $bookingSeats = $this->bookingSeats->getBookingSeats($itemId);
        if ($bookingSeats) {
            foreach ($bookingSeats as $bookingSeat) {
                $seats = $bookingSeat->getSeats();
            }
        } else {
            $seats = '';
        }

//        return explode(', ', $seats);
        return $seats;
    }

    public function getInfoProduct($productId){
        $product = $this->productFactory->create()->load($productId);
        $info = [];
        $info = [
            'start_location' => $product->getStartLocation(),
            'end_location' => $product->getEndLocation(),
            'time' => $product->getTime(),
            'date' => $product->getDate(),
            'number_plate' => $product->getNumberPlate()
        ];
        return $info;
    }
}
