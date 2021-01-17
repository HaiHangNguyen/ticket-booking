<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Model\ResourceModel\City;

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
    protected $_idFieldName = 'city_id';

    /**
     * {@inheritdoc}
     */
    protected $_foreignKey = 'country_id';

    /**
     * {@inheritdoc}
     */
    protected $_defaultOptionLabel = 'Please select city';

    /**
     * {@inheritdoc}
     */
    protected $_defaultValue = 'VN';

    /**
     * {@inheritdoc}
     */
    protected $_sortable = true;

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(\Ticket\Directory\Model\City::class, \Ticket\Directory\Model\ResourceModel\City::class);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareOptionArray()
    {
        $options = parent::prepareOptionArray();

        /**
         * Move raised cities up top option
         */
        array_unshift($options, $options[22]); // Hải Phòng
        array_unshift($options, $options[14]); // Cần thơ
        array_unshift($options, $options[60]); // Đà Nẵng
        array_unshift($options, $options[21]); // Hà Nội
        array_unshift($options, $options[28]); // Hồ Chí Minh

        unset($options[18]);
        unset($options[23]);
        unset($options[27]);
        unset($options[29]);
        unset($options[63]);

        return $options;
    }
}
