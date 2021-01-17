<?php


namespace Ticket\Directory\Plugin;


use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Checkout\Api\ShippingInformationManagementInterface;

class ShippingInformationManagement
{

    /**
     * @param ShippingInformationManagementInterface $subject
     * @param $cartId
     * @param ShippingInformationInterface $addressInformation
     * @return array
     */
    public function beforeSaveAddressInformation(
        ShippingInformationManagementInterface $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    ) {
        $return = [$cartId, $addressInformation];
        $customAttr = ['city_id', 'district', 'district_id', 'ward', 'ward_id'];
        $addressShipping = $addressInformation->getShippingAddress();

        foreach ($customAttr as $attr) {
            if(isset($addressShipping->getCustomAttribute($attr)->getValue()['value'])){
                $addressShipping->setCustomAttribute($attr, $addressShipping->getCustomAttribute($attr)->getValue()['value']);
            }
        }

        return $return;
    }
}
