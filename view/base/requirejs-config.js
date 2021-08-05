var config = {
    'config': {
        'mixins': {
            'Magento_Checkout/js/view/shipping': {
                'AHT_CustomCheckout/js/view/shipping-payment-mixin': true
            },
            'Magento_Checkout/js/view/payment': {
                'AHT_CustomCheckout/js/view/shipping-payment-mixin': true
            },
            'AHT_CustomCheckout/js/view/my-step-view': {
                'AHT_CustomCheckout/js/view/shipping-payment-mixin': true
            }
        }
    }
}