<style>
    body{background:url(https://shop.ivenet.co.kr/data/skin/responsive_sports_sporti_gl/images/banner/4/images_19.jpg); background-size:cover; background-repeat:no-repeat; background-position:center;}
</style>

<?php
	$signup_field_order = get_option( 'wtb_signup_fields' );
	$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
	$wtbsinup_lang = get_option( 'wtbsinup_lang' );
	if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {	$lang = sanitize_text_field($wtbsinup_lang[0]); } else { $lang = 'en_US'; }

	switch ($lang) {
			case 'ko_KR':	
					$wtb_signup_noti_ko = get_option('wtb_signup_noti_ko');
					if(isset($wtb_signup_noti_ko)) 
					{
						if(isset($wtb_signup_noti_ko[0]))  $noti_0=sanitize_text_field($wtb_signup_noti_ko[0]); else $noti_0 = '';
						if(isset($wtb_signup_noti_ko[1]))  $noti_1=sanitize_text_field($wtb_signup_noti_ko[1]); else $noti_1 = '';
						if(isset($wtb_signup_noti_ko[2]))  $noti_2=sanitize_text_field($wtb_signup_noti_ko[2]); else $noti_2 = '';
						if(isset($wtb_signup_noti_ko[3]))  $noti_3=sanitize_text_field($wtb_signup_noti_ko[3]); else $noti_3 = '';
						if(isset($wtb_signup_noti_ko[4]))  $noti_4=sanitize_text_field($wtb_signup_noti_ko[4]); else $noti_4 = '';
						if(isset($wtb_signup_noti_ko[5]))  $noti_5=sanitize_text_field($wtb_signup_noti_ko[5]); else $noti_5 = '';
						if(isset($wtb_signup_noti_ko[6]))  $noti_6=sanitize_text_field($wtb_signup_noti_ko[6]); else $noti_6 = '';
						if(isset($wtb_signup_noti_ko[7]))  $noti_7=sanitize_text_field($wtb_signup_noti_ko[7]); else $noti_7 = '';
					}
				break;
			case 'ja':
					$wtb_signup_noti_ja = get_option('wtb_signup_noti_ja');
					if(isset($wtb_signup_noti_ja)) 
					{
						if(isset($wtb_signup_noti_ja[0]))  $noti_0=sanitize_text_field($wtb_signup_noti_ja[0]); else $noti_0 = '';
						if(isset($wtb_signup_noti_ja[1]))  $noti_1=sanitize_text_field($wtb_signup_noti_ja[1]); else $noti_1 = '';
						if(isset($wtb_signup_noti_ja[2]))  $noti_2=sanitize_text_field($wtb_signup_noti_ja[2]); else $noti_2 = '';
						if(isset($wtb_signup_noti_ja[3]))  $noti_3=sanitize_text_field($wtb_signup_noti_ja[3]); else $noti_3 = '';
						if(isset($wtb_signup_noti_ja[4]))  $noti_4=sanitize_text_field($wtb_signup_noti_ja[4]); else $noti_4 = '';
						if(isset($wtb_signup_noti_ja[5]))  $noti_5=sanitize_text_field($wtb_signup_noti_ja[5]); else $noti_5 = '';
						if(isset($wtb_signup_noti_ja[6]))  $noti_6=sanitize_text_field($wtb_signup_noti_ja[6]); else $noti_6 = '';
						if(isset($wtb_signup_noti_ja[7]))  $noti_7=sanitize_text_field($wtb_signup_noti_ja[7]); else $noti_7 = '';
					}
				break;
			default: //'en'
					$wtb_signup_noti_en = get_option('wtb_signup_noti_en');
					if(isset($wtb_signup_noti_en)) 
					{
						if(isset($wtb_signup_noti_en[0]))  $noti_0=sanitize_text_field($wtb_signup_noti_en[0]); else $noti_0 = '';
						if(isset($wtb_signup_noti_en[1]))  $noti_1=sanitize_text_field($wtb_signup_noti_en[1]); else $noti_1 = '';
						if(isset($wtb_signup_noti_en[2]))  $noti_2=sanitize_text_field($wtb_signup_noti_en[2]); else $noti_2 = '';
						if(isset($wtb_signup_noti_en[3]))  $noti_3=sanitize_text_field($wtb_signup_noti_en[3]); else $noti_3 = '';
						if(isset($wtb_signup_noti_en[4]))  $noti_4=sanitize_text_field($wtb_signup_noti_en[4]); else $noti_4 = '';
						if(isset($wtb_signup_noti_en[5]))  $noti_5=sanitize_text_field($wtb_signup_noti_en[5]); else $noti_5 = '';
						if(isset($wtb_signup_noti_en[6]))  $noti_6=sanitize_text_field($wtb_signup_noti_en[6]); else $noti_6 = '';
						if(isset($wtb_signup_noti_en[7]))  $noti_7=sanitize_text_field($wtb_signup_noti_en[7]); else $noti_7 = '';
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

<div class="wtbfe-signup-container">
 <!-- Part A: Invalid sign up notification -->
 <?php 
	if(isset($_POST['sup_error']) && $_POST['sup_error']=="no") { 
		?>
		<div class="wtbfe-signup-noti-box">
			<div class="wtbfe-noti info"><?php echo $noti_0;//_e('Your account created successfully.',WTB_TDOM); ?></div>
		</div>
		<?php
	}
	if(isset($_POST['sup_error']) && $_POST['sup_error']=="yes") { 
		?>
		<div class="wtbfe-signup-noti-box">
			<div class="wtbfe-noti danger">
				<?php if(isset($_POST['sup_errmsg'])) echo esc_html($_POST['sup_errmsg']); ?>
			</div>
		</div>
		<?php
	}
 ?>
 
 <!-- Page Title: Sign up --> 
 <div class="wtbfe-signup-pgtitlebox">
	<div class="wtbfe-signup-pgtitle-wrapper">
<?php 
			foreach($signup_field_order as $value) {
			  if($value[3]=='on') {
				switch ($value[2]) {
					case 'o_header':
						?>
						<div class="wtbfe-pgtitle-field">	   
							<!--<div class="wtbfe-pgtitle-text"><?php echo esc_html($value[1]);?></div>-->
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
 
 <!-- Part B: Sign up -->
 <div class="wtbfe-signup-box">
 <div><p style="font-size:26px; margin-top:30px;"><b>회원가입</b>을 시작합니다</p></div>
  <div class="wtbfe-signup-inner">
	<div class="wtbfe-signup-fields-wrapper">
		<?php 
			foreach($signup_field_order as $value) {
			  if($value[3]=='on') {
				switch ($value[2]) {

					case 'o_username':
						?>
						<div class="wtbfe-input-field sup_username">
							<label class="label" for=""><?php echo esc_html($value[1]);?></label>
							<input type="text" name="sup_username" class="sup-input" id="" value="<?php if(isset($_POST ["sup_username"])) echo esc_html($_POST["sup_username"]);?>" placeholder="" required>
						</div>
						<?php
						
						break;
					case 'o_email':
						?>
						<div class="wtbfe-input-field sup_email">
							<label class="label" for=""><?php echo esc_html($value[1]);?></label>
							<input type="email" name="sup_email" class="sup-input" id="" value="<?php if(isset($_POST ["sup_email"])) echo sanitize_email($_POST ["sup_email"]);?>" placeholder="" required>
						</div>
						<?php
						break;

					case 'o_password':
						?>
						<div class="wtbfe-input-field sup_password">
							<label class="label" for=""><?php echo esc_html($value[1]);?></label>
							<input type="password" name="sup_password" class="sup-input" id="" value="" placeholder="" required>
						</div>
						<?php
						break;
					case 'o_confirmpw':
						?>
						<div class="wtbfe-input-field sup_confirmpw">
							<label class="label" for=""><?php echo esc_html($value[1]);?></label>
							<input type="password" name="sup_confirmpw" class="sup-input" id="" value="" placeholder="" required>
						</div>
						<?php
						break;
					case 'o_captcha':
						?>
						<div class="wtbfe-input-field sup_captcha">
							<label class="label" for=""><?php //echo esc_html($value[1]);?></label>
							<input type="hidden" name="do" value="contact">
							<?php
							  $options = array();
							  $options['input_name']             = 'sup_captcha'; 
							  $options['disable_flash_fallback'] = false;
							  $options['input_text']=$value[1];

							 if (!empty($_POST['ctform']['captcha_error'])) { $options['error_html'] = $_POST['ctform']['captcha_error'];}
								
							 echo  "<div class='wtbsinup_captcha sup_captcha' id='captcha_container_1'>\n";
							 echo Securimage::getCaptchaHtml($options);
							 echo "\n</div>\n";
							 ?>
						</div>
						<?php
						break;
					case 'o_separator':
						?>
						<div class="wtbfe-signup-separator"></div>
						<?php
						break;
					case 'o_separatoror':
						?>
						<div class="wtbfe-signup-separator">
							<div class="wtbfe-signup-sep-txt-in-mid"><?php echo esc_html($value[1]);?></div>
						</div>
						<?php
						break;
					case 'o_button':
						?>
						<div class="wtbfe-signup-btn-wrapper">
							<input type="submit" class="wtbfe-signup-button wtbfe-signup-btn-default" value="<?php echo esc_html($value[1]);?>" name="" />
						</div>
						<?php
						break;
					case 'o_signinlink':
						?>
						<div class="wtbfe-input-field sup_signinlink">
							<a href="<?php if ( (isset($wtbsigninup_setopt[0])) && ($wtbsigninup_setopt[0]!=0) ) echo get_permalink($wtbsigninup_setopt[0]); else echo "#";?>"> <?php if(isset($value[1])) echo esc_html($value[1]);?> </a>
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
<input type="hidden" name="form_wtb_signup_submit" value="Sign up">
<input type="hidden" name="sup_error" class="" value="no">
<input type="hidden" name="sup_errmsg" class="" value="">
</form>

