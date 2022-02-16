<?php 
$resetpw_field_order = get_option( 'wtb_resetpw_fields' );
$wtbsinup_lang = get_option( 'wtbsinup_lang' );
$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {	$lang = $wtbsinup_lang[0]; } else { $lang = 'en_US'; }

switch ($lang) {
		case 'ko_KR':	
				$wtb_resetpw_noti_ko = get_option('wtb_resetpw_noti_ko');
				if(isset($wtb_resetpw_noti_ko)) 
				{
					$noti_0 = 	sanitize_text_field($wtb_resetpw_noti_ko[0]); 
					$noti_1 = 	sanitize_text_field($wtb_resetpw_noti_ko[1]);
				}
			break;
		case 'ja':
				$wtb_resetpw_noti_ja = get_option('wtb_resetpw_noti_ja');
				if(isset($wtb_resetpw_noti_ja)) 
				{
					$noti_0 = 	sanitize_text_field($wtb_resetpw_noti_ja[0]);
					$noti_1 = 	sanitize_text_field($wtb_resetpw_noti_ja[1]);
				}
			break;
		default: //'en'
				$wtb_resetpw_noti_en = get_option('wtb_resetpw_noti_en');
				if(isset($wtb_resetpw_noti_en)) 
				{
					$noti_0 = 	sanitize_text_field($wtb_resetpw_noti_en[0]);
					$noti_1 = 	sanitize_text_field($wtb_resetpw_noti_en[1]);
				}
			break;
}

if((isset($_POST['form_wtb_resetpw_submit'])) && ($_POST['form_wtb_resetpw_submit']=="Reset password")) {
	
	$rpw_error=false;
	if(isset($_POST ["rpw_unameemail"]) && !empty($_POST ["rpw_unameemail"])) {
		
		//CASE 1: 이메일이 입력된 경우
		if (is_email( $_POST ["rpw_unameemail"] )) { 
			$rpw_email = sanitize_email($_POST ["rpw_unameemail"]);
			$exist_email = email_exists( $rpw_email );
			
			if($exist_email) { $RPW_UNAMEEMAIL = $rpw_email; $rpw_user = get_user_by( 'email', $rpw_email );}
			else { $RPW_UNAMEEMAIL = "unknown"; $rpw_error=true; $rpw_user=false;}
		}
		//CASE 2: 아이디가 입력된 경우
		else { 
			$RPW_ID = sanitize_user( $_POST ["rpw_unameemail"] ); 
			$rpw_user = get_user_by( 'login', $RPW_ID );
			if($rpw_user) { $RPW_UNAMEEMAIL = $rpw_user->user_email; }
			else { $RPW_UNAMEEMAIL = "unknown"; $rpw_error=true; }
		}
		//새로운 패스워드를 생성해서 이메일로 전송
		if( $rpw_user && ($RPW_UNAMEEMAIL != "unknown")) {
			$new_pass = wp_generate_password();
			wp_update_user( array ( 'ID' => $rpw_user->ID, 'user_pass' => $new_pass ) );
			$wtb_sendmail = new WTB_Sinup_Email();
			$mail_result = $wtb_sendmail->wtb_reset_password_send_email($rpw_user, $new_pass);
		}
	}
}
?>
<!--
/*******************************************************************************************
■ [아래 HTML/CSS를 수정 가능]
■ [New design work is possible by modifying the following HTML/CSS]
********************************************************************************************/
-->
<div class="wtbfe-repw-container">

<?php 
if(isset($rpw_error) && !$rpw_error && isset($mail_result) && $mail_result )
{
	// Success
	?>
	<div class="wtbfe-repw-noti-box">
		<div class="wtbfe-noti success">
			<?php  echo $noti_0;//_e('Password reset successfully! <br /><br />An email containing a new password has been sent to the email address on file for your account.',WTB_TDOM); ?>
		</div>
	</div> 
	<?php
}

if( (isset($rpw_error) && $rpw_error) || (isset($mail_result) && !$mail_result) || (isset($rpw_error) &&!$rpw_error && !isset($mail_result)))
{
	// Failed
	?>
	<div class="wtbfe-repw-noti-box">
		<div class="wtbfe-noti danger">
		<?php echo $noti_1;// _e('Either the username or email address do not exist in our records.',WTB_TDOM); ?>
			
		</div>
	</div> 
	<?php
}
?>

 <div class="wtbfe-repw-box">
  <div class="wtbfe-repw-inner">
	<div class="wtbfe-repw-fields-wrapper">
		<form id="lostpasswordform" name="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
		<?php 
			foreach($resetpw_field_order as $value) {
			  if($value[3]=='on') {
				switch ($value[2]) {
					case 'o_header':
						?>
						<div class="wtbfe-repw-pgtitle-field">	   
							<div class="wtbfe-repw-pgtitle-text"><?php echo esc_html($value[1]);?></div>
						</div>
						<?php
						break;
					case 'o_desc':
						?>
						<div class="wtbfe-repw-desc">
							<?php echo esc_html($value[1]);?>
						</div>
						<?php
						
						break;
					case 'o_unameemail':
						?>
						<div class="wtbfe-input-field">
							<label for="user_login"><?php echo esc_html($value[1]);?></label>
							<input type="text" class="rpw-input" name="rpw_unameemail">
						</div>
						<?php
						break;
					case 'o_button':
						?>
						<div class="wtbfe-repw-btn-wrapper">
							<input type="hidden" name="form_wtb_resetpw_submit" class=""  value="Reset password"/>
							<input type="submit" class="wtbfe-repw-button wtbfe-signin-btn-default" value="<?php echo esc_html($value[1]);?>"  />
						</div>
						<?php
						break;
					case 'o_separator':
						?>
						<div class="wtbfe-repw-separator"></div>
						<?php
						break;
					case 'o_backtosin':
						?>
						<div class="wtbfe-repw-back-signin">
							<a href="<?php if ( (isset($wtbsigninup_setopt[0])) && ($wtbsigninup_setopt[0]!=0) ) echo get_permalink($wtbsigninup_setopt[0]); else echo "#";?>"> <?php echo esc_html($value[1]);?> </a>
						</div>
						<?php
						break;

					default:
						break;
				}//switch
			  }//if
			}//foreach
		?>
		</form>
	</div>
  </div>
 </div><!--wtbfe-resetpw-box-->
</div><!--wtbfe-resetpw-container-->