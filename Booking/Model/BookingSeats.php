<?php

namespace Ticket\Booking\Model;

use Magento\Framework\Model\AbstractModel;

class BookingSeats extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Ticket\Booking\Model\ResourceModel\BookingSeats');
    }
}
