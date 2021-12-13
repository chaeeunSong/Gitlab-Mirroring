<?php
/**
 * Botiga Pro Theme Customizer
 *
 * @package Botiga_Pro
 */

// Header
require_once( BOTIGA_PRO_DIR . 'inc/customizer/options/header.php' );

// Blog single
require_once( BOTIGA_PRO_DIR . 'inc/customizer/options/blog-single.php' );

// WooCommerce
if( class_exists( 'Woocommerce' ) ) {
    require_once( BOTIGA_PRO_DIR . 'inc/customizer/options/woocommerce.php' );
    require_once( BOTIGA_PRO_DIR . 'inc/customizer/options/woocommerce-single.php' );
}

// Footer
require_once( BOTIGA_PRO_DIR . 'inc/customizer/options/footer.php' );