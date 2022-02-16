<?php 
	$signin_field_order = get_option( 'wtb_signin_fields' );
	$wtbsinup_lang = get_option( 'wtbsinup_lang' );
	if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {	$lang = $wtbsinup_lang[0]; } else { $lang = 'en_US'; }
	
	switch ($lang) {
			case 'ko_KR':	
					$wtb_signin_noti_ko = get_option('wtb_signin_noti_ko');
					if(isset($wtb_signin_noti_ko)) 
					{
						if(isset($wtb_signin_noti_ko[0]))  $noti_0=sanitize_text_field($wtb_signin_noti_ko[0]); else $noti_0 = '';
						if(isset($wtb_signin_noti_ko[1]))  $noti_1=sanitize_text_field($wtb_signin_noti_ko[1]); else $noti_1 = '';
						if(isset($wtb_signin_noti_ko[2]))  $noti_2=sanitize_text_field($wtb_signin_noti_ko[2]); else $noti_2 = '';
						if(isset($wtb_signin_noti_ko[3]))  $noti_3=sanitize_text_field($wtb_signin_noti_ko[3]); else $noti_3 = '';
					}
				break;
			case 'ja':
					$wtb_signin_noti_ja = get_option('wtb_signin_noti_ja');
					if(isset($wtb_signin_noti_ja)) 
					{
						if(isset($wtb_signin_noti_ja[0]))  $noti_0=sanitize_text_field($wtb_signin_noti_ja[0]); else $noti_0 = '';
						if(isset($wtb_signin_noti_ja[1]))  $noti_1=sanitize_text_field($wtb_signin_noti_ja[1]); else $noti_1 = '';
						if(isset($wtb_signin_noti_ja[2]))  $noti_2=sanitize_text_field($wtb_signin_noti_ja[2]); else $noti_2 = '';
						if(isset($wtb_signin_noti_ja[3]))  $noti_3=sanitize_text_field($wtb_signin_noti_ja[3]); else $noti_3 = '';
					}
				break;
			default: //'en'
					$wtb_signin_noti_en = get_option('wtb_signin_noti_en');
					if(isset($wtb_signin_noti_en)) 
					{
						if(isset($wtb_signin_noti_en[0]))  $noti_0=sanitize_text_field($wtb_signin_noti_en[0]); else $noti_0 = '';
						if(isset($wtb_signin_noti_en[1]))  $noti_1=sanitize_text_field($wtb_signin_noti_en[1]); else $noti_1 = '';
						if(isset($wtb_signin_noti_en[2]))  $noti_2=sanitize_text_field($wtb_signin_noti_en[2]); else $noti_2 = '';
						if(isset($wtb_signin_noti_en[3]))  $noti_3=sanitize_text_field($wtb_signin_noti_en[3]); else $noti_3 = '';
					}
				break;
	}
?>
<!--
/*******************************************************************************************
■ [아래 HTML/CSS를 수정 가능]
■ [New design work is possible by modifying the following HTML/CSS]
********************************************************************************************/
-->
<form action="<?php echo get_permalink();?>" method="POST" id="" class="">

