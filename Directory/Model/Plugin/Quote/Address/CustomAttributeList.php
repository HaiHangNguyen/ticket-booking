<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Model\Plugin\Quote\Address;

/**
 * Class CustomAttributeList
 * @package Ticket\Directory\Model\Plugin\Quote\Address
 */
class CustomAttributeList
{
    /**
     * After get attributes
     *
     * @param \Magento\Quote\Model\Quote\Address\CustomAttributeList $subject
     * @param $result
     * @return array
     */
    public function afterGetAttributes(\Magento\Quote\Model\Quote\Address\CustomAttributeList $subject, $result)
    {
        return array_merge($result, [
            'city_id' => true,
            'district' => true,
            'district_id' => true,
            'ward' => true,
            'ward_id' => true,
        ]);
    }
}
