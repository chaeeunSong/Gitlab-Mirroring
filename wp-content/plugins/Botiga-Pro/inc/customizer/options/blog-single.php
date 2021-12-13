<?php
/**
 * Blog Single Customizer options
 *
 * @package Botiga_Pro
 */

function botiga_pro_blog_single_options( $wp_customize ) {

	// Reading time
	$wp_customize->get_control( 'single_post_meta_elements' )->choices =  array(
		'botiga_posted_on' 			=> esc_html__( 'Post date', 'botiga' ),
		'botiga_posted_by' 			=> esc_html__( 'Post author', 'botiga' ),
		'botiga_post_categories'	=> esc_html__( 'Post categories', 'botiga' ),
		'botiga_entry_comments' 	=> esc_html__( 'Post comments', 'botiga' ),
        // Pro features below
		'botiga_post_reading_time'  => esc_html__( 'Reading time', 'botiga' )
	);

    // Related posts as slider
    $wp_customize->add_setting(
        'single_post_related_posts_slider',
        array(
            'default'           => 0,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'single_post_related_posts_slider',
            array(
                'label'         	=> esc_html__( 'Related posts slider', 'botiga' ),
                'section'       	=> 'botiga_section_blog_singles',
                'active_callback'   => 'botiga_callback_single_post_show_related_posts',
                'priority' 			=> 310
            )
        )
    );

    // Related posts slider nav
    $wp_customize->add_setting( 
        'single_post_related_posts_slider_nav',
        array(
            'default' 			=> 'always-show',
            'sanitize_callback' => 'botiga_sanitize_text'
        )
    );
    $wp_customize->add_control( 
        new Botiga_Radio_Buttons( 
            $wp_customize, 
            'single_post_related_posts_slider_nav',
            array(
                'label' 	      => esc_html__( 'Related posts slider navigation', 'botiga' ),
                'section' 	      => 'botiga_section_blog_singles',
                'active_callback' => 'botiga_callback_single_post_related_posts_slider_navigation',
                'choices'         => array(
                    'always-show' => esc_html__( 'Always show', 'botiga' ),
                    'hover-show'  => esc_html__( 'Show on hover', 'botiga' ),
                ),
                'priority' 		  => 310
            )
        ) 
    );

    // Related posts number
    $wp_customize->add_setting( 
        'single_post_related_posts_number', 
        array(
            'default'   		=> 3,
            'sanitize_callback' => 'botiga_sanitize_text',
        ) 
    );			
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'single_post_related_posts_number',
            array(
                'label' 		=> esc_html__( 'Number of posts', 'botiga' ),
                'section' 		=> 'botiga_section_blog_singles',
                'active_callback'   => 'botiga_callback_single_post_show_related_posts',
                'is_responsive'	=> 0,
                'settings' 		=> array (
                    'size_desktop' 		=> 'single_post_related_posts_number',
                ),
                'input_attrs' => array (
                    'min'	=> 1,
                    'max'	=> 25,
                    'step'  => 1
                ),
                'priority'      => 310
            )
        )
    );

    // Related post columns number
    $wp_customize->add_setting( 
        'single_post_related_posts_columns_number', 
        array(
            'default'   		=> 3,
            'sanitize_callback' => 'botiga_sanitize_text',
        ) 
    );			
    $wp_customize->add_control( 
        new Botiga_Responsive_Slider( 
            $wp_customize, 
            'single_post_related_posts_columns_number',
            array(
                'label' 		=> esc_html__( 'Number of columns', 'botiga' ),
                'section' 		=> 'botiga_section_blog_singles',
                'active_callback'   => 'botiga_callback_single_post_show_related_posts',
                'is_responsive'	=> 0,
                'settings' 		=> array (
                    'size_desktop' 		=> 'single_post_related_posts_columns_number',
                ),
                'input_attrs' => array (
                    'min'	=> 1,
                    'max'	=> 6,
                    'step'  => 1
                ),
                'priority' 		=> 310
            )
        )
    );

    // Share box
    $wp_customize->add_setting(
        'single_post_share_box',
        array(
            'default'           => 0,
            'sanitize_callback' => 'botiga_sanitize_checkbox',
        )
    );
    $wp_customize->add_control(
        new Botiga_Toggle_Control(
            $wp_customize,
            'single_post_share_box',
            array(
                'label'         	=> esc_html__( 'Share Box', 'botiga' ),
                'section'       	=> 'botiga_section_blog_singles',
                'priority' 			=> 241
            )
        )
    );
}
add_action( 'customize_register', 'botiga_pro_blog_single_options', 999 );