<div class="wtbfe-signin-container">
 <?php 
	if(isset($_POST['sin_error']) && $_POST['sin_error']=="yes") { 
		?>
		<div class="wtbfe-signin-noti-box">
			<div class="wtbfe-noti danger">
				<?php echo $noti_0;//_e('Your account information was entered incorrectly.',WTB_TDOM); ?>
				<?php if(isset($_POST['sin_errmsg'])) echo esc_html($_POST['sin_errmsg']); ?>
			</div>
		</div>
		<?php
	}
 ?>
 
 <div class="wtbfe-signin-box">
  <div class="wtbfe-signin-inner">
	<div class="wtbfe-signin-fields-wrapper">
		<?php
			foreach($signin_field_order as $value) {
			  if($value[3]=='on') {
				switch ($value[2]) {
					case 'o_header':
						?>
						<div class="wtbfe-pgtitle-field">	   
							<div class="wtbfe-pgtitle-text"><?php echo esc_html($value[1]);?></div>
						</div>
						<?php
						break;
					case 'o_username':
						?>
						<div class="wtbfe-input-field sin_username">
							<label class="label" for=""><?php echo esc_html($value[1]);?></label>
							<input type="text" name="sin_username" class="sin-input" id="" value="<?php if(isset($_POST ["sin_username"])) echo sanitize_user($_POST ["sin_username"]);?>" placeholder="" required>
						</div>
						<?php
						
						break;
					case 'o_email':
						?>
						<div class="wtbfe-input-field sin_email">
							<label class="label" for=""><?php echo esc_html($value[1]);?></label>
							<input type="email" name="sin_email" class="sin-input" id="" value="<?php if(isset($_POST ["sin_email"])) echo sanitize_email($_POST["sin_email"]);?>" placeholder="" required>
						</div>
						<?php
						break;
					case 'o_unameemail':
						?>
						<div class="wtbfe-input-field sin_unameemail">
							<label class="label" for=""><?php echo esc_html($value[1]);?></label>
							<input type="text" name="sin_unameemail" class="sin-input" id="" value="<?php if(isset($_POST ["sin_unameemail"])) echo sanitize_text_field($_POST ["sin_unameemail"]);?>" placeholder="" required>
						</div>
						<?php
						break;
					case 'o_password':
						?>
						<div class="wtbfe-input-field sin_password">
							<label class="label" for=""><?php echo esc_html($value[1]);?></label>
							<input type="password" name="sin_password" class="sin-input" id="" value="" placeholder="" required>
						</div>
						<?php
						break;
					case 'o_captcha':
						?>
						<div class="wtbfe-input-field sin_captcha">
							<label class="label" for=""><?php //echo esc_html($value[1]);?></label>
							<input type="hidden" name="do" value="contact" class="sin-input">
							<?php
							  $options = array();
							  $options['input_name']             = 'sin_captcha';
							  $options['disable_flash_fallback'] = false;
							  $options['input_text']=$value[1];
							  if (!empty($_POST['ctform']['captcha_error'])) {$options['error_html'] = $_POST['ctform']['captcha_error'];}
							 echo  "<div class='wtbsinup_captcha sin_captcha' id='captcha_container_1'>\n";
							 echo Securimage::getCaptchaHtml($options);
							 echo "\n</div>\n";
							 ?>
						</div>
						<?php
						break;
					case 'o_rememberme':
						?>
						<div class="wtbfe-input-field sin_rememberme">
							<label class="label wtbfe_signin_rememberme" for="rememberme">
								<input name="sin_rememberme" type="checkbox" id="rememberme" class="sin-input" value="on">
								<?php echo esc_html($value[1]);?>
							</label>
						</div>
						<?php
						break;
					case 'o_resetpw':
						?>
						<div class="wtbfe-input-field sin_resetpw">
							<label class="label wtbfe_signin_changepw">
								<input type="hidden" name="sin_resetpw" >
								<input type="hidden" name="action" value="contact_form">
								<a href="?action=lostpassword" >
									<?php echo esc_html($value[1]);?>
								</a>
							</label>
						</div>
						<?php
						break;
					case 'o_separator':
						?>
						<div class="wtbfe-signin-separator"></div>
						<?php
						break;
					case 'o_separatoror':
						?>
						<div class="wtbfe-signin-separator">
							<div class="wtbfe-signin-sep-txt-in-mid"><?php echo esc_html($value[1]);?></div>
						</div>
						<?php
						break;
					case 'o_button':
						?>
						<div class="wtbfe-signin-btn-wrapper">
							<input type="submit" class="wtbfe-signin-button wtbfe-signin-btn-default" value="<?php echo esc_html($value[1]);?>" name="" />
						</div>
						<?php
						break;
					case 'o_google':
						require (WTBSIGN_DIR . "/admin/google-config.php");
						$auth_url = $g_client->createAuthUrl();
						
						?>
						<div class="wtbfe-signin-btn-google">
							<a class="wtbfe-signin-google-alink" href='<?php echo $auth_url;?>'>
							<svg class="wtbfe-google-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
							<span class=""> <?php echo esc_html($value[1]);?> </span>
							</a>
						</div>
						<?php
						break;

					case 'o_facebook':
						require (WTBSIGN_DIR . "/admin/facebook-config.php");
						?>
						<div class="wtbfe-signin-btn-facebook">
							<a class="wtbfe-signin-facebook-alink"  href="<?php echo $loginUrl; ?>" >
							<svg class="wtbfe-facebook-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px"><linearGradient id="Ld6sqrtcxMyckEl6xeDdMa" x1="9.993" x2="40.615" y1="9.993" y2="40.615" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#2aa4f4"/><stop offset="1" stop-color="#007ad9"/></linearGradient><path fill="url(#Ld6sqrtcxMyckEl6xeDdMa)" d="M24,4C12.954,4,4,12.954,4,24s8.954,20,20,20s20-8.954,20-20S35.046,4,24,4z"/><path fill="#fff" d="M26.707,29.301h5.176l0.813-5.258h-5.989v-2.874c0-2.184,0.714-4.121,2.757-4.121h3.283V12.46 c-0.577-0.078-1.797-0.248-4.102-0.248c-4.814,0-7.636,2.542-7.636,8.334v3.498H16.06v5.258h4.948v14.452 C21.988,43.9,22.981,44,24,44c0.921,0,1.82-0.084,2.707-0.204V29.301z"/></svg>
							<span class=""> <?php echo esc_html($value[1]);?> </span>
							</a>
						</div>
						<?php
						break;
					default:
						break;
				}//switch
			  }//if
			}//foreach
		?>
	</div>

  </div>
 </div>
</div>
<input type="hidden" name="form_wtb_signin_submit" value="Sign in">
<input type="hidden" name="sin_error" class="" value="no">
<input type="hidden" name="sin_errmsg" class="" value="">
</form>

