<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Model\ResourceModel\Ward;

use Ticket\Directory\Model\ResourceModel\AbstractCollection;
use Psr\Log\LoggerInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Collection
 * @package Ticket\Directory\Model\ResourceModel\Ward
 */
class Collection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    protected $_idFieldName = 'ward_id';

    /**
     * {@inheritdoc}
     */
    protected $_foreignKey = 'district_id';

    /**
     * {@inheritdoc}
     */
    protected $_defaultOptionLabel = 'Please select ward';

    /**
     * {@inheritdoc}
     */
    protected $_sortable = true;

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(\Ticket\Directory\Model\Ward::class, \Ticket\Directory\Model\ResourceModel\Ward::class);
    }
}
