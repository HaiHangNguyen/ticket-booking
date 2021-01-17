<?php

namespace Ticket\Booking\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Orders extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('ticket_booking_orders', 'id');
    }

    public function insertMultiple($data)
    {
        try {
            $this->getConnection()->insertMultiple(
                $this->getTable('ticket_booking_orders'),
                $data
            );
        } catch (LocalizedException $e) {
        }
    }
}