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


// Change My Account Menu

function my_account_menu_order() {
    $menuOrder = array(
        'dashboard' => __( 'Dashboard', 'woocommerce' ),
        'orders' => __( '내주문', 'woocommerce' ),
        //'downloads' => __( 'Download', 'woocommerce' ),
        'edit-address' => __( 'Addresses', 'woocommerce' ),
        'edit-account' => __( '계정 정보', 'woocommerce' ),
        'customer-logout' => __( 'Logout', 'woocommerce' ),

    );
    return $menuOrder;
}
add_filter ( 'woocommerce_account_menu_items', 'my_account_menu_order' );


// SNS Share

function crunchify_social_sharing_buttons($content) {
    global $post;
    if(is_singular() || is_home()){

        // Get current page URL
        $crunchifyURL = urlencode(get_permalink());

        // Get current page title
        $crunchifyTitle = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
        // $crunchifyTitle = str_replace( ' ', '%20', get_the_title());

        $currentnavertitle = encodeURIComponent(get_the_title());   // 네이버 블로그 공유하기 추가

        // Get Post Thumbnail for pinterest
        $crunchifyThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

        // Construct sharing URL without using any script
        $twitterURL = 'https://twitter.com/intent/tweet?text='.$crunchifyTitle.'&amp;url='.$crunchifyURL.'&amp;via=Crunchify';
        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$crunchifyURL;
        $googleURL = 'https://plus.google.com/share?url='.$crunchifyURL;
        $bufferURL = 'https://bufferapp.com/add?url='.$crunchifyURL.'&amp;text='.$crunchifyTitle;
        $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$crunchifyURL.'&amp;title='.$crunchifyTitle;
        $naverURL = 'http://blog.naver.com/openapi/share?url='.$crunchifyURL.'&amp;title='.$currentnavertitle;   // 네이버 블로그 추가

        // Based on popular demand added Pinterest too
        $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$crunchifyURL.'&amp;media='.$crunchifyThumbnail[0].'&amp;description='.$crunchifyTitle;

        // Add sharing button at the end of page/page content
        $content .= '<!-- Implement your own superfast social sharing buttons without any JavaScript loading. No plugin required. Detailed steps here: https://crunchify.com/?p=7526 -->';
        $content .= '<div class="crunchify-social">';
        $content .= '<h5>SNS로 공유하기</h5> <a class="crunchify-link crunchify-twitter" href="'. $twitterURL .'" target="_blank">Twitter</a>';
        $content .= '<a class="crunchify-link crunchify-facebook" href="'.$facebookURL.'" target="_blank">Facebook</a>';
        $content .= '<a class="crunchify-link crunchify-googleplus" href="'.$googleURL.'" target="_blank">Google+</a>';
        $content .= '<a class="crunchify-link crunchify-naverblog" href="'.$naverURL.'" target="_blank">네이버블로그</a>';
        //$content .= '<a class="crunchify-link crunchify-buffer" href="'.$bufferURL.'" target="_blank">Buffer</a>';
        //$content .= '<a class="crunchify-link crunchify-linkedin" href="'.$linkedInURL.'" target="_blank">LinkedIn</a>';
        //$content .= '<a class="crunchify-link crunchify-pinterest" href="'.$pinterestURL.'" data-pin-custom="true" target="_blank">Pin It</a>';
        $content .= '</div>';

        return $content;
    }else{
        // if not a post/page then don't include sharing button
        return $content;
    }
};
add_filter( 'the_content', 'crunchify_social_sharing_buttons');

// 네이버 블로그 공유하기 추가
function encodeURIComponent($str) {
    $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
    return strtr(rawurlencode($str), $revert);
}
// Reference: stackoverflow