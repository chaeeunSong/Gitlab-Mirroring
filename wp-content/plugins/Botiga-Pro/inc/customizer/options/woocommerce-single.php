<?php
/**
 * WooCommerce Single Customizer options
 *
 * @package Botiga_Pro
 */

function botiga_pro_woocommerce_single( $wp_customize ) {

    /**
     * Tabs control
     */
    $controls_general     = json_decode( $wp_customize->get_control( 'botiga_single_product_tabs' )->controls_general );
    $new_controls_general = array( '#customize-control-shop_single_related_products_slider','#customize-control-shop_single_related_products_slider_nav','#customize-control-shop_single_related_products_number','#customize-control-shop_single_related_products_columns_number','#customize-control-single_sticky_add_to_cart','#customize-control-accordion_single_product_layout','#customize-control-accordion_single_product_swatch','#customize-control-product_swatch','#customize-control-product_swatch_info','#customize-control-accordion_single_product_sticky_add_to_cart','#customize-control-single_sticky_add_to_cart_position','#customize-control-single_sticky_add_to_cart_elements','#customize-control-single_sticky_add_to_cart_elements_spacing','#customize-control-single_sticky_add_to_cart_scroll_hide','#customize-control-single_sticky_add_to_cart_device_visibility','#customize-control-accordion_single_product_tabs','#customize-control-single_product_tabs_layout','#customize-control-single_product_tabs_alignment' );
    $wp_customize->get_control( 'botiga_single_product_tabs' )->controls_general = json_encode( array_merge( $controls_general, $new_controls_general ) );

    $controls_design     = json_decode( $wp_customize->get_control( 'botiga_single_product_tabs' )->controls_design );
    $new_controls_design = array( '#customize-control-accordion_single_product_styling_layout','#customize-control-accordion_single_product_styling_sticky_add_to_cart','#customize-control-single_sticky_add_to_cart_style_color_border','#customize-control-single_sticky_add_to_cart_style_color_background','#customize-control-single_sticky_add_to_cart_style_color_content','#customize-control-accordion_single_product_styling_tabs','#customize-control-single_product_tabs_state_title','#customize-control-single_product_tabs_border_color','#customize-control-single_product_tabs_background_color','#customize-control-single_product_tabs_text_color','#customize-control-single_product_tabs_divider_1','#customize-control-single_product_tabs_state_title2','#customize-control-single_product_tabs_border_color_active','#customize-control-single_product_tabs_background_color_active','#customize-control-single_product_tabs_text_color_active','#customize-control-single_product_tabs_divider_2','#customize-control-single_product_tabs_remaining_borders','#customize-control-single_product_gallery_styles_divider1','#customize-control-single_product_gallery_styles_title1','#customize-control-single_product_gallery_styles_background_color','#customize-control-single_product_gallery_styles_padding_top_bottom' );
    $wp_customize->get_control( 'botiga_single_product_tabs' )->controls_design = json_encode( array_merge( $controls_design, $new_controls_design ) );

    /**
     * General
     */
    $wp_customize->add_setting( 'accordion_single_product_layout', 
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Botiga_Accordion_Control(
            $wp_customize,
            'accordion_single_product_layout',
            array(
                'label'         => esc_html__( 'Layout', 'botiga' ),
                'section'       => 'botiga_section_single_product',
                'until'         => 'shop_single_related_products_columns_number',
                'priority'      => 11
            )
        )
    );

    //Gallery Styles
    $wp_customize->get_control( 'single_product_gallery' )->choices = array(
        'gallery-default' => array(
            'label' => esc_html__( 'Layout 1', 'botiga' ),
            'url'   => '%s/assets/img/sg1.svg'
        ),
        'gallery-single' => array(
            'label' => esc_html__( 'Layout 2', 'botiga' ),
            'url'   => '%s/assets/img/sg2.svg'
        ),	
        'gallery-vertical' => array(
            'label' => esc_html__( 'Layout 3', 'botiga' ),
            'url'   => '%s/assets/img/sg3.svg'
        ),
        'gallery-grid' => array(
            'label' => esc_html__( 'Layout 4', 'botiga' ),
            'url'   => '%s/assets/img/sg4.svg'
        ),
        'gallery-scrolling' => array(
            'label' => esc_html__( 'Layout 5', 'botiga' ),
            'url'   => '%s/assets/img/sg5.svg'
        ),
        'gallery-showcase' => array(
            'label' => esc_html__( 'Layout 6', 'botiga' ),
            'url'   => '%s/assets/img/sg6.svg'
        ),
        'gallery-full-width' => array(
            'label' => esc_html__( 'Layout 7', 'botiga' ),
            'url'   => '%s/assets/img/sg7.svg'
        ),
    );

    $wp_customize->get_control( 'single_gallery_slider' )->active_callback = 'botiga_callback_single_product_gallery_layout';
    $wp_customize->get_control( 'single_zoom_effects' )->active_callback = 'botiga_callback_single_product_gallery_layout';
    
    // Related Producs as Slider
    $wp_customize->add_setting(
        'shop_single_related_products_slider',
        array(
            'default'           => 0,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'shop_single_related_products_slider',
            array(
                'label'         	=> esc_html__( 'Related products slider', 'botiga' ),
                'section'       	=> 'botiga_section_single_product',
                'active_callback'   => 'botiga_callback_shop_single_show_related_products',
                'priority' 			=> 111
            )
        )
    );

    // Related products slider nav
    $wp_customize->add_setting( 
        'shop_single_related_products_slider_nav',
        array(
            'default' 			=> 'always-show',
            'sanitize_callback' => 'botiga_sanitize_text'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Radio_Buttons( 
            $wp_customize, 
            'shop_single_related_products_slider_nav',
            array(
                'label' 	      => esc_html__( 'Related products slider navigation', 'botiga' ),
                'section' 	      => 'botiga_section_single_product',
                'active_callback' => 'botiga_callback_shop_single_related_products_slider_navigation',
                'choices'         => array(
                    'always-show' => esc_html__( 'Always show', 'botiga' ),
                    'hover-show'  => esc_html__( 'Show on hover', 'botiga' ),
                ),
                'priority' 		  => 111
            )
        ) 
    );

    // Related products number
    $wp_customize->add_setting( 
        'shop_single_related_products_number', 
        array(
            'default'   		=> 3,
            'sanitize_callback' => 'absint',
        ) 
    );			
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'shop_single_related_products_number',
            array(
                'label' 		=> esc_html__( 'Number of products', 'botiga' ),
                'section' 		=> 'botiga_section_single_product',
                'active_callback'   => 'botiga_callback_shop_single_show_related_products',
                'is_responsive'	=> 0,
                'settings' 		=> array (
                    'size_desktop' 		=> 'shop_single_related_products_number',
                ),
                'input_attrs' => array (
                    'min'	=> 1,
                    'max'	=> 25,
                    'step'  => 1
                ),
                'priority'      => 111
            )
        )
    );

    // Related products columns number
    $wp_customize->add_setting( 
        'shop_single_related_products_columns_number', 
        array(
            'default'   		=> 3,
            'sanitize_callback' => 'absint',
        ) 
    );			
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'shop_single_related_products_columns_number',
            array(
                'label' 		=> esc_html__( 'Number of columns', 'botiga' ),
                'section' 		=> 'botiga_section_single_product',
                'active_callback'   => 'botiga_callback_shop_single_show_related_products',
                'is_responsive'	=> 0,
                'settings' 		=> array (
                    'size_desktop' 		=> 'shop_single_related_products_columns_number',
                ),
                'input_attrs' => array (
                    'min'	=> 1,
                    'max'	=> 6,
                    'step'  => 1
                ),
                'priority' 		=> 111
            )
        )
    );

    // Sticky Add to Cart
    $wp_customize->add_setting( 'accordion_single_product_sticky_add_to_cart', 
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Botiga_Accordion_Control(
            $wp_customize,
            'accordion_single_product_sticky_add_to_cart',
            array(
                'label'         => esc_html__( 'Sticky Add to Cart', 'botiga' ),
                'section'       => 'botiga_section_single_product',
                'until'         => 'single_sticky_add_to_cart_device_visibility',
                'priority'      => 111
            )
        )
    );

    $wp_customize->add_setting(
        'single_sticky_add_to_cart',
        array(
            'default'           => 0,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'single_sticky_add_to_cart',
            array(
                'label'         	=> esc_html__( 'Enable', 'botiga' ),
                'section'       	=> 'botiga_section_single_product',
                'priority'          => 111
            )
        )
    );

    $wp_customize->add_setting( 
        'single_sticky_add_to_cart_position',
        array(
            'default' 			=> 'bottom',
            'sanitize_callback' => 'botiga_sanitize_text'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Radio_Buttons( 
            $wp_customize, 
            'single_sticky_add_to_cart_position',
            array(
                'label' 	      => esc_html__( 'Position', 'botiga' ),
                'section' 	      => 'botiga_section_single_product',
                'active_callback' => 'botiga_callback_single_sticky_add_to_cart',
                'choices'         => array(
                    'top' => esc_html__( 'Top', 'botiga' ),
                    'bottom'  => esc_html__( 'Bottom', 'botiga' ),
                ),
                'priority'        => 111
            )
        ) 
    );

    $wp_customize->add_setting( 
        'single_sticky_add_to_cart_elements', 
        array(
            'default'  			=> array( 
                'botiga_sticky_add_to_cart_product_image', 
                'botiga_sticky_add_to_cart_product_title', 
                'botiga_single_product_price', 
                'botiga_sticky_add_to_cart_product_addtocart'
            ),
            'sanitize_callback'	=> 'botiga_sanitize_single_add_to_cart_elements'
        ) 
    );
    $wp_customize->add_control( 
        new \Kirki\Control\Sortable( 
            $wp_customize, 
            'single_sticky_add_to_cart_elements', 
            array(
                'label'   => esc_html__( 'Elements', 'botiga' ),
                'section' => 'botiga_section_single_product',
                'active_callback' => 'botiga_callback_single_sticky_add_to_cart',
                'choices' => array(
                    'botiga_sticky_add_to_cart_product_image'       => esc_html__( 'Product Image', 'botiga' ),
                    'botiga_sticky_add_to_cart_product_title' 		=> esc_html__( 'Product Title', 'botiga' ),
                    'botiga_single_product_price'	                => esc_html__( 'Product Price', 'botiga' ),
                    'botiga_sticky_add_to_cart_product_addtocart'   => esc_html__( 'Add to Cart', 'botiga' )
                ),
                'priority' => 111
            ) 
        ) 
    );

    $wp_customize->add_setting( 
        'single_sticky_add_to_cart_elements_spacing', 
        array(
            'default'   		=> 35,
            'transport'			=> 'postMessage',
            'sanitize_callback' => 'botiga_sanitize_text',
        ) 
    );			
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'single_sticky_add_to_cart_elements_spacing',
            array(
                'label' 		=> esc_html__( 'Elements Spacing', 'botiga' ),
                'section' 		=> 'botiga_section_single_product',
                'active_callback' => 'botiga_callback_single_sticky_add_to_cart',
                'is_responsive'	=> 0,
                'settings' 		=> array (
                    'size_desktop' 		=> 'single_sticky_add_to_cart_elements_spacing',
                ),
                'input_attrs' => array (
                    'min'	=> 0,
                    'max'	=> 80,
                    'step'  => 1
                ),
                'priority'      => 111
            )
        ) 
    );

    $wp_customize->add_setting(
        'single_sticky_add_to_cart_scroll_hide',
        array(
            'default'           => 0,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'single_sticky_add_to_cart_scroll_hide',
            array(
                'label'         	=> esc_html__( 'Hide When Scroll to Top', 'botiga' ),
                'section'       	=> 'botiga_section_single_product',
                'active_callback'   => 'botiga_callback_single_sticky_add_to_cart',
                'priority'          => 111
            )
        )
    );

    $wp_customize->add_setting( 
        'single_sticky_add_to_cart_device_visibility', 
        array(
            'sanitize_callback' => 'botiga_sanitize_select',
            'default' 			=> 'desktop-only',
        ) 
    );
    $wp_customize->add_control( 
        'single_sticky_add_to_cart_device_visibility', 
        array(
            'type' 		=> 'select',
            'section' 	=> 'botiga_section_single_product',
            'active_callback' => 'botiga_callback_single_sticky_add_to_cart',
            'label' 	=> esc_html__( 'Visibility', 'botiga' ),
            'choices'   => array(
                'all' 			=> esc_html__( 'Show on all devices', 'botiga' ),
                'desktop-only' 	=> esc_html__( 'Desktop only', 'botiga' ),
                'mobile-only' 	=> esc_html__( 'Mobile/tablet only', 'botiga' ),
            ),
            'priority'  => 111
        ) 
    );

    //Tabs
    $wp_customize->add_setting( 'accordion_single_product_tabs', 
        array(
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control(
        new Botiga_Accordion_Control(
            $wp_customize,
            'accordion_single_product_tabs',
            array(
                'label'         => esc_html__( 'Tabs', 'botiga' ),
                'section'       => 'botiga_section_single_product',
                'until'         => 'single_product_tabs_alignment',
                'priority'      => 112
            )
        )
    );

    $wp_customize->add_setting( 
        'single_product_tabs_layout', 
        array(
            'sanitize_callback' => 'botiga_sanitize_select',
            'default' 			=> 'style1',
            'transport'         => 'postMessage'
        ) 
    );
    $wp_customize->add_control( 
        'single_product_tabs_layout', 
        array(
            'type' 		=> 'select',
            'section' 	=> 'botiga_section_single_product',
            'label' 	=> esc_html__( 'Layout Style', 'botiga' ),
            'choices'   => array(
                'style1' 	=> esc_html__( 'Style 1', 'botiga' ),
                'style2' 	=> esc_html__( 'Style 2', 'botiga' ),
                'style3' 	=> esc_html__( 'Style 3', 'botiga' ),
                'style4' 	=> esc_html__( 'Style 4', 'botiga' ),
                'style5' 	=> esc_html__( 'Style 5', 'botiga' ),
            ),
            'priority'  => 112
        ) 
    );

    $wp_customize->add_setting( 
        'single_product_tabs_alignment',
        array(
            'default' 			=> 'left',
            'sanitize_callback' => 'botiga_sanitize_text',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Radio_Buttons( 
            $wp_customize, 
            'single_product_tabs_alignment',
            array(
                'label' 	      => esc_html__( 'Alignment', 'botiga' ),
                'section' 	      => 'botiga_section_single_product',
                'choices'         => array(
                    'left'   => esc_html__( 'Left', 'botiga' ),
                    'center' => esc_html__( 'Center', 'botiga' ),
                    'right'  => esc_html__( 'Right', 'botiga' )
                ),
                'priority'        => 112
            )
        ) 
    );

    /**
     * Styling
     */
    $wp_customize->add_setting( 'accordion_single_product_styling_layout', 
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Botiga_Accordion_Control(
            $wp_customize,
            'accordion_single_product_styling_layout',
            array(
                'label'         => esc_html__( 'Layout', 'botiga' ),
                'section'       => 'botiga_section_single_product',
                'until'         => 'single_product_gallery_styles_padding_top_bottom',
                'priority'      => 112
            )
        )
    );

    // Gallery Styles
    $wp_customize->add_setting( 
        'single_product_gallery_styles_divider1',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Divider_Control( 
            $wp_customize, 
            'single_product_gallery_styles_divider1',
            array(
                'section' 		  => 'botiga_section_single_product',
                'active_callback' => 'botiga_callback_single_product_gallery_image_layout',
                'priority'	 	  => 151
            )
        )
    );

    $wp_customize->add_setting( 
        'single_product_gallery_styles_title1',
        array(
            'default' 			=> '',
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Text_Control( 
            $wp_customize, 
            'single_product_gallery_styles_title1',
            array(
                'label'			  => esc_html__( 'Product Image', 'botiga' ),
                'section' 		  => 'botiga_section_single_product',
                'active_callback' => 'botiga_callback_single_product_gallery_image_layout',
                'priority'	 	  => 151
            )
        )
    );

    $wp_customize->add_setting(
        'single_product_gallery_styles_background_color',
        array(
            'default'           => '#f5f5f5',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'single_product_gallery_styles_background_color',
            array(
                'label'         	=> esc_html__( 'Background Color', 'botiga' ),
                'section'       	=> 'botiga_section_single_product',
                'active_callback'   => 'botiga_callback_single_product_gallery_image_layout',
                'priority'          => 151
            )
        )
    );

    $wp_customize->add_setting( 
        'single_product_gallery_styles_padding_top_bottom', 
        array(
            'default'   		=> 80,
            'transport'			=> 'postMessage',
            'sanitize_callback' => 'botiga_sanitize_text',
        ) 
    );			
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'single_product_gallery_styles_padding_top_bottom',
            array(
                'label' 		  => esc_html__( 'Spacing Top/Bottom', 'botiga' ),
                'section' 		  => 'botiga_section_single_product',
                'active_callback' => 'botiga_callback_single_product_gallery_image_layout',
                'is_responsive'   => 0,
                'settings' 		  => array (
                    'size_desktop' 		=> 'single_product_gallery_styles_padding_top_bottom',
                ),
                'input_attrs'     => array (
                    'min'	=> 0,
                    'max'	=> 80,
                    'step'  => 1
                ),
                'priority'        => 151
            )
        ) 
    );

    // Sticky Add To Cart
    $wp_customize->add_setting( 'accordion_single_product_styling_sticky_add_to_cart', 
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Botiga_Accordion_Control(
            $wp_customize,
            'accordion_single_product_styling_sticky_add_to_cart',
            array(
                'label'         => esc_html__( 'Sitcky Add To Cart', 'botiga' ),
                'section'       => 'botiga_section_single_product',
                'until'         => 'single_sticky_add_to_cart_style_color_content',
                'priority'      => 151
            )
        )
    );

    $wp_customize->add_setting(
        'single_sticky_add_to_cart_style_color_border',
        array(
            'default'           => '#e2e2e2',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'single_sticky_add_to_cart_style_color_border',
            array(
                'label'         	=> esc_html__( 'Border color', 'botiga' ),
                'section'       	=> 'botiga_section_single_product',
                'priority'          => 151
            )
        )
    );

    $wp_customize->add_setting(
        'single_sticky_add_to_cart_style_color_background',
        array(
            'default'           => '#FFF',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'single_sticky_add_to_cart_style_color_background',
            array(
                'label'         	=> esc_html__( 'Background color', 'botiga' ),
                'section'       	=> 'botiga_section_single_product',
                'priority'          => 151
            )
        )
    );

    $wp_customize->add_setting(
        'single_sticky_add_to_cart_style_color_content',
        array(
            'default'           => '#212121',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'single_sticky_add_to_cart_style_color_content',
            array(
                'label'         	=> esc_html__( 'Content color', 'botiga' ),
                'section'       	=> 'botiga_section_single_product',
                'priority'          => 151
            )
        )
    );

    // Tabs
    $wp_customize->add_setting( 'accordion_single_product_styling_tabs', 
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Botiga_Accordion_Control(
            $wp_customize,
            'accordion_single_product_styling_tabs',
            array(
                'label'         => esc_html__( 'Tabs', 'botiga' ),
                'section'       => 'botiga_section_single_product',
                'until'         => 'single_product_tabs_remaining_borders',
                'priority'      => 151
            )
        )
    );

    $wp_customize->add_setting( 
        'single_product_tabs_state_title',
        array(
            'default' 			=> '',
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Text_Control( 
            $wp_customize, 
            'single_product_tabs_state_title',
            array(
                'label'			=> esc_html__( 'Default State', 'botiga' ),
                'section' 		=> 'botiga_section_single_product',
                'priority'	 	=> 151
            )
        )
    );

    $wp_customize->add_setting(
        'single_product_tabs_background_color',
        array(
            'default'           => '#f5f5f5',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'single_product_tabs_background_color',
            array(
                'label'         	=> esc_html__( 'Background Color', 'botiga' ),
                'section'       	=> 'botiga_section_single_product',
                'active_callback'   => 'botiga_callback_single_tabs_background_color',
                'priority'	 		=> 151
            )
        )
    );

    $wp_customize->add_setting(
        'single_product_tabs_text_color',
        array(
            'default'           => '#212121',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'single_product_tabs_text_color',
            array(
                'label'         	=> esc_html__( 'Text Color', 'botiga' ),
                'section'       	=> 'botiga_section_single_product',
                'priority'	 		=> 151
            )
        )
    );

    $wp_customize->add_setting( 
        'single_product_tabs_divider_1',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Divider_Control( 
            $wp_customize, 
            'single_product_tabs_divider_1',
            array(
                'section' 		=> 'botiga_section_single_product',
                'priority'	 	=> 151
            )
        )
    );

    $wp_customize->add_setting( 
        'single_product_tabs_state_title2',
        array(
            'default' 			=> '',
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Text_Control( 
            $wp_customize, 
            'single_product_tabs_state_title2',
            array(
                'label'			=> esc_html__( 'Active State', 'botiga' ),
                'section' 		=> 'botiga_section_single_product',
                'priority'	 	=> 151
            )
        )
    );

    $wp_customize->add_setting(
        'single_product_tabs_border_color_active',
        array(
            'default'           => '#212121',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'single_product_tabs_border_color_active',
            array(
                'label'         	=> esc_html__( 'Border Color', 'botiga' ),
                'section'       	=> 'botiga_section_single_product',
                'active_callback'   => 'botiga_callback_single_tabs_border_color_active',
                'priority'	 		=> 151
            )
        )
    );

    $wp_customize->add_setting(
        'single_product_tabs_background_color_active',
        array(
            'default'           => '#f5f5f5',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'single_product_tabs_background_color_active',
            array(
                'label'         	=> esc_html__( 'Background Color', 'botiga' ),
                'section'       	=> 'botiga_section_single_product',
                'active_callback'   => 'botiga_callback_single_tabs_background_color',
                'priority'	 		=> 151
            )
        )
    );

    $wp_customize->add_setting(
        'single_product_tabs_text_color_active',
        array(
            'default'           => '#212121',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'single_product_tabs_text_color_active',
            array(
                'label'         	=> esc_html__( 'Text Color', 'botiga' ),
                'section'       	=> 'botiga_section_single_product',
                'priority'	 		=> 151
            )
        )
    );

    $wp_customize->add_setting( 
        'single_product_tabs_divider_2',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Divider_Control( 
            $wp_customize, 
            'single_product_tabs_divider_2',
            array(
                'section' 		=> 'botiga_section_single_product',
                'priority'	 	=> 151
            )
        )
    );

    $wp_customize->add_setting(
        'single_product_tabs_remaining_borders',
        array(
            'default'           => '#212121',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'single_product_tabs_remaining_borders',
            array(
                'label'         	=> esc_html__( 'Remaining Borders Color', 'botiga' ),
                'description'       => esc_html__( 'Also controls the horizontal line color in some layouts', 'botiga' ),
                'section'       	=> 'botiga_section_single_product',
                'priority'	 		=> 151
            )
        )
    );

    // Product Swatch
    $wp_customize->add_setting( 
        'accordion_single_product_swatch', 
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control(
        new Botiga_Accordion_Control(
            $wp_customize,
            'accordion_single_product_swatch',
            array(
                'label'         => esc_html__( 'Product Swatch', 'botiga' ),
                'section'       => 'botiga_section_single_product',
                'until'         => 'product_swatch_info',
                'priority'      => 111
            )
        )
    );

    $wp_customize->add_setting(
        'product_swatch',
        array(
            'default'           => 1,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'product_swatch',
            array(
                'label'           => esc_html__( 'Enable', 'botiga' ),
                'section'         => 'botiga_section_single_product',
                'priority'	      => 111
            )
        )
    );

    $wp_customize->add_setting(
        'product_swatch_info',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_attr',
        )
    );
    $wp_customize->add_control(
        new Botiga_Text_Control(
            $wp_customize,
            'product_swatch_info',
            array(
                'label'       => '',
                'description' => esc_html__( 'This option require save and reload/refresh the page to see it working in the customizer preview. Make sure you are previewing a single variable product page with respective attributes/variations defined. Click in the below link to learn more about how to use this feature.', 'botiga' ),
                'link_title'  => esc_html__( 'Learn more', 'botiga' ),
                'link'        => 'https://docs.athemes.com/article/388-pro-product-swatch',
                'section'     => 'botiga_section_single_product',
                'priority'    => 111
            )
        )
    );

}
add_action( 'customize_register', 'botiga_pro_woocommerce_single', 999 );