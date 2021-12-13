<?php
/**
 * Multi Step Checkout
 * 
 * @package Botiga_Pro
 */

function botiga_mstepc_enqueue_scripts() {
    $shop_checkout_layout = get_theme_mod( 'shop_checkout_layout', 'layout1' );

    if( 'layout3' !== $shop_checkout_layout ) {
        return;
    }

    if( is_checkout() && ! is_wc_endpoint_url( 'order-received' ) ) {
        wp_enqueue_script( 'jquery-validate', BOTIGA_PRO_URI . '/assets/vendor/jquery-validate/jquery.validate.min.js', array( 'jquery' ), BOTIGA_VERSION, true );

        wp_enqueue_style( 'botiga-multi-step-checkout', BOTIGA_PRO_URI . '/assets/css/botiga-multi-step-checkout.min.css', array(), BOTIGA_VERSION );
        wp_enqueue_script( 'botiga-multi-step-checkout', BOTIGA_PRO_URI . '/assets/js/botiga-multi-step-checkout.min.js', array( 'jquery' ), BOTIGA_VERSION, true );
        wp_localize_script( 'botiga-multi-step-checkout', 'botiga_mstepc', array(
            'i18n' => array(
                'customer_details_phone'     => esc_html__( 'Phone', 'botiga' ),
                'customer_details_email'     => esc_html__( 'Email', 'botiga' ),
                
                'billing_details_name'       => esc_html__( 'Name', 'botiga' ),
                'billing_details_last_name'  => esc_html__( 'Last Name', 'botiga' ),
                'billing_details_company'    => esc_html__( 'Company', 'botiga' ),
                'billing_details_address_1'  => esc_html__( 'Address 1', 'botiga' ),
                'billing_details_address_2'  => esc_html__( 'Address 2', 'botiga' ),
                'billing_details_city'       => esc_html__( 'City', 'botiga' ),
                'billing_details_state'      => esc_html__( 'State', 'botiga' ),
                'billing_details_postcode'   => esc_html__( 'Post Code', 'botiga' ),
                'billing_details_country'    => esc_html__( 'Country', 'botiga' ),

                'shipping_details_name'      => esc_html__( 'Name', 'botiga' ),
                'shipping_details_last_name' => esc_html__( 'Last Name', 'botiga' ),
                'shipping_details_company'   => esc_html__( 'Company', 'botiga' ),
                'shipping_details_address_1' => esc_html__( 'Address 1', 'botiga' ),
                'shipping_details_address_2' => esc_html__( 'Address 2', 'botiga' ),
                'shipping_details_city'      => esc_html__( 'City', 'botiga' ),
                'shipping_details_state'     => esc_html__( 'State', 'botiga' ),
                'shipping_details_postcode'  => esc_html__( 'Post Code', 'botiga' ),
                'shipping_details_country'   => esc_html__( 'Country', 'botiga' ),
            )
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'botiga_mstepc_enqueue_scripts', 10 );

function botiga_mstepc_body_class( $classes ) {
	$classes[] = 'botiga-multistep-checkout';

	return $classes;
}
add_filter( 'body_class', 'botiga_mstepc_body_class' );

function botiga_mstepc_wc_hooks() {
    $shop_checkout_layout = get_theme_mod( 'shop_checkout_layout', 'layout1' );

    if( 'layout3' !== $shop_checkout_layout ) {
        return;
    }

    if( ! is_checkout() || is_wc_endpoint_url( 'order-received' ) ) {
        return;
    }

    add_action( 'botiga_before_page_entry_content', 'botiga_mstepc_before_page_entry_content' );
    add_action( 'botiga_after_page_entry_content', 'botiga_mstepc_after_page_entry_content' );

    add_action( 'botiga_before_page_the_content', function(){ echo '<a href="'. esc_url( wc_get_cart_url() ) .'" class="botiga-mstepc-back-to-cart"><span>&#8592;</span>'. esc_html__( 'Back to Cart', 'botiga' ) .'</a>'; } );

    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
    add_action( 'woocommerce_before_checkout_form', 'botiga_woocommerce_login_form', 10 );

    add_action( 'woocommerce_after_checkout_form', 'botiga_mstepc_after_checkout_form' );
}
add_action( 'wp', 'botiga_mstepc_wc_hooks' );

function botiga_mstepc_before_page_entry_content() { 
    $steps = array(
        'login' => array(
            'label'            => __( 'Login', 'botiga' ),
            'content-selector' => '.woocommerce-form-login',
            'validate-selector' => '.woocommerce-form-login',
        ),
        'billing-shipping' => array(
            'label'            => __( 'Billing & Shipping', 'botiga' ),
            'content-selector' => 'form.woocommerce-checkout #customer_details',
            'validate-selector' => '.woocommerce-form-login'
        ),
        'order-payment' => array(
            'label'            => __( 'Order & Payment', 'botiga' ),
            'content-selector' => '.checkout-wrapper:not(.botiga-mstep-order-review),.woocommerce-form-coupon-toggle,.woocommerce-form-coupon',
            'validate-selector' => 'form.woocommerce-checkout'
        ),
        'order-review' => array(
            'label'            => __( 'Order Review', 'botiga' ),
            'content-selector' => '.botiga-mstep-order-review',
            'validate-selector' => 'form.woocommerce-checkout'
        )
    );

    if( is_user_logged_in() || get_option( 'woocommerce_enable_checkout_login_reminder' ) === 'no' ) {
        unset( $steps['login'] );
    }
    
    ?>
    <!-- Multi Step Checkout Wrapper -->
    <div class="botiga-mstepc-wrapper">

        <!-- Multi Step Checkout Nav -->
        <div class="botiga-mstepc-tabs-nav">

            <?php 
            $step_number = 1;
            foreach( $steps as $step_slug => $step ) : ?>

                <div class="botiga-mstepc-tabs-nav-item<?php echo ( $step_slug === 'login' || $step_number === 1 ? ' active' : '' ); ?><?php echo ( $step_slug === 'login' ? ' no-validation' : '' ); ?>">
                    <a href="#" role="button" class="botiga-mstepc-tabs-nav-item-link" data-step="<?php echo esc_attr( $step_slug ); ?>" data-content-selector="<?php echo esc_attr( $step['content-selector'] ); ?>" data-validate-selector="<?php echo esc_attr( $step['validate-selector'] ); ?>">
                        <span class="step">
                            <span class="step-number"><?php echo absint( $step_number ); ?></span>
                            <span class="step-completed"><i class="ws-svg-icon"><?php botiga_get_svg_icon( 'icon-check', true ); ?></i></span>
                        </span>
                        <span class="label"><?php echo esc_html( $step['label'] ); ?></span>
                    </a>
                </div>

            <?php 
            $step_number++;
            endforeach; ?>

        </div>
        <!-- Multi Step Checkout Tabs Content -->
        <div class="botiga-mstepc-tabs-content">
    <?php
}

function botiga_mstepc_after_page_entry_content() { 
    $next_step     = 'billing-shipping';
    $no_login_step = is_user_logged_in() || get_option( 'woocommerce_enable_checkout_login_reminder' ) === 'no';

    if( $no_login_step ) {
        $next_step = 'order-payment';
    } ?>
        </div>
        <!-- Multi Step Checkout Footer -->
        <div class="botiga-mstepc-footer<?php echo ( $no_login_step ? ' no-login-step' : '' ); ?>">
            <a href="#" role="button" class="botiga-mstepc-skip-login"><?php echo esc_html__( 'Skip Login', 'botiga' ); ?></a>
            <a href="#" role="button" class="botiga-mstepc-prev"><span>&#8592;</span><?php echo esc_html__( 'Previous Step', 'botiga' ); ?></a> 
            <a href="#" role="button" class="botiga-mstepc-next" data-to="<?php echo esc_attr( $next_step ) ?>"><?php echo esc_html__( 'Next Step', 'botiga' ); ?><span>&#8594;</span></a>
            <a href="#" role="button" class="botiga-mstepc-place-order button">
                <span class="text">
                    <?php echo esc_html__( 'Place Order', 'botiga' ); ?>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512" aria-hidden="true" focusable="false">
                    <path fill="#FFF" d="M288 39.056v16.659c0 10.804 7.281 20.159 17.686 23.066C383.204 100.434 440 171.518 440 256c0 101.689-82.295 184-184 184-101.689 0-184-82.295-184-184 0-84.47 56.786-155.564 134.312-177.219C216.719 75.874 224 66.517 224 55.712V39.064c0-15.709-14.834-27.153-30.046-23.234C86.603 43.482 7.394 141.206 8.003 257.332c.72 137.052 111.477 246.956 248.531 246.667C393.255 503.711 504 392.788 504 256c0-115.633-79.14-212.779-186.211-240.236C302.678 11.889 288 23.456 288 39.056z" />
                </svg>
            </a>
        </div>
    </div>
    <!-- /Multi Step Checkout Wrapper -->
    <?php
}

function botiga_mstepc_after_checkout_form() { ?>

    <div class="botiga-mstep-order-review checkout-wrapper">
        <div class="botiga-mstep-order-review__table"></div>
        <h6 class="botiga-mstep-order-review__customer-details-title"><?php echo esc_html__( 'Customer Details', 'botiga' ); ?></h6>
        <div class="botiga-mstep-order-review__customer-details"></div>
        <hr class="divider">
        <div class="botiga-mstep-order-review__address">
            <div>
                <h6 class="botiga-mstep-order-review__address-billing-title"><?php echo esc_html__( 'Billing Details', 'botiga' ); ?></h6>
                <div class="botiga-mstep-order-review__address-billing"></div>
            </div>
            <div>
                <h6 class="botiga-mstep-order-review__address-shipping-title"><?php echo esc_html__( 'Shipping Details', 'botiga' ); ?></h6>
                <div class="botiga-mstep-order-review__address-shipping"></div>
            </div>
        </div>
    </div> 

<?php
}