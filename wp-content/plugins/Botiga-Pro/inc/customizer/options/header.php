<?php
/**
 * Header Customizer options
 *
 * @package Botiga_Pro
 */

function botiga_pro_header_options( $wp_customize ) {
    
    // Tabs control
    $controls_general     = json_decode( $wp_customize->get_control( 'botiga_main_header_tabs' )->controls_general );
    $new_controls_general = array( '#customize-control-main_header_vertical_alignment_l6','#customize-control-main_header_content_alignment_l6','#customize-control-main_header_areas_spacing_l6','#customize-control-main_header_elements_spacing_l6','#customize-control-header_components_l7left','#customize-control-header_components_l7right','#customize-control-header_divider_8','#customize-control-main_header_desktop_offcanvas','#customize-control-header_components_desktop_offcanvas','#customize-control-header_components_desktop_offcanvas_elements_spacing','#customize-control-desktop_offcanvas_vertical_align','#customize-control-desktop_offcanvas_link_align','#customize-control-desktop_offcanvas_menu_link_separator','#customize-control-desktop_offcanvas_menu_link_spacing','#customize-control-desktop_offcanvas_content_areas_spacing','#customize-control-enable_header_wishlist_icon','#customize-control-header_divider_9','#customize-control-cart_icon' );
    $wp_customize->get_control( 'botiga_main_header_tabs' )->controls_general = json_encode( array_merge( $controls_general, $new_controls_general ) );
    
    $controls_design     = json_decode( $wp_customize->get_control( 'botiga_main_header_tabs' )->controls_design );
    $new_controls_design = array( '#customize-control-main_header_divider_8','#customize-control-desktop_offcanvas_menu_title_1','#customize-control-desktop_offcanvas_menu_text_color','#customize-control-desktop_offcanvas_menu_background_color','#customize-control-desktop_offcanvas_link_separator_color','#customize-control-desktop_offcanvas_padding' );
    $wp_customize->get_control( 'botiga_main_header_tabs' )->controls_design = json_encode( array_merge( $controls_design, $new_controls_design ) );

    // Main Header
    $wp_customize->get_control( 'header_layout_desktop' )->choices = array(
        'header_layout_1' => array(
			'label' => esc_html__( 'Layout 1', 'botiga' ),
			'url'   => '%s/assets/img/hl1.svg'
		),
		'header_layout_2' => array(
			'label' => esc_html__( 'Layout 2', 'botiga' ),
			'url'   => '%s/assets/img/hl2.svg'
		),		
		'header_layout_3' => array(
			'label' => esc_html__( 'Layout 3', 'botiga' ),
			'url'   => '%s/assets/img/hl3.svg'
		),				
		'header_layout_4' => array(
			'label' => esc_html__( 'Layout 4', 'botiga' ),
			'url'   => '%s/assets/img/hl4.svg'
		),
		'header_layout_5' => array(
			'label' => esc_html__( 'Layout 5', 'botiga' ),
			'url'   => '%s/assets/img/hl5.svg'
		),
        // Pro headers below
		'header_layout_6' => array(
			'label' => esc_html__( 'Layout 6', 'botiga' ),
			'url'   => '%s/assets/img/hl6.svg'
		),
		'header_layout_7' => array(
			'label' => esc_html__( 'Layout 7', 'botiga' ),
			'url'   => '%s/assets/img/hl7.svg'
		),
		'header_layout_8' => array(
			'label' => esc_html__( 'Layout 8', 'botiga' ),
			'url'   => '%s/assets/img/hl8.svg'
		)
    );

    // Header layout 6
    $wp_customize->add_setting( 
        'main_header_vertical_alignment_l6',
        array(
            'default' 			=> 'top',
            'sanitize_callback' => 'botiga_sanitize_text'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Radio_Buttons( 
            $wp_customize, 
            'main_header_vertical_alignment_l6',
            array(
                'label' 		=> esc_html__( 'Vertical Alignment', 'botiga' ),
                'section' => 'botiga_section_main_header',
                'choices' => array(
                    'top' 		=> esc_html__( 'Top', 'botiga' ),
                    'center' 	=> esc_html__( 'Center', 'botiga' ),
                    'bottom' 	=> esc_html__( 'Bottom', 'botiga' ),
                ),
                'active_callback' => 'botiga_callback_header_layout_is_6',
                'priority'		  => 41
            )
        ) 
    );

    $wp_customize->add_setting( 
        'main_header_content_alignment_l6',
        array(
            'default' 			=> 'left',
            'sanitize_callback' => 'botiga_sanitize_text'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Radio_Buttons( 
            $wp_customize, 
            'main_header_content_alignment_l6',
            array(
                'label' 		=> esc_html__( 'Content Alignment', 'botiga' ),
                'section' => 'botiga_section_main_header',
                'choices' => array(
                    'left' 		=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h10v1H0zM0 4h16v1H0zM0 8h10v1H0zM0 12h16v1H0z"/></svg>',
                    'center' 	=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 0h10v1H3zM0 4h16v1H0zM3 8h10v1H3zM0 12h16v1H0z"/></svg>',
                    'right' 	=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 0h10v1H6zM0 4h16v1H0zM6 8h10v1H6zM0 12h16v1H0z"/></svg>',
                ),
                'active_callback' => 'botiga_callback_header_layout_is_6',
                'priority'		  => 41
            )
        ) 
    );

    $wp_customize->add_setting( 
        'main_header_areas_spacing_l6', 
        array(
            'default'   		=> 15,
            'transport'			=> 'postMessage',
            'sanitize_callback' => 'absint',
        ) 
    );			
    
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'main_header_areas_spacing_l6',
            array(
                'label' 		=> esc_html__( 'Content Areas Spacing', 'botiga' ),
                'description'   => esc_html__( 'The spacing between logo, menu and elements.', 'botiga' ),
                'section' 		=> 'botiga_section_main_header',
                'active_callback' => 'botiga_callback_header_layout_is_6',
                'is_responsive'	=> 0,
                'settings' 		=> array (
                    'size_desktop' 		=> 'main_header_areas_spacing_l6',
                ),
                'input_attrs' => array (
                    'min'	=> 0,
                    'max'	=> 100
                ),
                'priority' => 41
            )
        ) 
    );

    $wp_customize->add_setting( 
        'main_header_elements_spacing_l6', 
        array(
            'default'   		=> 15,
            'transport'			=> 'postMessage',
            'sanitize_callback' => 'absint',
        ) 
    );			
    
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'main_header_elements_spacing_l6',
            array(
                'label' 		=> esc_html__( 'Elements Spacing', 'botiga' ),
                'section' 		=> 'botiga_section_main_header',
                'active_callback' => 'botiga_callback_header_layout_is_6',
                'is_responsive'	=> 0,
                'settings' 		=> array (
                    'size_desktop' 		=> 'main_header_elements_spacing_l6',
                ),
                'input_attrs' => array (
                    'min'	=> 0,
                    'max'	=> 100
                ),
                'priority' => 111
            )
        ) 
    );

    // Header layout 7
    $wp_customize->add_setting( 
        'header_components_l7left', 
        array(
            'default'  			=> array( 'contact_info' ),
            'sanitize_callback'	=> 'botiga_sanitize_header_components_layout_7_8'
        ) 
    );
    
    $wp_customize->add_control( 
        new \Kirki\Control\Sortable( 
            $wp_customize, 
            'header_components_l7left', 
            array(
                'label'   			=> esc_html__( 'Left Side', 'botiga' ),
                'section' 			=> 'botiga_section_main_header',
                'choices' 			=> array(
                    'hamburger_btn'    => esc_html__( 'Hamburger Button', 'botiga' ),
                    'search' 			=> esc_html__( 'Search', 'botiga' ),
                    'woocommerce_icons' => esc_html__( 'Cart &amp; account icons', 'botiga' ),
                    'button' 			=> esc_html__( 'Button', 'botiga' ),
                    'contact_info' 		=> esc_html__( 'Contact info', 'botiga' ),
                ),
                'active_callback' 	=> 'botiga_callback_header_layout_is_7',
                'priority'			=> 111
            ) 
        ) 
    );

    $wp_customize->add_setting( 
        'header_components_l7right', 
        array(
            'default'  			=> array( 'search', 'woocommerce_icons', 'hamburger_btn' ),
            'sanitize_callback'	=> 'botiga_sanitize_header_components_layout_7_8'
        ) 
    );
    
    $wp_customize->add_control( 
        new \Kirki\Control\Sortable( 
            $wp_customize, 
            'header_components_l7right', 
            array(
                'label'   			=> esc_html__( 'Right Side', 'botiga' ),
                'section' 			=> 'botiga_section_main_header',
                'choices' 			=> array(
                    'hamburger_btn'    => esc_html__( 'Hamburger Button', 'botiga' ),
                    'search' 			=> esc_html__( 'Search', 'botiga' ),
                    'woocommerce_icons' => esc_html__( 'Cart &amp; account icons', 'botiga' ),
                    'button' 			=> esc_html__( 'Button', 'botiga' ),
                    'contact_info' 		=> esc_html__( 'Contact info', 'botiga' ),
                ),
                'active_callback' 	=> 'botiga_callback_header_layout_is_7_8',
                'priority'			=> 111
            ) 
        ) 
    );

    $wp_customize->add_setting( 'header_divider_8',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Divider_Control( 
            $wp_customize, 
            'header_divider_8',
            array(
                'section' 		=> 'botiga_section_main_header',
                'active_callback' 	=> 'botiga_callback_header_layout_is_7_8',
                'priority'			=> 111
            )
        )
    );

    $wp_customize->add_setting(
        'main_header_desktop_offcanvas',
        array(
            'default'           => 'layout1',
            'sanitize_callback' => 'sanitize_key',
        )
    );
    $wp_customize->add_control(
        new Botiga_Radio_Images(
            $wp_customize,
            'main_header_desktop_offcanvas',
            array(
                'label'    	=> esc_html__( 'Desktop Offcanvas Mode', 'botiga' ),
                'section'  	=> 'botiga_section_main_header',
                'cols'		=> 2,
                'choices'  => array(
                    'layout1' => array(
                        'label' => esc_html__( 'Layout 1', 'botiga' ),
                        'url'   => '%s/assets/img/oc1.svg'
                    ),
                    'layout2' => array(
                        'label' => esc_html__( 'Layout 2', 'botiga' ),
                        'url'   => '%s/assets/img/oc2.svg'
                    ),	
                ),
                'active_callback' 	=> 'botiga_callback_header_layout_is_7_8',
                'priority'			=> 111
            )
        )
    );

    $wp_customize->add_setting( 
        'header_components_desktop_offcanvas', 
        array(
            'default'  			=> array( 'search', 'woocommerce_icons' ),
            'sanitize_callback'	=> 'botiga_sanitize_header_components_layout_7_8'
        ) 
    );
    
    $wp_customize->add_control( 
        new \Kirki\Control\Sortable( 
            $wp_customize, 
            'header_components_desktop_offcanvas', 
            array(
                'label'   			=> esc_html__( 'Additional Offcanvas Elements', 'botiga' ),
                'section' 			=> 'botiga_section_main_header',
                'choices' 			=> array(
                    'search' 			=> esc_html__( 'Search', 'botiga' ),
                    'woocommerce_icons' => esc_html__( 'Cart &amp; account icons', 'botiga' ),
                    'button' 			=> esc_html__( 'Button', 'botiga' ),
                    'contact_info' 		=> esc_html__( 'Contact info', 'botiga' ),
                ),
                'active_callback' 	=> 'botiga_callback_header_layout_is_7_8',
                'priority'			=> 111
            ) 
        ) 
    );

    $wp_customize->add_setting( 
        'header_components_desktop_offcanvas_elements_spacing', 
        array(
            'default'   		=> 15,
            'transport'			=> 'postMessage',
            'sanitize_callback' => 'absint',
        ) 
    );			
    
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'header_components_desktop_offcanvas_elements_spacing',
            array(
                'label' 		=> esc_html__( 'Elements Spacing', 'botiga' ),
                'section' 		=> 'botiga_section_main_header',
                'active_callback' => 'botiga_callback_header_layout_is_7_8',
                'is_responsive'	=> 0,
                'settings' 		=> array (
                    'size_desktop' 		=> 'header_components_desktop_offcanvas_elements_spacing',
                ),
                'input_attrs' => array (
                    'min'	=> 0,
                    'max'	=> 100
                ),
                'priority' => 111
            )
        ) 
    );

    $wp_customize->add_setting( 
        'desktop_offcanvas_vertical_align',
        array(
            'default' 			=> 'center',
            'sanitize_callback' => 'botiga_sanitize_text'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Radio_Buttons( 
            $wp_customize, 
            'desktop_offcanvas_vertical_align',
            array(
                'label' 		=> esc_html__( 'Vertical Alignment', 'botiga' ),
                'section' => 'botiga_section_main_header',
                'choices' => array(
                    'top' 		=> esc_html__( 'Top', 'botiga' ),
                    'center' 	=> esc_html__( 'Center', 'botiga' ),
                    'bottom' 	=> esc_html__( 'Bottom', 'botiga' ),
                ),
                'active_callback' => 'botiga_callback_header_layout_is_7_8',
                'priority'		  => 111
            )
        ) 
    );

    $wp_customize->add_setting( 
        'desktop_offcanvas_link_align',
        array(
            'default' 			=> 'center',
            'sanitize_callback' => 'botiga_sanitize_text'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Radio_Buttons( 
            $wp_customize, 
            'desktop_offcanvas_link_align',
            array(
                'label'   => esc_html__( 'Link alignment', 'botiga' ),
                'section' => 'botiga_section_main_header',
                'choices' => array(
                    'left' 		=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h10v1H0zM0 4h16v1H0zM0 8h10v1H0zM0 12h16v1H0z"/></svg>',
                    'center' 	=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 0h10v1H3zM0 4h16v1H0zM3 8h10v1H3zM0 12h16v1H0z"/></svg>',
                    'right' 	=> '<svg width="16" height="13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 0h10v1H6zM0 4h16v1H0zM6 8h10v1H6zM0 12h16v1H0z"/></svg>',
                ),
                'active_callback' 	=> 'botiga_callback_header_layout_is_7_8',
                'priority'			=> 111
            )
        ) 
    );

    $wp_customize->add_setting(
        'desktop_offcanvas_menu_link_separator',
        array(
            'default'           => 0,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'desktop_offcanvas_menu_link_separator',
            array(
                'label'         	=> esc_html__( 'Link separator', 'botiga' ),
                'section'       	=> 'botiga_section_main_header',
                'active_callback' 	=> 'botiga_callback_header_layout_is_7_8',
                'priority'			=> 111
            )
        )
    );
    
    $wp_customize->add_setting( 
        'desktop_offcanvas_menu_link_spacing', array(
            'default'   		=> 10,
            'sanitize_callback' => 'absint',
            'transport'			=> 'postMessage'
        ) 
    );			
    
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'desktop_offcanvas_menu_link_spacing',
            array(
                'label' 		=> esc_html__( 'Link spacing', 'botiga' ),
                'section' 		=> 'botiga_section_main_header',
                'is_responsive'	=> 0,
                'settings' 		=> array (
                    'size_desktop' 		=> 'desktop_offcanvas_menu_link_spacing',
                ),
                'input_attrs' => array (
                    'min'	=> 0,
                    'max'	=> 50,
                    'step'  => 1
                ),
                'active_callback' 	=> 'botiga_callback_header_layout_is_7_8',
                'priority'			=> 111
            )
        ) 
    );

    $wp_customize->add_setting( 
        'desktop_offcanvas_content_areas_spacing', 
        array(
            'default'   		=> 50,
            'transport'			=> 'postMessage',
            'sanitize_callback' => 'absint',
        ) 
    );			
    
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'desktop_offcanvas_content_areas_spacing',
            array(
                'label' 		=> esc_html__( 'Content Areas Spacing', 'botiga' ),
                'description'   => esc_html__( 'The spacing between logo, menu and elements.', 'botiga' ),
                'section' 		=> 'botiga_section_main_header',
                'active_callback' => 'botiga_callback_header_layout_is_7_8',
                'is_responsive'	=> 0,
                'settings' 		=> array (
                    'size_desktop' 		=> 'desktop_offcanvas_content_areas_spacing',
                ),
                'input_attrs' => array (
                    'min'	=> 0,
                    'max'	=> 100
                ),
                'priority' => 111
            )
        ) 
    );

    // Wishlist
    $wp_customize->add_setting(
        'enable_header_wishlist_icon',
        array(
            'default'           => 1,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'enable_header_wishlist_icon',
            array(
                'label'         	=> esc_html__( 'Enable wishlist icon', 'botiga' ),
                'section'       	=> 'botiga_section_main_header',
                'active_callback' 	=> 'botiga_callback_shop_product_wishlist_layout',
                'priority'			=> 221
            )
        )
    );
    
    /**
     * Design
     */
    $wp_customize->add_setting( 
        'main_header_divider_8',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );

    $wp_customize->add_control( 
        new Botiga_Divider_Control( 
            $wp_customize, 
            'main_header_divider_8',
            array(
                'section' 			=> 'botiga_section_main_header',
                'active_callback' => 'botiga_callback_header_layout_is_7_8',
                'priority'			=> 441
            )
        )
    );

    $wp_customize->add_setting( 
        'desktop_offcanvas_menu_title_1',
        array(
            'default' 			=> '',
            'sanitize_callback' => 'esc_attr'
        )
    );

    $wp_customize->add_control( 
        new Botiga_Text_Control( 
            $wp_customize, 
            'desktop_offcanvas_menu_title_1',
            array(
                'label'			=> esc_html__( 'Desktop Offcanvas Menu', 'botiga' ),
                'section' 		=> 'botiga_section_main_header',
                'active_callback'   => 'botiga_callback_header_layout_is_7_8',
                'priority'		=> 441
            )
        )
    );

    $wp_customize->add_setting(
        'desktop_offcanvas_menu_text_color',
        array(
            'default'           => '#212121',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'desktop_offcanvas_menu_text_color',
            array(
                'label'         	=> esc_html__( 'Text Color', 'botiga' ),
                'section'       	=> 'botiga_section_main_header',
                'active_callback'   => 'botiga_callback_header_layout_is_7_8',
                'priority'			=> 441
            )
        )
    );

    $wp_customize->add_setting(
        'desktop_offcanvas_menu_background_color',
        array(
            'default'           => '#fff',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'desktop_offcanvas_menu_background_color',
            array(
                'label'         	=> esc_html__( 'Background Color', 'botiga' ),
                'section'       	=> 'botiga_section_main_header',
                'active_callback'   => 'botiga_callback_header_layout_is_7_8',
                'priority'			=> 441
            )
        )
    );

    $wp_customize->add_setting(
        'desktop_offcanvas_link_separator_color',
        array(
            'default'           => '#212121',
            'sanitize_callback' => 'botiga_sanitize_hex_rgba',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new Botiga_Alpha_Color(
            $wp_customize,
            'desktop_offcanvas_link_separator_color',
            array(
                'label'         	=> esc_html__( 'Link Separator Color', 'botiga' ),
                'section'       	=> 'botiga_section_main_header',
                'active_callback'   => 'botiga_callback_header_layout_is_7_8',
                'priority'			=> 441
            )
        )
    );

    $wp_customize->add_setting( 
        'desktop_offcanvas_padding', array(
            'default'   		=> 30,
            'transport'			=> 'postMessage',
            'sanitize_callback' => 'absint',
        ) 
    );			
    
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'desktop_offcanvas_padding',
            array(
                'label' 		  => esc_html__( 'Padding', 'botiga' ),
                'section' 		  => 'botiga_section_main_header',
                'active_callback' => 'botiga_callback_header_layout_is_7_8',
                'is_responsive'	  => 0,
                'settings' 		  => array (
                    'size_desktop' 		=> 'desktop_offcanvas_padding',
                ),
                'input_attrs'     => array (
                    'min'	=> 0,
                    'max'	=> 100
                ),
                'priority'		  => 441
            )
        ) 
    );

    $wp_customize->add_setting( 'header_divider_9',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Divider_Control( 
            $wp_customize, 
            'header_divider_9',
            array(
                'section' 		=> 'botiga_section_main_header',
                'priority'			=> 441
            )
        )
    );

    $wp_customize->add_setting(
        'cart_icon',
        array(
            'default'           => 'icon-cart',
            'sanitize_callback' => 'sanitize_key',
        )
    );
    $wp_customize->add_control(
        new Botiga_Radio_Images(
            $wp_customize,
            'cart_icon',
            array(
                'label'    	=> esc_html__( 'Cart Icon', 'botiga' ),
                'section'  	=> 'botiga_section_main_header',
                'cols'		=> 4,
                'choices'  	=> array(			
                    'icon-cart'  => array(
                        'label'  => esc_html__( 'Icon 1', 'botiga' ),
                        'url'    => '%s/assets/img/cart-icon1.svg'
                    ),
                    'icon-cart2' => array(
                        'label'  => esc_html__( 'Icon 2', 'botiga' ),
                        'url'    => '%s/assets/img/cart-icon2.svg'
                    )
                ),
                'priority'		  => 441
            )
        )
    );
    
}
add_action( 'customize_register', 'botiga_pro_header_options', 999 );