/**
 * ajaxCompare
 *
 * @copyright Copyright © Boolfly. All rights reserved.
 * @author    info@boolfly.com
 * @project   Ajax Compare
 */
define([
    'jquery',
    'underscore',
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function ($, _, Component, customerData) {
    'use strict';

    return Component.extend({
        productIds: [],

        /** @inheritDoc */
        initialize: function () {
            this._super();
            this.initCompareProduct();
        },

        /**
         * Init Compare Product
         *
         * @inheritDoc
         */
        initCompareProduct: function () {
            this.compareProducts = customerData.get('compare-products');
            this.compareProducts.subscribe(function (value) {
                this.productIds(_.pluck(value.items, 'id'))
            }, this);
            this.observe('productIds', []);
            this.productIds(_.pluck(this.compareProducts().items, 'id'));
        },

        /** @inheritDoc */
        beforeSendAjaxEvent: function (ajaxCompare, event) {
            $(event.currentTarget).addClass('loading');
        },

        /** @inheritDoc */
        completeAjaxEvent: function (ajaxCompare, event) {
            $(event.currentTarget).removeClass('loading');
        },

        /**
         * Check product added
         *
         * @inheritDoc
         */
        added: function (element) {
            return this.productIds.indexOf($(element).data('product-id').toString()) > -1;
        }
    });
});