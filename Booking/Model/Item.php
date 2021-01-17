<?php


namespace Ticket\Booking\Model;


use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Ticket\Booking\Model\ResourceModel\Item');
    }
}
