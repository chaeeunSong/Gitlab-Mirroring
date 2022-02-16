<?php 
class WTB_Sinup_Enqueue
{

	function __construct() 
	{
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_stylenscript' )   );
		add_action( 'wp_enqueue_scripts', array( $this, 'wtb_signinup_frontend_enqueue_scripts' ),9  );
		add_action( 'wp_enqueue_scripts', array( $this, 'wtb_signinup_shortcodes_enqueue' )   );
	}

	public function load_admin_stylenscript($page) 
	{
		if($page == 'toplevel_page_wtb-signinup')  {
			add_thickbox();
			wp_enqueue_style('wtb_signinup_admin_css',  WTBSIGN_DIRURL.'admin/admin-settings.css');
			wp_enqueue_script( 'wtbadm-managefield-js',  WTBSIGN_DIRURL.'admin/field-dragndrop.js' );
			wp_enqueue_script( 'wtbadm-sellang-js',  WTBSIGN_DIRURL.'admin/select-lang.js' );
			wp_localize_script('wtbadm-sellang-js','SelLang',array('ajax_url' => admin_url( 'admin-ajax.php' ),'security' =>wp_create_nonce('select_a_lang_nonce')) );
			wp_enqueue_script( 'wtbadm-selskin-js',  WTBSIGN_DIRURL.'admin/select-skin.js' );
			wp_localize_script('wtbadm-selskin-js','SelSkin',array('ajax_url' => admin_url( 'admin-ajax.php' ),'security' =>wp_create_nonce('select_a_skin_nonce')) );
		}
	}

	public function wtb_signinup_frontend_enqueue_scripts()
	{
		wp_register_script('wtb-fe-signin-pvresubmit', WTBSIGN_DIRURL . 'js/prevent-resubmit.js');
		wp_register_script('wtb-fe-tabs', WTBSIGN_DIRURL . 'js/wtbfe-tabs.js');
		wp_register_style('wtb-fe-signin-style', SIGNIN_CSS);
		wp_register_style('wtb-fe-signup-style', SIGNUP_CSS);
		wp_register_style('wtb-fe-profile-style', PROFILE_CSS);
		wp_register_style('wtb-fe-wooc-daumaddr-style', WOODAUMADDR_CSS);
	}

	public function wtb_signinup_shortcodes_enqueue() 
	{
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );

		if ( isset($wtbsigninup_setopt[0]) && is_page( $wtbsigninup_setopt[0] ) ) 
		{	//Signin
			wp_enqueue_style('wtb-fe-signin-style');
			wp_enqueue_script( 'wtb-fe-signin-pvresubmit');
		}
		if ( isset($wtbsigninup_setopt[1]) && is_page( $wtbsigninup_setopt[1] ) ) 
		{	//Signup
			wp_enqueue_style('wtb-fe-signup-style');
			wp_enqueue_script( 'wtb-fe-signin-pvresubmit');
		}
		if (isset($wtbsigninup_setopt[5]) && is_page($wtbsigninup_setopt[5]) ) 
		{	//Profile
			wp_enqueue_style('wtb-fe-profile-style');
			wp_enqueue_script( 'wtb-fe-tabs');
			wp_enqueue_script( 'wtb-fe-profile-form');
			wp_enqueue_script( 'wtb-fe-signin-pvresubmit');
		}
	}
}
$wtb_enq = new WTB_Sinup_Enqueue();