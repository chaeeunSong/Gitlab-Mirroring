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


// 상품 상세페이지에 표시되는 장바구니 버튼 텍스트 편집
add_filter('woocommerce_product_single_add_to_cart_text', 'my_woocommerce_product_single_add_to_cart_text_20210504');

function my_woocommerce_product_single_add_to_cart_text_20210504(){
    return '장바구니 추가';
}
// 아카이브(목록)에 표시되는 장바구니 버튼 텍스트 편집
add_filter('woocommerce_product_add_to_cart_text', 'my_woocommerce_product_add_to_cart_text_20210504');

function my_woocommerce_product_add_to_cart_text_20210504(){
    return '장바구니 추가';
}