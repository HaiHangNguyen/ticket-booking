/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/model/new-customer-address': {
                'Ticket_Directory/js/model/new-customer-address-mixin': true
            },
            'Magento_Checkout/js/model/cart/cache': {
                'Ticket_Directory/js/model/cart/cache-mixin': true
            },
            'Magento_Checkout/js/model/address-converter': {
                'Ticket_Directory/js/model/address-converter-mixin': true
            },
            'Magento_Checkout/js/checkout-data': {
                'Ticket_Directory/js/checkout-data-mixin': true
            }
        }
    },

    map: {
        '*': {
            'Magento_Customer/js/model/customer-addresses': 'Ticket_Directory/js/model/customer-addresses',
            'Magento_Checkout/js/view/shipping-address/address-renderer/default': 'Ticket_Directory/js/view/shipping-address/address-renderer/default',
            'Magento_Checkout/js/view/shipping-information/address-renderer/default': 'Ticket_Directory/js/view/shipping-information/address-renderer/default',
            'Magento_Checkout/js/view/billing-address': 'Ticket_Directory/js/view/billing-address'
        }
    }
};
