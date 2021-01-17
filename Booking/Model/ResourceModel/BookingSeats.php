<?php

namespace Ticket\Booking\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class BookingSeats extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('ticket_booking_seats', 'id');
    }

    public function insertMultiple($data)
    {
        try {
            $this->getConnection()->insertMultiple(
                $this->getTable('ticket_booking_seats'),
                $data
            );
        } catch (LocalizedException $e) {
        }
    }
}
