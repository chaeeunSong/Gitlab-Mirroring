<?php
class WTB_Sinup_Email
{
	function __construct() 
	{
		add_filter( 'wp_mail_from', array( $this, 'wtb_email_from' ) );
		add_filter( 'wp_mail_from_name', array( $this, 'wtb_email_from_name' ) );
	}

	public function wtb_email_from( $original_email_address ) 
	{
		$new_sender_email ='';

		$wtb_email_sender = get_option( 'wtb_esender_fields' );
		$new_sender_email = $wtb_email_sender[0][3];
		
		return $new_sender_email;
	}

	// Function to change sender name
	public function wtb_email_from_name( $original_email_from ) 
	{
		$new_sender_name ="";

		$wtb_email_sender = get_option( 'wtb_esender_fields' );
		$new_sender_name = $wtb_email_sender[1][3];

		return $new_sender_name;
	}
	 

	/************************************************************
	 * Send emails on reset password [Forget Password]
	 ************************************************************/
	public function wtb_reset_password_send_email($rpw_user, $password='') 
	{
		//Get current language setting
		$wtbsinup_lang = get_option( 'wtbsinup_lang' );
		if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {$_lang = $wtbsinup_lang[0]; }else { $_lang = 'en_US'; }
		switch ($_lang) {
			case 'ko_KR':
				$resetpw_field_option = get_option( 'wtb_resetpw_email_ko' );
				break;
			case 'ja':
				$resetpw_field_option = get_option( 'wtb_resetpw_email_ja' );
				break;
			default: //'en'
				$resetpw_field_option = get_option( 'wtb_resetpw_email_en' );
				break;	
		}// Language (End)
		
		$to = $rpw_user->user_email; 
		$title = $resetpw_field_option[0][3];
		$blog_name = get_bloginfo( 'name' );

		$site_link = site_url();
		$message  = $resetpw_field_option[1][3]."<br/><br/>".$resetpw_field_option[2][3]."<br/><br/>".$resetpw_field_option[3][3];
		
		$new_userid = $rpw_user->user_login;
		$new_password = $password;
		
		$title =	str_replace( '[bloginfo]', $blog_name , $title );
		$message =	str_replace( '[username]', $new_userid, $message );
		$message =	str_replace( '[password]', $new_password, $message );

		$headers[]= 'MIME-Version: 1.0';
		$headers[]= 'Content-Type: text/html; charset=UTF-8';

		$sent = wp_mail($to, $title, $message,$headers);
		return $sent;
	}
}
$wtb_email = new WTB_Sinup_Email();