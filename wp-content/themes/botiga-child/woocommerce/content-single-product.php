<style>
    /* SNS 공유 */
    .sns-go ul {
        list-style-type: none;
        margin: 10px 0 0 0;
        padding: 0;
        overflow: hidden;
    }

    .sns-go li {
        float: left;
        padding-right: 5px;
    }

    .sns-go img {
        border-radius: 5px;
        width: 35px;
    }

    .single .entry-content {
        margin-top: 0.6em;
    }

</style>


<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

    <?php
    /**
     * Hook: woocommerce_before_single_product_summary.
     *
     * @hooked woocommerce_show_product_sale_flash - 10
     * @hooked woocommerce_show_product_images - 20
     */
    do_action( 'woocommerce_before_single_product_summary' );
    ?>

    <div class="summary entry-summary">
        <?php
        /**
         * Hook: woocommerce_single_product_summary.
         *
         * @hooked woocommerce_template_single_title - 5
         * @hooked woocommerce_template_single_rating - 10
         * @hooked woocommerce_template_single_price - 10
         * @hooked woocommerce_template_single_excerpt - 20
         * @hooked woocommerce_template_single_add_to_cart - 30
         * @hooked woocommerce_template_single_meta - 40
         * @hooked woocommerce_template_single_sharing - 50
         * @hooked WC_Structured_Data::generate_product_data() - 60
         */
        do_action( 'woocommerce_single_product_summary' );
        ?>

        <!-- SNS 공유 버튼 -->
        <div class="sns-go">
            <b>SNS로 공유하기</b>
            <ul>
                <li>
                    <a href="#" onclick="javascript:window.open('http://share.naver.com/web/shareView.nhn?url=' +encodeURIComponent(document.URL)+'&title='+encodeURIComponent(document.title), 'naversharedialog', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" alt="Share on Naver" rel="nofollow"><img src="https://ivenet02.cafe24.com/brandshop/naver_share_icon.png" width="35px" height="35px" alt="네이버 블로그 공유하기"></a>
                </li>
                <li>
                    <a href="#" onclick="javascript:window.open('http://band.us/plugin/share?body='+encodeURIComponent(document.title)+encodeURIComponent('\r\n')+encodeURIComponent(document.URL)+'&route='+encodeURIComponent(document.URL), 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" alt="네이버 밴드에 공유하기" rel="nofollow"><img src="https://ivenet02.cafe24.com/brandshop/band_share_icon.png" width="35px" height="35px" alt='네이버 밴드에 공유하기'></a>
                </li>
                <li>
                    <a href="#" onclick="javascript:window.open('https://www.facebook.com/sharer/sharer.php?u=' +encodeURIComponent(document.URL)+'&t='+encodeURIComponent(document.title), 'facebooksharedialog', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" alt="Share on Facebook" rel="nofollow"><img src="https://ivenet02.cafe24.com/brandshop/facebook_share_icon.png" width="35px" height="35px"  alt="페이스북 공유하기"></a>
                </li>
                <li>
                    <a href="#" onclick="javascript:window.open('https://twitter.com/intent/tweet?text=[%EA%B3%B5%EC%9C%A0]%20' +encodeURIComponent(document.URL)+'%20-%20'+encodeURIComponent(document.title), 'twittersharedialog', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" alt="Share on Twitter" rel="nofollow"><img src="https://ivenet02.cafe24.com/brandshop/twitter_share_icon.png" width="35px" height="35px"  alt="트위터 공유하기"></a>
                </li>
                <li>
                    <a href="#" onclick="javascript:window.open('https://story.kakao.com/s/share?url=' +encodeURIComponent(document.URL), 'kakaostorysharedialog', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes, height=400,width=600');return false;" target="_blank" alt="Share on kakaostory" rel="nofollow"><img src="https://ivenet02.cafe24.com/brandshop/kakao_share_icon.png" width="35px" height="35px" alt="카카오스토리 공유하기"></a>
                </li>
                <li>
                    <a href="#" onclick="shareKatalk();"><img src="https://ivenet02.cafe24.com/brandshop/talk_share_icon.png"></a>
                </li>
            </ul>
            <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
            <!-- 카카오톡 공유 JavaScript -->
            <script>
                // 사용할 앱의 JavaScript 키를 설정해 주세요.
                Kakao.init('c67fe9f893b1825d518ba612f35a64fc');
                function shareKatalk() {
                    <!-- 카카오 Link 공유 API 사용-->
                    Kakao.Link.sendScrap({
                        requestUrl: location.href
                    });
                };
            </script>
        </div>

    </div>

    <?php
    /**
     * Hook: woocommerce_after_single_product_summary.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action( 'woocommerce_after_single_product_summary' );
    ?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
