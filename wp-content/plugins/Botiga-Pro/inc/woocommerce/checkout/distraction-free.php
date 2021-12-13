<?php
/**
 * Distraction free checkout
 * 
 * @package Botiga_Pro
 */

function botiga_distraction_free_checkout( $custom ) {
    $df_checkout          = get_theme_mod( 'checkout_distraction_free', 0 );
    $shop_checkout_layout = get_theme_mod( 'shop_checkout_layout', 'layout1' );

    if ( !is_checkout() || !$df_checkout || isset( $_GET['order-received'] ) ) {
        return $custom;
    }

    $css = '.woocommerce-checkout .site-header.sticky-header { position: relative !important; top: 0 !important; } .woocommerce-checkout .site-header div[class*="col-"] { position: static; } .woocommerce-checkout .site-header .site-branding { position: absolute; left: 50%; top: 70px; -webkit-transform: translate3d(-50%, 0, 0); transform: translate3d(-50%, 0, 0);  } .woocommerce-checkout .entry-header { margin-top: 30px; } .woocommerce-checkout .main-navigation, .woocommerce-checkout .top-bar, .woocommerce-checkout .header-item, .woocommerce-checkout .header-image, .woocommerce-checkout .footer-widgets, .woocommerce-checkout .site-footer .social-profile { display: none; } .woocommerce-checkout .site-info { border-top: none; } .woocommerce-checkout .site-info .menu, .woocommerce-checkout .site-info .botiga-html, .woocommerce-checkout .site-info .botiga-shortcode { display: none; }';

    if( 'layout3' === $shop_checkout_layout ) {
        $css .= '.woocommerce-checkout .entry-header { display: none; }';
    }

    wp_add_inline_style( 'botiga-style-min', $css );
}
add_filter( 'wp_enqueue_scripts', 'botiga_distraction_free_checkout', 11 );