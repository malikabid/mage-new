/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * @api
 */
define([
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/url-builder',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/place-order',
    'mage/translate'
], function (quote, urlBuilder, customer, placeOrderService, $t) {
    'use strict';

    return function (paymentData, messageContainer) {
        var serviceUrl, payload;

        payload = {
            cartId: quote.getQuoteId(),
            billingAddress: quote.billingAddress(),
            paymentMethod: paymentData
        };

        if (customer.isLoggedIn()) {
            serviceUrl = urlBuilder.createUrl('/carts/mine/payment-information', {});
        } else {
            serviceUrl = urlBuilder.createUrl('/guest-carts/:quoteId/payment-information', {
                quoteId: quote.getQuoteId()
            });
            payload.email = quote.guestEmail;
        }

        console.log(quote.totals()['grand_total']);

        if (!customer.isLoggedIn() && parseFloat(quote.totals()['grand_total']) < 150) {
            var error = {
                message: $t('Grand total is less than 150.')
            };
            messageContainer.addErrorMessage(error);
            return;
        }

        return placeOrderService(serviceUrl, payload, messageContainer);
    };
});
