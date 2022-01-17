<?php
/**
 * Botiga child functions
 *
 */


/**
 * Enqueues the parent stylesheet. Do not remove this function.
 *
 */
add_action( 'wp_enqueue_scripts', 'botiga_child_enqueue' );
function botiga_child_enqueue() {
    
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

/* ADD YOUR CUSTOM FUNCTIONS BELOW */


/* 우커머스에서 원화 기호의 위치와 표시 변경하기 (예 : 1,000원) */
add_filter('woocommerce_currency_symbol', 'change_won_currency_symbol', 10, 2);

function change_won_currency_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
        case 'KRW': $currency_symbol = '원'; break;
    }
    return $currency_symbol; }

