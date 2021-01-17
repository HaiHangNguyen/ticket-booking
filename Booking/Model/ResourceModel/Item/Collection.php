<?php


namespace Ticket\Booking\Model\ResourceModel\Item;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    function _construct()
    {
        $this->_init('Ticket\Booking\Model\Item', 'Ticket\Booking\Model\ResourceModel\Item');
    }

    public function getBookingItem($prdId, $date)
    {
        $date = date("Y-m-d", strtotime($date));
        $item = $this->addFieldToFilter('product_booking_id', ['eq' => $prdId])
            ->addFieldToFilter('date', ['eq' => $date])->getFirstItem();
        return $item;
    }
}
