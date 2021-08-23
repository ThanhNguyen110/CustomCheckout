define([
    'ko',
    'uiComponent',
    'underscore',
    'Magento_Checkout/js/model/step-navigator',
    'jquery',
    "Magento_Checkout/js/model/quote",
    'mage/url',
    'mage/storage'
], function (ko, Component, _, stepNavigator, $, quote, urlBuilder, storage) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'AHT_CustomCheckout/delivery-step'
        },

        // add here your logic to display step,
        isVisible: ko.observable(true),
        stepCode : 'delivery_step',
        stepTitle: 'Delivery Step',

        /**
         * @returns {*}
         */
        initialize: function () {
            this._super();

            // register your step
            stepNavigator.registerStep(
                // step code will be used as step content id in the component template
                this.stepCode,
                // step alias
                null,
                // step title value
                this.stepTitle,
                // observable property with logic when display step or hide step
                this.isVisible,

                _.bind(this.navigate, this),

                /**
                 * sort order value
                 * 'sort order value' < 10     : step displays before shipping step;
                 * 10 < 'sort order value' < 20: step displays between shipping and payment step
                 * 'sort order value' > 20     : step displays after payment step
                 */
                15
            );

            return this;
        },

        onSubmit: function () {
            // trigger form validation
            this.source.set('params.invalid', false);
            this.source.trigger('customCheckoutForm.data.validate');

            // verify that form data is valid
            if (!this.source.get('params.invalid')) {
                // data is retrieved from data provider by value of the customScope property
                var formData = this.source.get('customCheckoutForm');
                // do something with form data
                console.dir(formData);
            }
        },

        /**
         * The navigate() method is responsible for navigation between checkout steps
         * during checkout. You can add custom logic, for example some conditions
         * for switching to your custom step
         * When the user navigates to the custom step via url anchor or back button we_must show step manually here
         */
        navigate: function () {
            this.isVisible(true);
        },

        /**
         * @returns void
         */
        navigateToNextStep: function () {
            var valueDate    = $("[name='delivery-date']").val();
            var valueComment = $("[name='delivery-comment']").val();
            var quoteId      = quote.getQuoteId();
            var url          = urlBuilder.build('custom/index/index');
            /* if (!valueDate) {
                return false;
            } */

            stepNavigator.next();

            return storage.post(
                url,
                JSON.stringify({'quoteId': quoteId, 'date': valueDate, 'comment': valueComment}),
                false
            ).done(function (response) {
                    console.log(response);
                }
            ).fail(function (response) {
                console.log("error");
                console.log(valueDate);
                console.log(valueComment);
            });
        }
    });
});