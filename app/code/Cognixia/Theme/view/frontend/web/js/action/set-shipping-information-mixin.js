 /*jshint browser:true jquery:true*/
 /*global alert*/
 define([
     'jquery',
     'mage/utils/wrapper',
     'Magento_Checkout/js/model/quote'
 ], function ($, wrapper, quote) {
     'use strict';

     return function (setShippingInformationAction) {

         return wrapper.wrap(setShippingInformationAction, function (originalAction) {
             var shippingAddress = quote.shippingAddress();

             if (shippingAddress['extension_attributes'] === undefined) {
                 shippingAddress['extension_attributes'] = {
                     'customvar': "value1"
                 };
             }
             // you can write here your code according to your requirement
             return originalAction(); // it is returning the flow to original action
         });
     };
 });
