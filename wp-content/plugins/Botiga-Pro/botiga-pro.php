<?php

/**
 *
 * @link              http://athemes.com
 * @since             1.0
 * @package           Botiga_Pro
 *
 * @wordpress-plugin
 * Plugin Name:       Botiga Pro
 * Description:       Provides enhancements for the Botiga WordPress theme
 * Version:           1.0.1
 * Author:            aThemes
 * Author URI:        http://athemes.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       botiga-pro
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$theme  = wp_get_theme();
$parent = wp_get_theme()->parent();

if ( ($theme != 'Botiga' ) && ($parent != 'Botiga') )
    return;

/**
 * Set up and initialize
 */
class Botiga_Pro {

	private static $instance;

	/**
	 * Returns the instance.
	 */
	public static function get_instance() {
		if ( ! self::$instance )
			self::$instance = new self;
			
		return self::$instance;
	}

	/**
	 * Actions setup
	 */
	public function __construct() {
		$theme  = wp_get_theme();
		$parent = wp_get_theme()->parent();

		add_action( 'plugins_loaded', array( $this, 'constants' ), 2 );	

		if( version_compare( $theme->Version, '1.0.8', '<' ) && !$parent || $parent && version_compare( $parent->Version, '1.0.8', '<' ) ) {
			add_action( 'admin_notices', array( $this, 'update_theme_notice' ) );
			return;
		}

		add_action( 'after_setup_theme', array( $this, 'pro_setup' ), 11 );	
		add_action( 'init', array( $this, 'includes' ), 9999 );
		add_action( 'widgets_init', array( $this, 'botiga_pro_widgets_init' ) );

		add_filter( 'thd_register_settings', array( $this, 'theme_dashboard_settings' ), 11 );
		add_filter( 'atss_register_demos_settings', array( $this, 'theme_dashboard_settings' ), 11 );
	}

	/**
	 * No botiga theme notice
	 */
	public function no_botiga_theme_notice() { ?>
		<div class="notice notice-warning is-dismissible">
			<p>
				<?php echo esc_html__( 'Botiga Pro is meant to be used with the Botiga theme. Please go to Appearance > Themes, search for "Botiga" and install/activate the theme.', 'botiga' ); ?>
			</p>
		</div>
	<?php
	}

	/**
	 * Update theme notice
	 */
	public function update_theme_notice() { ?>
		<div class="notice notice-warning is-dismissible">
			<p>
				<?php echo esc_html__( 'Botiga Pro needs the Botiga theme updated to the latest version. Please update the theme at Appearance > Themes.', 'botiga' ); ?>
			</p>
		</div>
	<?php
	}

	/**
	 * Constants
	 */
	public function constants() {
		define( 'ATHEMES_STORE_URL', 'http://athemes.com' );
		define( 'ATHEMES_PLUGIN_NAME', 'Botiga Pro' );
		define( 'BOTIGA_PRO_VERSION', '1.0.1' );
		define( 'BOTIGA_PRO_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'BOTIGA_PRO_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
	}  

	/**
	 * Theme dashboard settings
	 */
	public function theme_dashboard_settings( $settings ) {
		$settings['has_pro'] 		    = true;
		$settings['pro_status']         = true;
		$settings['changelog_version']  = BOTIGA_PRO_VERSION;
		$settings['documentation_link'] = 'https://docs.athemes.com/collection/318-botiga';
		$settings['changelog_link']     = 'https://athemes.com/changelog/botiga/';
		$settings['support_link']       = 'https://athemes.com/support/';

		return $settings;
	}

	/**
	 * Botiga pro setup
	 */
	public function pro_setup() {
		register_nav_menus(
			array(
				'footer-copyright-menu'	=> esc_html__( 'Footer Copyright Menu', 'botiga' )
			)
		);
	}

	/**
	 * Includes
	 */
	public function includes() {

		//Additional functions
		require_once( BOTIGA_PRO_DIR . 'inc/functions.php' );

		//Additional WooCommerce functions
		if( class_exists( 'Woocommerce' ) ) {
			require_once( BOTIGA_PRO_DIR . 'inc/woocommerce.php' );
		}
		
		//Customizer extra options
		if( is_customize_preview() ) {
			require_once( BOTIGA_PRO_DIR . 'inc/customizer/customizer.php' );
		}

		//Product swatch
		if( class_exists( 'Woocommerce' ) ) {
			require_once( BOTIGA_PRO_DIR . 'inc/classes/class-botiga-product-swatch.php' );
		}

		//Updates
		if( is_admin() ) {
			require_once( BOTIGA_PRO_DIR . 'updates.php' );
		}
	}

	/**
	 * Register widget area.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	public function botiga_pro_widgets_init() {
		
		// Shop Sidebar
		register_sidebar(
			array(
				'name'           => esc_html__( 'Shop Sidebar', 'botiga' ),
				'id'             => 'shop-sidebar-1',
				'description'    => esc_html__( 'Add widgets here.', 'botiga' ),
				'before_widget'  => '<section id="%1$s" class="widget %2$s">',
				'after_widget'   => '</section>',
				'before_title'   => '<h2 class="widget-title">',
				'after_title'    => '</h2>',
				'before_sidebar' => '<div class="sidebar-wrapper"><a href="#" role="button" class="close-sidebar" onclick="botiga.toggleClass.init(event, this, \'sidebar-slide-close\');" data-botiga-selector=".sidebar-slide+.widget-area" data-botiga-toggle-class="show">'. botiga_get_svg_icon( 'icon-cancel' ) .'</a>',
				'after_sidebar'  => '</div>'
			)
		);

	}

}
Botiga_Pro::get_instance();


/**
 * Updates
 */
if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
    include( plugin_dir_path( __FILE__ ) . '/EDD_SL_Plugin_Updater.php' );
}

function botiga_pro_plugin_updater() {
    $license_key = trim( get_option( 'botiga_pro_license_key' ) );

    // setup the updater
    $edd_updater = new EDD_SL_Plugin_Updater( ATHEMES_STORE_URL, __FILE__, array(
            'version'   => BOTIGA_PRO_VERSION,
            'license'   => $license_key,
            'item_name' => ATHEMES_PLUGIN_NAME,
            'author'    => 'aThemes'
        )
    );
}
add_action( 'admin_init', 'botiga_pro_plugin_updater', 0 );