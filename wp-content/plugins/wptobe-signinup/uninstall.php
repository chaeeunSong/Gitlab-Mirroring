<?php
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
{
	die;
}
if ( WP_UNINSTALL_PLUGIN ) 
{
	wtbsigninup_remove_options();
}
function wtbsigninup_remove_options()
{
	if(get_option( 'wtb_sinup_installed' )) delete_option( 'wtb_sinup_installed'  );
	if(get_option( 'wtb_signin_fields' )) delete_option( 'wtb_signin_fields'  );
	if(get_option( 'wtb_signup_fields' )) delete_option( 'wtb_signup_fields'  );
	if(get_option( 'wtb_profile_fields' )) delete_option( 'wtb_profile_fields'  );
	if(get_option( 'wtb_resetpw_fields' )) delete_option( 'wtb_resetpw_fields'  );
	if(get_option( 'wtbsigninup_setopt' )) delete_option( 'wtbsigninup_setopt'  );
	if(get_option( 'wtbsinup_lang' )) delete_option( 'wtbsinup_lang'  );
	if(get_option( 'wtb_signin_noti_en' )) delete_option( 'wtb_signin_noti_en'  );
	if(get_option( 'wtb_signin_noti_ko' )) delete_option( 'wtb_signin_noti_ko'  );
	if(get_option( 'wtb_signin_noti_ja' )) delete_option( 'wtb_signin_noti_ja'  );
	if(get_option( 'wtb_signup_noti_en' )) delete_option( 'wtb_signup_noti_en'  );
	if(get_option( 'wtb_signup_noti_ko' )) delete_option( 'wtb_signup_noti_ko'  );
	if(get_option( 'wtb_signup_noti_ja' )) delete_option( 'wtb_signup_noti_ja'  );
	if(get_option( 'wtb_profile_noti_en' )) delete_option( 'wtb_profile_noti_en'  );
	if(get_option( 'wtb_profile_noti_ko' )) delete_option( 'wtb_profile_noti_ko'  );
	if(get_option( 'wtb_profile_noti_ja' )) delete_option( 'wtb_profile_noti_ja'  );
	if(get_option( 'wtb_resetpw_noti_en' )) delete_option( 'wtb_resetpw_noti_en'  );
	if(get_option( 'wtb_resetpw_noti_ko' )) delete_option( 'wtb_resetpw_noti_ko'  );
	if(get_option( 'wtb_resetpw_noti_ja' )) delete_option( 'wtb_resetpw_noti_ja'  );
	if(get_option( 'wtb_resetpw_email_en' )) delete_option( 'wtb_resetpw_email_en'  );
	if(get_option( 'wtb_resetpw_email_ko' )) delete_option( 'wtb_resetpw_email_ko'  );
	if(get_option( 'wtb_resetpw_email_ja' )) delete_option( 'wtb_resetpw_email_ja'  );
	if(get_option( 'wtb_esender_fields' )) delete_option( 'wtb_esender_fields'  );
	if(get_option( 'wtbsinup_skin' )) delete_option( 'wtbsinup_skin'  );
}