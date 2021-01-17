<?php


namespace Ticket\Booking\Model\ResourceModel\Orders;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    function _construct()
    {
        $this->_init('Ticket\Booking\Model\Orders', 'Ticket\Booking\Model\ResourceModel\Orders');
    }

    public function getOrdersByProduct($idProduct) {
        $bookingSeats = $this->addFieldToFilter('product_booking_id', ['eq' => $idProduct])->getItems();
        return $bookingSeats;
    }
}
