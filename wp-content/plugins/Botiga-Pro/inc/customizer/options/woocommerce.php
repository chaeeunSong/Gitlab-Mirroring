<?php
/**
 * WooCommerce Customizer options
 *
 * @package Botiga_Pro
 */

function botiga_pro_woocommerce_options( $wp_customize ) {
    
    /**
     * Tabs Control
     */
    $controls_general     = json_decode( $wp_customize->get_control( 'botiga_product_catalog_tabs' )->controls_general );
    $new_controls_general = array( '#customize-control-shop_archive_pro_divider1','#customize-control-shop_archive_header_style','#customize-control-shop_archive_header_style_alignment','#customize-control-shop_archive_header_style_show_categories','#customize-control-shop_archive_header_style_show_sub_categories','#customize-control-shop_archive_pro_divider2','#customize-control-shop_archive_sidebar_open_button_text','#customize-control-shop_archive_sidebar_open_icon','#customize-control-shop_archive_sidebar_top_columns','#customize-control-shop_archive_columns_gap_desktop' );
    $wp_customize->get_control( 'botiga_product_catalog_tabs' )->controls_general = json_encode( array_merge( $controls_general, $new_controls_general ) );
    
    $controls_design     = json_decode( $wp_customize->get_control( 'botiga_product_catalog_tabs' )->controls_design );
    $new_controls_design = array( '#customize-control-shop_archive_header_title1','#customize-control-shop_archive_header_styling_layout','#customize-control-shop_archive_header_background_color','#customize-control-shop_archive_header_title_color','#customize-control-shop_archive_header_description_color','#customize-control-shop_archive_header_title2','#customize-control-shop_archive_header_button_color','#customize-control-shop_archive_header_button_color_hover','#customize-control-shop_archive_header_button_background_color','#customize-control-shop_archive_header_button_background_color_hover','#customize-control-shop_archive_header_button_border_color','#customize-control-shop_archive_header_button_border_color_hover','#customize-control-shop_archive_header_button_border_radius' );
    $wp_customize->get_control( 'botiga_product_catalog_tabs' )->controls_design = json_encode( array_merge( $controls_design, $new_controls_design ) );

    /**
     * General
     */
    // Shop header styles
    $wp_customize->add_setting( 'shop_archive_pro_divider1',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Botiga_Divider_Control( $wp_customize, 'shop_archive_pro_divider1',
            array(
                'section' 		  => 'woocommerce_product_catalog',
                'priority'        => 21
            )
        )
    );

    $wp_customize->add_setting(
        'shop_archive_header_style',
        array(
            'default'           => 'style1',
            'sanitize_callback' => 'sanitize_key',
        )
    );
    $wp_customize->add_control(
        new Botiga_Radio_Images(
            $wp_customize,
            'shop_archive_header_style',
            array(
                'label'    	=> esc_html__( 'Shop Header Style', 'botiga' ),
                'section'  	=> 'woocommerce_product_catalog',
                'cols'		=> 2,
                'choices'  => array(
                    'style1' => array(
                        'label' => esc_html__( 'Style 1', 'botiga' ),
                        'url'   => '%s/assets/img/shop-page-header-style-1.svg'
                    ),
                    'style2' => array(
                        'label' => esc_html__( 'Style 2', 'botiga' ),
                        'url'   => '%s/assets/img/shop-page-header-style-2.svg'
                    ),		
                ),
                'priority'	 => 21
            )
        )
    );

    $wp_customize->add_setting( 
        'shop_archive_header_style_alignment',
        array(
            'default' 			=> 'center',
            'sanitize_callback' => 'botiga_sanitize_text'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Radio_Buttons( 
            $wp_customize, 
            'shop_archive_header_style_alignment',
            array(
                'label' 	      => esc_html__( 'Alignment', 'botiga' ),
                'section' 	      => 'woocommerce_product_catalog',
                'active_callback' => 'botiga_callback_shop_archive_header_style_alignment',
                'choices'         => array(
                    'left'   => esc_html__( 'Left', 'botiga' ),
                    'center' => esc_html__( 'Center', 'botiga' ),
                    'right'  => esc_html__( 'Right', 'botiga' )
                ),
                'priority'        => 21
            )
        ) 
    );

    $wp_customize->add_setting(
        'shop_archive_header_style_show_categories',
        array(
            'default'           => 0,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'shop_archive_header_style_show_categories',
            array(
                'label'           => esc_html__( 'Show Categories in the Header', 'botiga' ),
                'description'     => esc_html__( 'Controls whether to show or not the products categories in the shop page header.', 'botiga' ),
                'section'         => 'woocommerce_product_catalog',
                'priority'	      => 21
            )
        )
    );

    $wp_customize->add_setting(
        'shop_archive_header_style_show_sub_categories',
        array(
            'default'           => 0,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'shop_archive_header_style_show_sub_categories',
            array(
                'label'           => esc_html__( 'Show Sub Categories in the Header', 'botiga' ),
                'description'     => esc_html__( 'Controls whether to show or not the products categories in the category/taxonomy page header.', 'botiga' ),
                'section'         => 'woocommerce_product_catalog',
                'priority'	      => 21
            )
        )
    );

    $wp_customize->add_setting( 'shop_archive_pro_divider2',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Botiga_Divider_Control( $wp_customize, 'shop_archive_pro_divider2',
            array(
                'section' 		  => 'woocommerce_product_catalog',
                'priority'        => 21
            )
        )
    );

    // Sidebar
    $wp_customize->get_control( 'shop_archive_sidebar' )->choices = array(
        'no-sidebar'   => array(
            'label' => esc_html__( 'No Sidebar', 'botiga' ),
            'url'   => '%s/assets/img/sidebar-disabled.svg'
        ),
        'sidebar-left' => array(
            'label' => esc_html__( 'Left', 'botiga' ),
            'url'   => '%s/assets/img/sidebar-left.svg'
        ),
        'sidebar-right' => array(
            'label' => esc_html__( 'Right', 'botiga' ),
            'url'   => '%s/assets/img/sidebar-right.svg'
        ),
        // Pro
        'sidebar-top' => array(
            'label' => esc_html__( 'Top', 'botiga' ),
            'url'   => '%s/assets/img/sidebar-top.svg'
        ),
        'sidebar-slide' => array(
            'label' => esc_html__( 'Slide-out', 'botiga' ),
            'url'   => '%s/assets/img/sidebar-slide.svg'
        )
    );
    $wp_customize->get_control( 'shop_archive_sidebar' )->description = esc_html__( 'If the shop widget area is empty, the default widget sidebar area will be shown (the same that is shown in blog pages)', 'botiga' );

    $wp_customize->add_setting(
        'shop_archive_sidebar_open_button_text',
        array(
            'sanitize_callback' => 'botiga_sanitize_text',
            'default'           => '',
        )       
    );
    $wp_customize->add_control( 
        'shop_archive_sidebar_open_button_text', 
        array(
            'label'           => esc_html__( 'Sidebar open button text', 'botiga' ),
            'type'            => 'text',
            'section'         => 'woocommerce_product_catalog',
            'active_callback' => 'botiga_callback_shop_archive_sidebar_slide',
            'priority'	      => 31
        ) 
    );

    $wp_customize->add_setting(
        'shop_archive_sidebar_open_icon',
        array(
            'default'           => 0,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'shop_archive_sidebar_open_icon',
            array(
                'label'           => esc_html__( 'Sidebar open icon', 'botiga' ),
                'section'         => 'woocommerce_product_catalog',
                'active_callback' => 'botiga_callback_shop_archive_sidebar_slide',
                'priority'	      => 31
            )
        )
    );

    $wp_customize->add_setting( 
        'shop_archive_sidebar_top_columns',
        array(
            'default' 			=> '4',
            'sanitize_callback' => 'botiga_sanitize_text'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Radio_Buttons( 
            $wp_customize, 
            'shop_archive_sidebar_top_columns',
            array(
                'label'           => esc_html__( 'Sidebar Top Columns', 'botiga' ),
                'section'         => 'woocommerce_product_catalog',
                'choices'         => array(
                    '1' => esc_html__( '1', 'botiga' ),
                    '2' => esc_html__( '2', 'botiga' ),
                    '3' => esc_html__( '3', 'botiga' ),
                    '4' => esc_html__( '4', 'botiga' ),
                ),
                'active_callback' => 'botiga_callback_shop_archive_sidebar_top',
                'priority'	      => 31
            )
        ) 
    );

    // Wishlist
    $wp_customize->add_section(
        'botiga_section_wishlist',
        array(
            'title'         => esc_html__( 'Wishlist', 'botiga'),
            'priority'      => 20,
            'panel'         => 'woocommerce',
        )
    );

    $wp_customize->add_setting(
        'shop_product_wishlist_tab',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Botiga_Tab_Control (
            $wp_customize,
            'shop_product_wishlist_tab',
            array(
                'label' 				=> '',
                'section'       		=> 'botiga_section_wishlist',
                'controls_general'		=> json_encode( array( '#customize-control-shop_product_wishlist_layout','#customize-control-shop_product_wishlist_info','#customize-control-shop_product_wishlist_tooltip','#customize-control-shop_product_wishlist_tooltip_text','#customize-control-shop_product_wishlist_show_on_hover','#customize-control-shop_archive_pro_divider3','#customize-control-shop_archive_wishlist_title1','#customize-control-shop_archive_wishlist_create_page','#customize-control-shop_archive_pro_divider4' ) ),
                'controls_design'		=> json_encode( array( '#customize-control-shop_product_wishlist_icon_active_color','#customize-control-shop_product_wishlist_icon_background_color' ) ),
                'priority'              => -1
            )
        )
    );

    $wp_customize->add_setting(
        'shop_product_wishlist_layout',
        array(
            'default'           => 'layout1',
            'sanitize_callback' => 'sanitize_key',
        )
    );
    $wp_customize->add_control(
        new Botiga_Radio_Images(
            $wp_customize,
            'shop_product_wishlist_layout',
            array(
                'label'    	  => esc_html__( 'Wishlist', 'botiga' ),
                'desc_below'  => true,
                'section'  	  => 'botiga_section_wishlist',
                'cols'		  => 3,
                'choices'  => array(
                    'layout1' => array(
                        'label' => esc_html__( 'Layout 1', 'botiga' ),
                        'url'   => '%s/assets/img/wl1.svg'
                    ),
                    'layout2' => array(
                        'label' => esc_html__( 'Layout 2', 'botiga' ),
                        'url'   => '%s/assets/img/wl2.svg'
                    ),	
                    'layout3' => array(
                        'label' => esc_html__( 'Layout 3', 'botiga' ),
                        'url'   => '%s/assets/img/wl3.svg'
                    ),										
                ),
                'priority'	   => 10
            )
        )
    );

    $wp_customize->add_setting(
        'shop_product_wishlist_info',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control(
        new Botiga_Text_Control(
            $wp_customize,
            'shop_product_wishlist_info',
            array(
                'description' => esc_html__( 'Learn more about this feature in our documentation by clicking in the below link.', 'botiga' ),
                'link_title'  => esc_html__( 'Learn more', 'botiga' ),
                'link'        => 'https://docs.athemes.com/article/389-pro-wishlist',
                'section'     => 'botiga_section_wishlist',
                'priority'    => 111
            )
        )
    );

    $wp_customize->add_setting(
        'shop_product_wishlist_tooltip',
        array(
            'default'           => 0,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'shop_product_wishlist_tooltip',
            array(
                'label'         	=> esc_html__( 'Wishlist Tooltip', 'botiga' ),
                'section'       	=> 'botiga_section_wishlist',
                'active_callback'   => 'botiga_callback_shop_product_wishlist_layout',
                'priority'	        => 11
            )
        )
    );

    $wp_customize->add_setting(
        'shop_product_wishlist_tooltip_text',
        array(
            'sanitize_callback' => 'botiga_sanitize_text',
            'default'           => '',
        )       
    );
    $wp_customize->add_control( 
        'shop_product_wishlist_tooltip_text', 
        array(
            'label'           => esc_html__( 'Tooltip Text', 'botiga' ),
            'type'            => 'text',
            'section'         => 'botiga_section_wishlist',
            'active_callback' => 'botiga_callback_shop_product_wishlist_tooltip',
            'priority'	      => 12
        ) 
    );

    $wp_customize->add_setting(
        'shop_product_wishlist_show_on_hover',
        array(
            'default'           => 0,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'shop_product_wishlist_show_on_hover',
            array(
                'label'         	=> esc_html__( 'Show On Hover', 'botiga' ),
                'section'       	=> 'botiga_section_wishlist',
                'active_callback'   => 'botiga_callback_shop_product_wishlist_layout',
                'priority'	        => 12
            )
        )
    );

    // Wishlist Page Settings
    $wp_customize->add_setting( 'shop_archive_pro_divider3',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Botiga_Divider_Control( $wp_customize, 'shop_archive_pro_divider3',
            array(
                'section' 		    => 'botiga_section_wishlist',
                'active_callback'   => 'botiga_callback_shop_product_wishlist_layout',
                'priority'          => 13
            )
        )
    );

    $wp_customize->add_setting( 
        'shop_archive_wishlist_title1',
        array(
            'default' 			=> '',
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Text_Control( 
            $wp_customize, 
            'shop_archive_wishlist_title1',
            array(
                'label'			=> esc_html__( 'Wishlist Page Settings', 'botiga' ),
                'section' 		=> 'botiga_section_wishlist',
                'active_callback'   => 'botiga_callback_shop_product_wishlist_layout',
                'priority'	 	=> 14
            )
        )
    );

    if( class_exists( 'Botiga_Create_Page_Control' ) ) {
        $wp_customize->add_setting( 
            'shop_archive_wishlist_create_page',
            array(
                'default' 			=> '',
                'sanitize_callback' => 'esc_attr'
            )
        );
        $wp_customize->add_control( 
            new Botiga_Create_Page_Control( 
                $wp_customize, 
                'shop_archive_wishlist_create_page',
                array(
                    'label'			  => esc_html__( 'Create Wishlist Page', 'botiga' ),
                    'page_title'      => esc_html__( 'My Wishlist', 'botiga' ),
                    'page_meta_key'   => '_wp_page_template',
                    'page_meta_value' => 'page-templates/template-wishlist.php',
                    'option_name'     => 'botiga_wishlist_page_id',
                    'section' 		  => 'botiga_section_wishlist',
                    'active_callback' => 'botiga_callback_shop_product_wishlist_layout',
                    'priority'	 	  => 15
                )
            )
        );
    }

    $wp_customize->add_setting( 'shop_archive_pro_divider4',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Botiga_Divider_Control( $wp_customize, 'shop_archive_pro_divider4',
            array(
                'section' 		    => 'botiga_section_wishlist',
                'active_callback'   => 'botiga_callback_shop_product_wishlist_layout',
                'priority'          => 16
            )
        )
    );

    $wp_customize->add_setting(
        'shop_product_wishlist_icon_active_color',
        array(
            'default'           => '#fda5a5',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'shop_product_wishlist_icon_active_color',
            array(
                'label'         	=> esc_html__( 'Active Icon Color', 'botiga' ),
                'section'       	=> 'botiga_section_wishlist',
                'priority'	 		=> 17
            )
        )
    );

    $wp_customize->add_setting(
        'shop_product_wishlist_icon_background_color',
        array(
            'default'           => 'rgba(255,255,255,0)',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'shop_product_wishlist_icon_background_color',
            array(
                'label'         	=> esc_html__( 'Icon Background Color', 'botiga' ),
                'section'       	=> 'botiga_section_wishlist',
                'priority'	 		=> 17
            )
        )
    );

    // Cart
    $wp_customize->add_setting(
        'shop_cart_sticky_totals_box',
        array(
            'default'           => 0,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'shop_cart_sticky_totals_box',
            array(
                'label'         	=> esc_html__( 'Sticky cart totals box', 'botiga' ),
                'section'       	=> 'botiga_section_shop_cart',
                'active_callback'   => 'botiga_callback_shop_cart_layout',
                'priority'	        => 51
            )
        )
    );

    // Checkout
    $free_layouts = $wp_customize->get_control( 'shop_checkout_layout' )->choices;
    $wp_customize->get_control( 'shop_checkout_layout' )->cols = 3;
    $wp_customize->get_control( 'shop_checkout_layout' )->choices = array_merge(
        $free_layouts,
        array(
            'layout3' => array(
                'label' => esc_html__( 'Layout 3', 'botiga' ),
                'url'   => '%s/assets/img/checkout3.svg'
            )		
        )
    );
    $wp_customize->get_control( 'shop_checkout_layout' )->priority = 1;
    $wp_customize->get_control( 'shop_checkout_show_coupon_form' )->priority = 1;
    
    $wp_customize->add_setting(
        'checkout_sticky_totals_box',
        array(
            'default'           => 0,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'checkout_sticky_totals_box',
            array(
                'label'         	=> esc_html__( 'Sticky Checkout Totals Box', 'botiga' ),
                'section'       	=> 'woocommerce_checkout',
                'active_callback'   => 'botiga_callback_shop_checkout_layout',
                'priority'	        => 1
            )
        )
    );

    $wp_customize->add_setting(
        'checkout_distraction_free',
        array(
            'default'           => 0,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'checkout_distraction_free',
            array(
                'label'         	=> esc_html__( 'Distraction Free Checkout', 'botiga' ),
                'section'       	=> 'woocommerce_checkout',
                'priority'	        => 1
            )
        )
    );

    /**
     * Styling
     */
    // Shop Header Styles
    $wp_customize->add_setting( 
        'shop_archive_header_styling_layout', 
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Botiga_Accordion_Control(
            $wp_customize,
            'shop_archive_header_styling_layout',
            array(
                'label'         => esc_html__( 'Layout', 'botiga' ),
                'section'       => 'woocommerce_product_catalog',
                'until'         => 'shop_archive_header_button_border_radius',
                'priority'      => 271
            )
        )
    );

    $wp_customize->add_setting( 
        'shop_archive_header_title1',
        array(
            'default' 			=> '',
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Text_Control( 
            $wp_customize, 
            'shop_archive_header_title1',
            array(
                'label'			=> esc_html__( 'Header Style', 'botiga' ),
                'section' 		=> 'woocommerce_product_catalog',
                'priority'	 	=> 271
            )
        )
    );

    $wp_customize->add_setting(
        'shop_archive_header_background_color',
        array(
            'default'           => '#FFF',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'shop_archive_header_background_color',
            array(
                'label'         	=> esc_html__( 'Background Color', 'botiga' ),
                'section'       	=> 'woocommerce_product_catalog',
                'priority'	 		=> 271
            )
        )
    );

    $wp_customize->add_setting(
        'shop_archive_header_title_color',
        array(
            'default'           => '#212121',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'shop_archive_header_title_color',
            array(
                'label'         	=> esc_html__( 'Title Color', 'botiga' ),
                'section'       	=> 'woocommerce_product_catalog',
                'priority'	 		=> 271
            )
        )
    );

    $wp_customize->add_setting(
        'shop_archive_header_description_color',
        array(
            'default'           => '#212121',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'shop_archive_header_description_color',
            array(
                'label'         	=> esc_html__( 'Description Color', 'botiga' ),
                'section'       	=> 'woocommerce_product_catalog',
                'priority'	 		=> 271
            )
        )
    );

    $wp_customize->add_setting( 
        'shop_archive_header_title2',
        array(
            'default' 			=> '',
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Text_Control( 
            $wp_customize, 
            'shop_archive_header_title2',
            array(
                'label'			=> esc_html__( 'Header Style - Category Buttons', 'botiga' ),
                'section' 		=> 'woocommerce_product_catalog',
                'priority'	 	=> 271
            )
        )
    );

    $wp_customize->add_setting(
        'shop_archive_header_button_color',
        array(
            'default'           => '#212121',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'shop_archive_header_button_color',
            array(
                'label'         	=> esc_html__( 'Text Color', 'botiga' ),
                'section'       	=> 'woocommerce_product_catalog',
                'priority'	 		=> 271
            )
        )
    );

    $wp_customize->add_setting(
        'shop_archive_header_button_color_hover',
        array(
            'default'           => '#FFF',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'shop_archive_header_button_color_hover',
            array(
                'label'         	=> esc_html__( 'Text Color Hover', 'botiga' ),
                'section'       	=> 'woocommerce_product_catalog',
                'priority'	 		=> 271
            )
        )
    );

    $wp_customize->add_setting(
        'shop_archive_header_button_background_color',
        array(
            'default'           => '#FFF',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'shop_archive_header_button_background_color',
            array(
                'label'         	=> esc_html__( 'Background Color', 'botiga' ),
                'section'       	=> 'woocommerce_product_catalog',
                'priority'	 		=> 271
            )
        )
    );

    $wp_customize->add_setting(
        'shop_archive_header_button_background_color_hover',
        array(
            'default'           => '#212121',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'shop_archive_header_button_background_color_hover',
            array(
                'label'         	=> esc_html__( 'Background Color Hover', 'botiga' ),
                'section'       	=> 'woocommerce_product_catalog',
                'priority'	 		=> 271
            )
        )
    );

    $wp_customize->add_setting(
        'shop_archive_header_button_border_color',
        array(
            'default'           => '#212121',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'shop_archive_header_button_border_color',
            array(
                'label'         	=> esc_html__( 'Border Color', 'botiga' ),
                'section'       	=> 'woocommerce_product_catalog',
                'priority'	 		=> 271
            )
        )
    );

    $wp_customize->add_setting(
        'shop_archive_header_button_border_color_hover',
        array(
            'default'           => '#212121',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'shop_archive_header_button_border_color_hover',
            array(
                'label'         	=> esc_html__( 'Border Color Hover', 'botiga' ),
                'section'       	=> 'woocommerce_product_catalog',
                'priority'	 		=> 271
            )
        )
    );

    $wp_customize->add_setting( 
        'shop_archive_header_button_border_radius', 
        array(
            'default'   		=> 35,
            'transport'			=> 'postMessage',
            'sanitize_callback' => 'absint',
        ) 
    );			
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'shop_archive_header_button_border_radius',
            array(
                'label' 		=> esc_html__( 'Border Radius', 'botiga' ),
                'section' 		=> 'woocommerce_product_catalog',
                'is_responsive'	=> 0,
                'settings' 		=> array (
                    'size_desktop' 		=> 'shop_archive_header_button_border_radius',
                ),
                'input_attrs' => array (
                    'min'	=> 0,
                    'max'	=> 35,
                    'step'  => 1
                ),
                'priority'      => 271
            )
        ) 
    );

    // Columns gap
    $wp_customize->add_setting( 
        'shop_archive_columns_gap_title3',
        array(
            'default' 			=> '',
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Text_Control( 
            $wp_customize, 
            'shop_archive_columns_gap_title3',
            array(
                'label'			=> esc_html__( 'Columns', 'botiga' ),
                'section' 		=> 'woocommerce_product_catalog',
                'priority'	 	=> 1
            )
        )
    );

    $wp_customize->add_setting( 
        'shop_archive_columns_gap_desktop', 
        array(
            'default'   		=> 30,
            'transport'			=> 'postMessage',
            'sanitize_callback' => 'absint'
        ) 
    );
    $wp_customize->add_setting( 
        'shop_archive_columns_gap_tablet', 
        array(
            'default'   		=> 30,
            'transport'			=> 'postMessage',
            'sanitize_callback' => 'absint'
        ) 
    );
    $wp_customize->add_setting( 
        'shop_archive_columns_gap_mobile', 
        array(
            'default'   		=> 20,
            'transport'			=> 'postMessage',
            'sanitize_callback' => 'absint'
        ) 
    );			
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'shop_archive_columns_gap_desktop',
            array(
                'label' 		=> esc_html__( 'Products Gap', 'botiga' ),
                'section' 		=> 'woocommerce_product_catalog',
                'is_responsive'	=> 1,
                'settings' 		=> array (
                    'size_desktop' 		=> 'shop_archive_columns_gap_desktop',
                    'size_tablet' 		=> 'shop_archive_columns_gap_tablet',
                    'size_mobile' 		=> 'shop_archive_columns_gap_mobile'
                ),
                'input_attrs' => array (
                    'min'	=> 0,
                    'max'	=> 200,
                    'step'  => 1
                ),
                'priority'      => 1
            )
        ) 
    );

}
add_action( 'customize_register', 'botiga_pro_woocommerce_options', 999 );