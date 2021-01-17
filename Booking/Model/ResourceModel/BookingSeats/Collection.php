<?php

namespace Ticket\Booking\Model\ResourceModel\BookingSeats;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    function _construct()
    {
        $this->_init('Ticket\Booking\Model\BookingSeats', 'Ticket\Booking\Model\ResourceModel\BookingSeats');
    }

    public function getBookingSeats($itemId)
    {
        $bookingSeats = $this->addFieldToFilter('product_booking_item_id', ['eq' => $itemId])->getItems();
        return $bookingSeats;
    }
}

