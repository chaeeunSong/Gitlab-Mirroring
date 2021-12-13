<?php
/**
 * Footer Customizer options
 *
 * @package Botiga_Pro
 */

function botiga_pro_footer_options( $wp_customize ) {
    
    // Tabs control
    $controls_general     = json_decode( $wp_customize->get_control( 'botiga_footer_credits_tabs' )->controls_general );
    $new_controls_general = array( '#customize-control-footer_divider_10','#customize-control-footer_payment_image','#customize-control-footer_payment_position','#customize-control-footer_divider_11','#customize-control-footer_navigation_menu_link','#customize-control-footer_navigation_menu_position','#customize-control-footer_divider_12','#customize-control-footer_html_content','#customize-control-footer_html_position','#customize-control-footer_divider_13','#customize-control-footer_shortcode_content','#customize-control-footer_shortcode_position' );
    $wp_customize->get_control( 'botiga_footer_credits_tabs' )->controls_general = json_encode( array_merge( $controls_general, $new_controls_general ) );
    
    $controls_design     = json_decode( $wp_customize->get_control( 'botiga_footer_credits_tabs' )->controls_design );
    $new_controls_design = array( '#customize-control-footer_copyright_elements_spacing_desktop' );
    $wp_customize->get_control( 'botiga_footer_credits_tabs' )->controls_design = json_encode( array_merge( $controls_design, $new_controls_design ) );

    // Copyright elements
    $wp_customize->get_control( 'footer_copyright_elements' )->choices = array(
        'footer_credits'         => esc_html__( 'Credits', 'botiga' ),
        'footer_social_profiles' => esc_html__( 'Social Profiles', 'botiga' ),
        // pro features below
        'footer_payment_icons'	 => esc_html__( 'Payment Icons', 'botiga' ),
        'footer_navigation_menu' => esc_html__( 'Navigation Menu', 'botiga' ),
        'footer_html'            => esc_html__( 'HTML', 'botiga' ),
        'footer_shortcode'       => esc_html__( 'Shortcode', 'botiga' )
    );

    // Divider
    $wp_customize->add_setting( 'footer_divider_10',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Botiga_Divider_Control( $wp_customize, 'footer_divider_10',
            array(
                'section' 		  => 'botiga_section_footer_credits',
                'active_callback' => function(){ return botiga_callback_footer_copyright_elements( 'footer_social_profiles' ); },
                'priority'        => 61
            )
        )
    );

    // Payment image
    $wp_customize->add_setting(
        'footer_payment_image',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'footer_payment_image',
            array(
                'label'           => __( 'Payment Icons', 'theme_name' ),
                'section'         => 'botiga_section_footer_credits',
                'active_callback' => function(){ return botiga_callback_footer_copyright_elements( 'footer_payment_icons' ); },
                'priority'        => 61
            )
        )
    );

    // Payment image position
    $wp_customize->add_setting( 
        'footer_payment_position',
        array(
            'default' 			=> 'right',
            'sanitize_callback' => 'botiga_sanitize_text'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Radio_Buttons( 
            $wp_customize, 
            'footer_payment_position',
            array(
                'label' 	      => esc_html__( 'Position', 'botiga' ),
                'section' 	      => 'botiga_section_footer_credits',
                'choices'         => array(
                    'left'  => esc_html__( 'Left', 'botiga' ),
                    'right' => esc_html__( 'Right', 'botiga' ),
                ),
                'active_callback' => function(){ return botiga_callback_footer_copyright_elements( 'footer_payment_icons' ); },
                'priority'        => 61
            )
        ) 
    );

    // Divider
    $wp_customize->add_setting( 'footer_divider_11',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Botiga_Divider_Control( $wp_customize, 'footer_divider_11',
            array(
                'section' 		  => 'botiga_section_footer_credits',
                'active_callback' => function(){ return botiga_callback_footer_copyright_elements( 'footer_payment_icons' ); },
                'priority'        => 61
            )
        )
    );

    $wp_customize->add_setting( 
        'footer_navigation_menu_link',
        array(
            'default' 			=> '',
            'sanitize_callback' => 'esc_attr'
        )
    );

    $wp_customize->add_control( 
        new Botiga_Text_Control( 
            $wp_customize, 
            'footer_navigation_menu_link',
            array(
                'label'           => esc_html__( 'Navigation Menu', 'botiga' ),
                'description'     => '<a class="footer-widget-area-link footer-widget-area-link-1" href="javascript:wp.customize.section( \'menu_locations\' ).focus();">' . esc_html__( 'Configure menu', 'botiga' ) . '<span class="dashicons dashicons-arrow-right-alt2"></span></a>',
                'section' 		  => 'botiga_section_footer_credits',
                'active_callback' => function(){ return botiga_callback_footer_copyright_elements( 'footer_navigation_menu' ); },
                'priority'        => 61
            )
        )
    );

    // Navigation menu position
    $wp_customize->add_setting( 
        'footer_navigation_menu_position',
        array(
            'default' 			=> 'left',
            'sanitize_callback' => 'botiga_sanitize_text'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Radio_Buttons( 
            $wp_customize, 
            'footer_navigation_menu_position',
            array(
                'label' 	      => esc_html__( 'Position', 'botiga' ),
                'section' 	      => 'botiga_section_footer_credits',
                'choices'         => array(
                    'left'   => esc_html__( 'Left', 'botiga' ),
                    'right'  => esc_html__( 'Right', 'botiga' ),
                ),
                'active_callback' => function(){ return botiga_callback_footer_copyright_elements( 'footer_navigation_menu' ); },
                'priority'        => 61
            )
        ) 
    );

    // Divider
    $wp_customize->add_setting( 'footer_divider_12',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Botiga_Divider_Control( $wp_customize, 'footer_divider_12',
            array(
                'section' 		  => 'botiga_section_footer_credits',
                'active_callback' => function(){ return botiga_callback_footer_copyright_elements( 'footer_navigation_menu' ); },
                'priority'        => 61
            )
        )
    );

    // HTML field content
    $wp_customize->add_setting(
        'footer_html_content',
        array(
            'sanitize_callback' => 'botiga_sanitize_text',
            'default'           => '',
        )       
    );
    $wp_customize->add_control( 
        'footer_html_content', 
        array(
            'label'           => esc_html__( 'HTML Content', 'botiga' ),
            'type'            => 'textarea',
            'section'         => 'botiga_section_footer_credits',
            'active_callback' => function(){ return botiga_callback_footer_copyright_elements( 'footer_html' ); },
            'priority'        => 61
        ) 
    );

    // HTML field position
    $wp_customize->add_setting( 
        'footer_html_position',
        array(
            'default' 			=> 'right',
            'sanitize_callback' => 'botiga_sanitize_text'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Radio_Buttons( 
            $wp_customize, 
            'footer_html_position',
            array(
                'label' 	      => esc_html__( 'Position', 'botiga' ),
                'section' 	      => 'botiga_section_footer_credits',
                'choices'         => array(
                    'left'   => esc_html__( 'Left', 'botiga' ),
                    'right'  => esc_html__( 'Right', 'botiga' ),
                ),
                'active_callback' => function(){ return botiga_callback_footer_copyright_elements( 'footer_html' ); },
                'priority'        => 61
            )
        ) 
    );

    // Divider
    $wp_customize->add_setting( 'footer_divider_13',
        array(
            'sanitize_callback' => 'esc_attr'
        )
    );
    $wp_customize->add_control( new Botiga_Divider_Control( $wp_customize, 'footer_divider_13',
            array(
                'section' 		  => 'botiga_section_footer_credits',
                'active_callback' => function(){ return botiga_callback_footer_copyright_elements( 'footer_html' ); },
                'priority'        => 61
            )
        )
    );

    // Shortcode field content
    $wp_customize->add_setting(
        'footer_shortcode_content',
        array(
            'sanitize_callback' => 'botiga_sanitize_text',
            'default'           => '',
        )       
    );
    $wp_customize->add_control( 
        'footer_shortcode_content', 
        array(
            'label'           => esc_html__( 'Shortcode Tag', 'botiga' ),
            'type'            => 'text',
            'section'         => 'botiga_section_footer_credits',
            'active_callback' => function(){ return botiga_callback_footer_copyright_elements( 'footer_shortcode' ); },
            'priority'        => 61
        ) 
    );

    // Shortcode field position
    $wp_customize->add_setting( 
        'footer_shortcode_position',
        array(
            'default' 			=> 'right',
            'sanitize_callback' => 'botiga_sanitize_text'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Radio_Buttons( 
            $wp_customize, 
            'footer_shortcode_position',
            array(
                'label' 	      => esc_html__( 'Position', 'botiga' ),
                'section' 	      => 'botiga_section_footer_credits',
                'choices'         => array(
                    'left'   => esc_html__( 'Left', 'botiga' ),
                    'right'  => esc_html__( 'Right', 'botiga' ),
                ),
                'active_callback' => function(){ return botiga_callback_footer_copyright_elements( 'footer_shortcode' ); },
                'priority'        => 61
            )
        ) 
    );

    //Styling

    //Elements spacing
    $wp_customize->add_setting( 
        'footer_copyright_elements_spacing_desktop', 
            array(
            'default'   		=> 15,
            'transport'			=> 'postMessage',
            'sanitize_callback' => 'absint',
        ) 
    );			
    
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'footer_copyright_elements_spacing_desktop',
            array(
                'label' 		=> esc_html__( 'Elements Spacing', 'botiga' ),
                'section' 		=> 'botiga_section_footer_credits',
                'is_responsive'	=> 0,
                'settings' 		=> array (
                    'size_desktop' 		=> 'footer_copyright_elements_spacing_desktop',
                ),
                'input_attrs' => array (
                    'min'	=> 0,
                    'max'	=> 60
                ),
                'priority' => 161	
            )
        ) 
    );
}
add_action( 'customize_register', 'botiga_pro_footer_options', 999 );