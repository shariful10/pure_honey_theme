
// Temporary inline CSS to forcefully fix mobile checkout layout (bypasses any CSS caching)
add_action('wp_head', function() {
    echo '<style>
    /* Remove horizontal scroll on mobile */
    html, body {
        overflow-x: hidden !important;
        width: 100% !important;
        max-width: 100vw !important;
    }

    /* Decrease margin top of checkout page */
    .ph-woo-content {
        padding-top: 10px !important;
    }

    @media (max-width: 960px) {
        /* Force checkout layout to stack properly */
        .ph-checkout-layout {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            max-width: 100vw !important;
            overflow-x: hidden !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .ph-checkout-left, .ph-checkout-right {
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Force inputs to be 100% width and stack */
        .woocommerce .ph-checkout-section .form-row,
        .woocommerce-checkout .ph-checkout-section .form-row,
        .woocommerce-page .ph-checkout-section .form-row,
        .woocommerce-checkout .woocommerce form .form-row {
            width: 100% !important;
            max-width: 100% !important;
            float: none !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            display: block !important;
        }

        .ph-fields-grid {
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        body.woocommerce-checkout .ph-container,
        body.woocommerce-cart .ph-container {
            padding-left: 15px !important;
            padding-right: 15px !important;
            width: 100% !important;
            max-width: 100vw !important;
        }
    }
    </style>';
});
