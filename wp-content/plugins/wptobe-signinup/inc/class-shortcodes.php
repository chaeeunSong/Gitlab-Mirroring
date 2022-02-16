<?php 
class WTB_Sinup_Shortcode
{
	function __construct() 
	{
		add_filter( 'the_content', array( $this, 'wtb_add_sign_in_shortcode_to_a_page' ) );
		add_action( 'template_redirect', array( $this, 'wtb_redirect_signin_page_after_login' ) );
		add_action( 'template_redirect', array( $this, 'wtb_redirect_signup_page_after_login' ) );
		add_action( 'template_redirect', array( $this, 'wtb_redirect_profile_page_before_login' ) );
		add_filter( 'logout_url', array( $this, 'wtb_redirect_after_logout' ) );
	}

	public function wtb_add_sign_in_shortcode_to_a_page ( $content ) 
	{
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
		if ( (isset($wtbsigninup_setopt[0])) && ($wtbsigninup_setopt[0]!=0) && (is_page($wtbsigninup_setopt[0]))) {
			return $content . '[wtb_signin]';
		}
		if ( (isset($wtbsigninup_setopt[1])) && ($wtbsigninup_setopt[1]!=0) && (is_page($wtbsigninup_setopt[1]))) {
			return $content . '[wtb_signup]';
		}
		if ( (isset($wtbsigninup_setopt[5])) && ($wtbsigninup_setopt[5]!=0) && (is_page($wtbsigninup_setopt[5]))) {
			return $content . '[wtb_profile]';
		}
		return $content;
	}

	public function wtb_redirect_signin_page_after_login()
	{
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );

		if ( (isset($wtbsigninup_setopt[0])) && ($wtbsigninup_setopt[0]!=0) && (is_page($wtbsigninup_setopt[0])) && (is_user_logged_in()) ) {

			if( (isset($wtbsigninup_setopt[3])) && ($wtbsigninup_setopt[3]=='0'))//Home
			{
				wp_redirect(WTBSIGN_REDHOME);
				exit();
			}
			elseif( isset($wtbsigninup_setopt[0]) && isset($wtbsigninup_setopt[3]) && ($wtbsigninup_setopt[3] == $wtbsigninup_setopt[0]) ) 
			{	
				return;
			}
			elseif( isset($wtbsigninup_setopt[3])) //The other page
			{	
				wp_redirect(get_permalink($wtbsigninup_setopt[3]));
				exit();
			}
			else 
			{
				wp_redirect(WTBSIGN_REDHOME);
				exit();
			}
		}
	}

	public function wtb_redirect_signup_page_after_login()
	{
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );

		if ( (isset($wtbsigninup_setopt[1])) && ($wtbsigninup_setopt[1]!=0) && (is_page($wtbsigninup_setopt[1])) && (is_user_logged_in()) ) {
			wp_redirect(WTBSIGN_REDHOME);
			exit();
		}
	}

	public	function wtb_redirect_after_logout( $url ) 
	{
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );

		if ((isset($wtbsigninup_setopt[6])) && ($wtbsigninup_setopt[6]!=0) )
		{
			$redirect = get_permalink($wtbsigninup_setopt[6]);
			return $url.'&redirect_to='.$redirect;
		}
		else
		{
		    $redirect = home_url();
		    return $url.'&redirect_to='.$redirect;
		}
	}

	public function wtb_redirect_profile_page_before_login()
	{
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
		if ((isset($wtbsigninup_setopt[5])) && ($wtbsigninup_setopt[5]!=0) && (is_page($wtbsigninup_setopt[5])) && (!is_user_logged_in()) )
		{
			if ( (isset($wtbsigninup_setopt[2])) && ($wtbsigninup_setopt[2]==0)) 
			{	
				wp_redirect(WTBSIGN_REDHOME);
				exit;
			}
			elseif( (isset($wtbsigninup_setopt[2])) && ($wtbsigninup_setopt[2]!=0)) 
			{
				if($wtbsigninup_setopt[2]==$wtbsigninup_setopt[5])
				{
					wp_redirect(WTBSIGN_REDHOME);
					exit;
				}
				elseif($wtbsigninup_setopt[2]!=$wtbsigninup_setopt[5])
				{
					wp_redirect(get_permalink($wtbsigninup_setopt[2]));
					exit();
				}
			}
		}
	}
}
$wtb_shortcode = new WTB_Sinup_Shortcode();