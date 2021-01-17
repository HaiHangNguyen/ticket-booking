<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Model\Plugin\Quote;

use Magento\Framework\Registry;

/**
 * Class Address
 * @package Ticket\Directory\Model\Plugin\Quote
 */
class Address
{
    /** @const */
    const CUSTOM_ATTRIBUTE_KEY = 'ticket_directory_quote_address_custom_attributes';
    const ESTIMATING_KEY = 'estimating_key';
    const REQUESTING_TOTAL_KEY = 'requesting_total_key';

    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * Constructor.
     *
     * @param Registry $registry
     */
    function __construct(
        Registry $registry
    )
    {
        $this->_registry = $registry;
    }

    /**
     * Before export customer address
     *
     * @param \Magento\Quote\Model\Quote\Address $subject
     * @return array
     */
    public function beforeExportCustomerAddress(\Magento\Quote\Model\Quote\Address $subject)
    {
        foreach ($subject->getCustomAttributes() as $customAttribute) {
            $subject->setData($customAttribute->getAttributeCode(), $customAttribute->getValue());
        }

        return [];
    }

    /**
     * Before add data
     *
     * @param \Magento\Quote\Model\Quote\Address $subject
     * @param array $arr
     * @return array
     */
    public function beforeAddData(\Magento\Quote\Model\Quote\Address $subject, array $arr)
    {
        if (
            'billing' == $subject->getAddressType()
            || (isset($arr['address_type']) && 'billing' == $arr['address_type'])
            || $this->_registry->registry(self::ESTIMATING_KEY)
            || $this->_registry->registry(self::REQUESTING_TOTAL_KEY)
        ) {
            return [$arr];
        }

        if (isset($arr['limit_carrier']) || isset($arr['address_id'])
        ) {
            //Todo save shipping address
            $this->_registry->unregister(self::CUSTOM_ATTRIBUTE_KEY);
            $this->_registry->register(self::CUSTOM_ATTRIBUTE_KEY, [
                ['attribute_code' => 'city_id', 'value' => $arr['city_id']],
                ['attribute_code' => 'district', 'value' => $arr['district']],
                ['attribute_code' => 'district_id', 'value' => $arr['district_id']],
                ['attribute_code' => 'ward', 'value' => $arr['ward']],
                ['attribute_code' => 'ward_id', 'value' => $arr['ward_id']],
            ]);

            return [$arr];
        }

        if (isset($arr['custom_attributes'])) {
            //Todo estimate methods
            $this->_registry->unregister(self::CUSTOM_ATTRIBUTE_KEY);
            $this->_registry->register(self::CUSTOM_ATTRIBUTE_KEY, $arr['custom_attributes']);
            $this->_registry->register(self::ESTIMATING_KEY, true);

            return [$arr];
        }

//        if (isset($arr['extension_attributes'])) {
//            //Todo request total
//            $this->_registry->unregister(self::CUSTOM_ATTRIBUTE_KEY);
//            $this->_registry->register(self::CUSTOM_ATTRIBUTE_KEY, $arr['extension_attributes']->getAdvancedConditions()->getCustomAttributes());
//            $this->_registry->register(self::REQUESTING_TOTAL_KEY, true);
//
//            return [$arr];
//        }

        return [$arr];
    }
}
