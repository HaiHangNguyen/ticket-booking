<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Model\ResourceModel\District;

use Ticket\Directory\Model\ResourceModel\AbstractCollection;
use Psr\Log\LoggerInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Collection
 * @package Ticket\Directory\Model\ResourceModel\City
 */
class Collection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    protected $_idFieldName = 'district_id';

    /**
     * {@inheritdoc}
     */
    protected $_foreignKey = 'city_id';

    /**
     * {@inheritdoc}
     */
    protected $_defaultOptionLabel = 'Please select district';

    /**
     * {@inheritdoc}
     */
    protected $_sortable = true;


    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(\Ticket\Directory\Model\District::class, \Ticket\Directory\Model\ResourceModel\District::class);
    }
}
