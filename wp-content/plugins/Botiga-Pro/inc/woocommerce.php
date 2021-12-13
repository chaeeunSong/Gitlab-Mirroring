<?php
/**
 * Additional woocommerce functions
 * The functions here are loaded only when the WooCommerce plugin is active
 *
 * @package Botiga_Pro
 */

/**
 * Distraction free checkout
 */
require 'woocommerce/checkout/distraction-free.php';

/**
 * Multi Step Checkout
 */
require 'woocommerce/checkout/multi-step-checkout.php';

/**
 * Misc
 */
function botiga_woocommerce_login_form() {
    woocommerce_login_form(
        array(
            'message'  => esc_html__( 'If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing section.', 'woocommerce' ),
            'redirect' => wc_get_checkout_url(),
            'hidden'   => true,
        )
    );
}