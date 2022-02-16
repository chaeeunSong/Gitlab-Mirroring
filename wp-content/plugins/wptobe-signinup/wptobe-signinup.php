<?php
/**
 * Plugin Name:       Wptobe Signinup
 * Plugin URI:        http://wptobe.com/download/
 * Description:       Wptobe Signinup is a very light plugin that lets you easily and safely build sign in/up with designed page. 
 * Version:           1.1.2
 * Requires PHP:      5.3
 * Author:            WPTOBE Cooperation
 * Author URI:        http://wptobe.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wtbsinup
 * Domain Path:       /lang
 */
define("WTBSIGN_DIR", dirname(__FILE__));
define("WTBSIGN_DIRURL", plugin_dir_url ( __FILE__ ));
define("WTBSIGN_SKIN", dirname(__FILE__)."/skin");
define("WTBSIGN_SKINURL", WTBSIGN_DIRURL."skin");
define("WTBSIGN_LANG", dirname( plugin_basename( __FILE__ ) ) . '/lang/');
define("WTBSIGN_REDHOME", site_url(''));
define("WTB_TDOM", 'wtbsinup');

require_once (WTBSIGN_DIR . "/admin/admin-settings.php"); 
require_once (WTBSIGN_DIR . "/captcha/securimage.php");
require_once (WTBSIGN_DIR . "/inc/class-ignite.php");
require_once (WTBSIGN_DIR . "/inc/class-enqueues.php");
require_once (WTBSIGN_DIR . "/inc/class-shortcodes.php");
require_once (WTBSIGN_DIR . "/inc/class-email.php");

class WTB_Activation {
  public static function activate() {
       if ( ! current_user_can( 'activate_plugins' ) )   return;
		$wtb_ignite = new WTB_Setup_Init_Class();
		$wtb_ignite->wptobe_signinup_install(false);
  }

  public static function deactivate() {
        if ( ! current_user_can( 'activate_plugins' ) )  return;
		//Deactivation code
  }
}
register_activation_hook(__FILE__, array('WTB_Activation', 'activate'));
register_deactivation_hook(__FILE__, array('WTB_Activation', 'deactivate'));

