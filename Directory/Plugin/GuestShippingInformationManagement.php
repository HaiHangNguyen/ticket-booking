<?php
/**
 * Copyright © 2020 Ticket. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Ticket_Directory extension
 * NOTICE OF LICENSE
 *
 * @category Ticket
 * @package Ticket_Directory
 */

namespace Ticket\Directory\Plugin;


use Magento\Checkout\Api\Data\ShippingInformationInterface;

class GuestShippingInformationManagement
{
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Api\GuestShippingInformationManagementInterface $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    ) {
        $customAttr = ['city_id', 'district', 'district_id', 'ward', 'ward_id'];
        $addressShipping = $addressInformation->getShippingAddress();
        foreach ($customAttr as $attr) {
            if(isset($addressShipping->getCustomAttribute($attr)->getValue()['value'])) {
                $addressShipping->setCustomAttribute($attr, $addressShipping->getCustomAttribute($attr)->getValue()['value']);
            }
        }

        return [$cartId, $addressInformation];
    }
}
