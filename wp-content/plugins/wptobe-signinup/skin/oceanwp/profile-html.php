<?php
	global $current_user;
	$current_user = wp_get_current_user();
	$wtbsinup_lang = get_option( 'wtbsinup_lang' );
	if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {	$lang = $wtbsinup_lang[0]; } else { $lang = 'en_US'; }

	$wtb_profile_fields = get_option( 'wtb_profile_fields' );

	if(isset($wtb_profile_fields)){
		foreach($wtb_profile_fields as $value) {
			switch ($value[2]) {
					case 'o_header':		$v_title=sanitize_text_field($value[1]);break;
					case 'o_account_t':		$v_account_t=sanitize_text_field($value[1]);break;
					case 'o_password_t':	$v_password_t=sanitize_text_field($value[1]);break;
					case 'o_username':		$v_username=sanitize_text_field($value[1]);break;
					case 'o_email':			$v_email=sanitize_text_field($value[1]);break;
					case 'o_name':			$v_displayname=sanitize_text_field($value[1]);break;
					case 'o_role':			$v_role=sanitize_text_field($value[1]);break;
					case 'o_website':		$v_website=sanitize_text_field($value[1]);break;
					case 'o_bioginfo':		$v_bioinfo=sanitize_text_field($value[1]);break;
					case 'o_msince':		$v_msince=sanitize_text_field($value[1]);break;
					case 'o_savebtn':		$v_savebtn=sanitize_text_field($value[1]);break;
					case 'o_chpwhead':		$v_chpwhead=sanitize_text_field($value[1]);break;
					case 'o_curpassword':	$v_curpassword=sanitize_text_field($value[1]);break;
					case 'o_newpassword':	$v_newpassword=sanitize_text_field($value[1]);break;
					case 'o_confpassword':	$v_confpassword=sanitize_text_field($value[1]);break;
					case 'o_chgpwbtn':		$v_chgpwbtn=sanitize_text_field($value[1]);break;
				default:
					break;
			}
		}
	}

	switch ($lang) {
			case 'ko_KR':	
					$wtb_profile_noti_ko = get_option('wtb_profile_noti_ko');
					if(isset($wtb_profile_noti_ko)) 
					{
						$noti_0 = 	sanitize_text_field($wtb_profile_noti_ko[0]);
						$noti_1 = 	sanitize_text_field($wtb_profile_noti_ko[1]);
						$noti_2 = 	sanitize_text_field($wtb_profile_noti_ko[2]);
						$noti_3 = 	sanitize_text_field($wtb_profile_noti_ko[3]);
						$noti_4 = 	sanitize_text_field($wtb_profile_noti_ko[4]);
					}
				break;
			case 'ja':
					$wtb_profile_noti_ja = get_option('wtb_profile_noti_ja');
					if(isset($wtb_profile_noti_ja)) 
					{
						$noti_0 = 	sanitize_text_field($wtb_profile_noti_ja[0]);
						$noti_1 = 	sanitize_text_field($wtb_profile_noti_ja[1]);
						$noti_2 = 	sanitize_text_field($wtb_profile_noti_ja[2]);
						$noti_3 = 	sanitize_text_field($wtb_profile_noti_ja[3]);
						$noti_4 = 	sanitize_text_field($wtb_profile_noti_ja[4]);
					}
				break;
			default: //'en'
					$wtb_profile_noti_en = get_option('wtb_profile_noti_en');
					if(isset($wtb_profile_noti_en)) 
					{
						$noti_0 = 	sanitize_text_field($wtb_profile_noti_en[0]);
						$noti_1 = 	sanitize_text_field($wtb_profile_noti_en[1]);
						$noti_2 = 	sanitize_text_field($wtb_profile_noti_en[2]);
						$noti_3 = 	sanitize_text_field($wtb_profile_noti_en[3]);
						$noti_4 = 	sanitize_text_field($wtb_profile_noti_en[4]);
					}
				break;
	}

	/**
	■ Form submit : User Profile 
	*/	
	if((isset($_POST['form_wtbfe_profile_submit'])) && ($_POST['form_wtbfe_profile_submit']=="Profile Edit")) {
		if ( !is_user_logged_in() ) { return;}
		$PROFILE_UPDATE=TRUE;

		if(isset($_POST['prev_email']) && !empty($_POST['prev_email'])) $P_EMAIL=sanitize_email($_POST['prev_email']); else $P_EMAIL='';
		if(isset($_POST['edit_email']) && !empty($_POST['edit_email'])) $N_EMAIL=sanitize_email($_POST['edit_email']); else $N_EMAIL='';
		if(isset($_POST['user_pid']) && !empty($_POST['user_pid'])) $U_PID=$_POST['user_pid']; else $U_PID=-1;

		if(isset($_POST['user_displayname']) && !empty($_POST['user_displayname'])) $N_DNAME=$_POST['user_displayname']; else $N_DNAME='';
		if(isset($_POST['user_url']) && !empty($_POST['user_url'])) $N_WEBSITE=esc_url($_POST['user_url']); else $N_WEBSITE='';
		if(isset($_POST['user_bioginfo']) && !empty($_POST['user_bioginfo'])) $N_BIOGINFO=$_POST['user_bioginfo']; else $N_BIOGINFO='';

		if(	($U_PID != -1)&&($P_EMAIL != $N_EMAIL)&&(!email_exists( $N_EMAIL ))&&(!empty($N_EMAIL))	)
		{
				$_POST['prof_error']="no";
				wp_update_user( array( 'ID' => $U_PID, 'display_name' => $N_DNAME) );
				wp_update_user( array( 'ID' => $U_PID, 'user_email' => $N_EMAIL) );
				wp_update_user( array( 'ID' => $U_PID, 'user_url' => $N_WEBSITE) );
				wp_update_user( array( 'ID' => $U_PID, 'description' => $N_BIOGINFO) );

				$_POST['prof_savemsg']=$noti_0;//"Your profile has been saved successfully.";
				$PROFILE_UPDATE=TRUE;
		}
		elseif(	($U_PID != -1)&&($P_EMAIL == $N_EMAIL) &&(!empty($N_EMAIL))) 
		{		//이메일은 변화 없으므로 다른 필드만 업데이트
				$_POST['prof_error']="no";
				wp_update_user( array( 'ID' => $U_PID, 'display_name' => $N_DNAME) );
				wp_update_user( array( 'ID' => $U_PID, 'user_url' => $N_WEBSITE) );
				wp_update_user( array( 'ID' => $U_PID, 'description' => $N_BIOGINFO) );
				
				$_POST['prof_savemsg']=$noti_0;//"Your profile has been saved successfully.";
				$PROFILE_UPDATE=TRUE;
		}
		elseif(	($U_PID != -1)&&($P_EMAIL != $N_EMAIL)&&(email_exists( $N_EMAIL ))	)
		{
			// 다른사람이 사용하는 이메일로 변경하려고 시도할 때/바꾸려는 이메일이 다른 사용자가 사용중
			$_POST['prof_error']="yes";
			$_POST['prof_savemsg']=$noti_1;//__("Update failed! Please check your account(E-mail) information.",WTB_TDOM);
			$PROFILE_UPDATE=FALSE;
		}
		else
		{
				$_POST['prof_error']="yes";
				$_POST['prof_savemsg']=$noti_2;//__("Update failed! Please check your account information.",WTB_TDOM);
				$PROFILE_UPDATE=FALSE;	
		}
	}//End if [Submit Profile]

	/**
	■ Form submit : Change Password
	*/	
	if((isset($_POST['form_wtbfe_chgpw_submit'])) && ($_POST['form_wtbfe_chgpw_submit']=="Change PW")) {
		if ( !is_user_logged_in() ) { return;}
		$PW_UPDATE=TRUE;

		if(	isset($_POST['user_pid']) && !empty($_POST['user_pid'])&&
			isset($_POST['current_pw']) && !empty($_POST['current_pw'])&&
			isset($_POST['new_pw']) && !empty($_POST['new_pw'])&&
			isset($_POST['confirm_pw']) && !empty($_POST['confirm_pw']))
		{
			$cuser = get_user_by('id', $_POST['user_pid']);
			//echo "ID:".$_POST['user_pid']."--".$cuser->user_login."<br>";	
			$cpwchk = wp_check_password($_POST['current_pw'], $cuser->user_pass, $cuser->ID);
			
			if($_POST['new_pw'] == $_POST['confirm_pw']) $pwcfm=true; else $pwcfm=false;
			
			if($cpwchk && $pwcfm) 
			{ 
				$_POST['chgpw_savemsg']=$noti_3;//__("Your password changed successfully.",WTB_TDOM);
				$PW_UPDATE=TRUE;
				$_POST['chgpw_error']="no";
				wp_set_password( $_POST['new_pw'], $cuser->ID);
			} 
			else 
			{ 
				$_POST['chgpw_savemsg']=$noti_4;//__("The change password operation failed.",WTB_TDOM);
				$PW_UPDATE=FALSE;
				$_POST['chgpw_error']="yes";
			}
		}
	}//End if [Change Password]
?>
<!--
/*******************************************************************************************
■ [아래 HTML/CSS를 수정 가능]
■ [New design work is possible by modifying the following HTML/CSS]
********************************************************************************************/
-->
<div class="wtb-pf-page-wrapper">
 <div class="wtb-pf-page-max-width">
  <div class="wtb-pf-page-center">
   <div class="wtb-pf-page-ct-wrap">
	<div class="wtb-pfpage-topbar">
		<!-- Part A: Save changes notification -->
		 <?php 
			if((isset($_POST['form_wtbfe_profile_submit'])) && ($_POST['form_wtbfe_profile_submit']=="Profile Edit") && isset($_POST['prof_error']) && $_POST['prof_error']=="yes") 
			{ 
				?>
				<div class="wtbfe-profile-noti-box">
					<div class="wtbfe-noti danger">
						<?php if(isset($_POST['prof_savemsg'])) echo esc_html($_POST['prof_savemsg']); ?>
					</div>
				</div>
				<?php
			}
			else if((isset($_POST['form_wtbfe_profile_submit'])) && ($_POST['form_wtbfe_profile_submit']=="Profile Edit") && isset($_POST['prof_error']) && $_POST['prof_error']=="no")
			{
				?>
				<div class="wtbfe-profile-noti-box">
					<div class="wtbfe-noti info">
						<?php if(isset($_POST['prof_savemsg'])) echo esc_html($_POST['prof_savemsg']); ?>
					</div>
				</div>
				<?php		
			}


			if((isset($_POST['form_wtbfe_chgpw_submit'])) && ($_POST['form_wtbfe_chgpw_submit']=="Change PW") && isset($_POST['chgpw_error']) && $_POST['chgpw_error']=="yes") 
			{ 
				?>
				<div class="wtbfe-profile-noti-box">
					<div class="wtbfe-noti danger">
						<?php if(isset($_POST['chgpw_savemsg'])) echo $_POST['chgpw_savemsg']; ?>
					</div>
				</div>
				<?php
			}
			else if((isset($_POST['form_wtbfe_chgpw_submit'])) && ($_POST['form_wtbfe_chgpw_submit']=="Change PW") &&isset($_POST['chgpw_error']) && $_POST['chgpw_error']=="no")
			{
				?>
				<div class="wtbfe-profile-noti-box">
					<div class="wtbfe-noti info">
						<?php if(isset($_POST['chgpw_savemsg'])) echo esc_html($_POST['chgpw_savemsg']); ?>
					</div>
				</div>
				<?php		
			}
		 ?>	
	</div>

	<span class="wtb-pfpage-col left-col">
		<div class="wtb-pfpage-tab-btn-wrap">
			<div class="wtbfe-tab">
			  <button class="wtbfe-tabbtn active" onclick="wtbfe_selectTab(event, 'TabA')"><?php echo esc_html($v_account_t);?></button>
			  <button class="wtbfe-tabbtn" onclick="wtbfe_selectTab(event, 'TabB')"><?php echo esc_html($v_password_t); ?></button>
			</div>
		</div>
		
	</span>
	<span class="wtb-pfpage-col right-col">
		<div class="wtb-pfpage-tab-content-wrap">
			<div id="TabA" class="wtbfe-tabcontent active">

				<!--Title Row-->
				<div class="wtbfe-pf-box">
					<div class="wtbfe-pf-tab-content-title">
						<?php echo esc_html($v_title); ?>
					</div>
				</div>

				<!-- Form Begin -->
				<form action="" method="post" enctype="multipart/form-data">

					<input type="hidden" name="user_pid" value="<?php echo intval($current_user->ID); ?>">
				
				<!-- Information Block-->
				<div class="wtbfe-pf-body-wrap">
				  <!-- Row: 1-->
				  <div class="wtbfe-pf-body-row">
					<div class="wtbfe-row">
					  <div class="wtbcol-4 wtbfe-pf-left-col">
							 <?php echo esc_html($v_displayname);//_e( 'Display Name', WTB_TDOM);?>
					  </div>
					  <div class="wtbcol-8 wtbfe-pf-right-col">
						<div class="wtbfe-row">
						  <div class="wtbcol-12">
							<input class="wtb-pf-input" type="text" name="user_displayname" value="<?php if(isset($_POST['user_displayname']) && !empty($_POST['user_displayname'])) echo esc_html($_POST['user_displayname']); else echo esc_html($current_user->display_name); ?>" required>
						  </div>
						</div>
					  </div>
					</div>
				  </div>

				  <!--Row:2 -->
				  <div class="wtbfe-pf-body-row">
					<div class="wtbfe-row">
					  <div class="wtbcol-4 wtbfe-pf-left-col">
						<?php echo $v_email;//_e( 'Email ', WTB_TDOM);?>
						<span> * </span>
					  </div>
					  <div class="wtbcol-8 wtbfe-pf-right-col">
						<div class="wtbfe-row">
						  <div class="wtbcol-12">
							<input class="wtb-pf-input" type="email" name ="edit_email" id="edit_email" value="<?php if(isset($_POST['edit_email'])) echo sanitize_email($_POST['edit_email']); else echo sanitize_email($current_user->user_email);?>" required/>
							<input type="hidden" name="prev_email" value="<?php echo sanitize_email($current_user->user_email);?>" />
						  </div>
						</div>
					  </div>
					</div>
				  </div>

				  <!--Row3-->
				  <div class="wtbfe-pf-body-row">
					<div class="wtbfe-row">
					  <div class="wtbcol-4 wtbfe-pf-left-col">
						<?php echo esc_html($v_msince);?>
					  </div>
					  <div class="wtbcol-8 wtbfe-pf-right-col">
						<div class="wtbfe-row">
						  <div class="wtbcol-12">
							<span class="wtbfe-pf-membsince">
								<?php echo date( "F jS, Y", strtotime( $current_user->user_registered ) ); ?>
							</span>
						  </div>

						</div>
					  </div>
					</div>
				  </div>

				  <!-- Row: 4-->
				  <div class="wtbfe-pf-body-row">
					<div class="wtbfe-row">
					  <div class="wtbcol-4 wtbfe-pf-left-col">
							<?php echo esc_html($v_website);?>
					  </div>
					  <div class="wtbcol-8 wtbfe-pf-right-col">
						<div class="wtbfe-row">
						  <div class="wtbcol-12">
							<input class="wtb-pf-input" type="text" name="user_url" value="<?php if(isset($_POST['user_url']) && !empty($_POST['user_url'])) echo esc_url_raw($_POST['user_url']); else echo esc_url_raw($current_user->user_url); ?>">
						  </div>
						</div>
					  </div>
					</div>
				  </div>

				  <!--Row5-->
				  <div class="wtbfe-pf-body-row">
					<div class="wtbfe-row">
					  <div class="wtbcol-4 wtbfe-pf-left-col">
						<?php echo esc_html($v_bioinfo);?>
					  </div>
					  <div class="wtbcol-8 wtbfe-pf-right-col">
						<div class="wtbfe-row">
						  <div class="wtbcol-12">
							<textarea class="wtb-pf-input" name="user_bioginfo"><?php if(isset($_POST['user_bioginfo']) && !empty($_POST['user_bioginfo'])) echo esc_html($_POST['user_bioginfo']); else echo esc_html($current_user->description); ?></textarea>
						  </div>
						</div>
					  </div>
					</div>
				  </div>

				  <!--Row6-->
				  <div class="wtbfe-pf-body-row">
					<div class="wtbfe-row">
					  <div class="wtbcol-4 wtbfe-pf-left-col">
						<div>
							<input class="wtb-pf-submit" class="ws0006-member-profile-save-btn" type="submit" value="<?php echo esc_html($v_savebtn);?>"  />
						</div>
					  </div>
					  <div class="wtbcol-8 wtbfe-pf-right-col">
					  </div>
					</div>
				  </div>
				</div><!-- Information Block End -->
					
					<input type="hidden" name="prof_error" class="" value="no">
					<input type="hidden" name="prof_savemsg" class="" value="">	
					<input type="hidden" name="form_wtbfe_profile_submit" value="Profile Edit">
				</form>
				<!-- Form End -->

			</div>

			<div id="TabB" class="wtbfe-tabcontent">
				<!--Title Row-->
				<div class="wtbfe-pf-box">
					<div class="wtbfe-pf-tab-content-title">
						<?php  echo esc_html($v_chpwhead); ?>
					</div>
				</div>
			
				<!-- Form Begin -->
				<form action="" method="post" enctype="multipart/form-data">

					<input type="hidden" name="user_pid" value="<?php echo intval($current_user->ID);?>">
				
				<!-- Password Block-->
				<div class="wtbfe-pf-body-wrap">
				  <!-- Row: 1-->
				  <div class="wtbfe-pf-body-row">
					<div class="wtbfe-row">
					  <div class="wtbcol-4 wtbfe-pf-left-col">
							<?php echo esc_html($v_curpassword);?>
					  </div>
					  <div class="wtbcol-8 wtbfe-pf-right-col">
						<div class="wtbfe-row">
						  <div class="wtbcol-12">
							<input class="wtb-pf-input" type="password" name="current_pw" required />
						  </div>
						</div>
					  </div>
					</div>
				  </div>

				  <!--Row:2 -->
				  <div class="wtbfe-pf-body-row">
					<div class="wtbfe-row">
					  <div class="wtbcol-4 wtbfe-pf-left-col">
						<?php echo esc_html($v_newpassword);?>
					  </div>
					  <div class="wtbcol-8 wtbfe-pf-right-col">
						<div class="wtbfe-row">
						  <div class="wtbcol-12">
							<input class="wtb-pf-input" type="password" name="new_pw" required/>
						  </div>
						</div>
					  </div>
					</div>
				  </div>

				  <!--Row3-->
				  <div class="wtbfe-pf-body-row">
					<div class="wtbfe-row">
					  <div class="wtbcol-4 wtbfe-pf-left-col">
						<?php echo esc_html($v_confpassword);?>
					  </div>
					  <div class="wtbcol-8 wtbfe-pf-right-col">
						<div class="wtbfe-row">
						  <div class="wtbcol-12">
							<input class="wtb-pf-input" type="password" name="confirm_pw" required/>
						  </div>
						</div>
					  </div>
					</div>
				  </div>

				  <!--Row4-->
				  <div class="wtbfe-pf-body-row">
					<div class="wtbfe-row">
					  <div class="wtbcol-4 wtbfe-pf-left-col">
						<div>
							<input class="wtb-pf-submit" class="ws0006-member-profile-save-btn" type="submit" value="<?php echo esc_html($v_chgpwbtn);//_e('Save Changes',WTB_TDOM); ?>"  />
						</div>
					  </div>
					  <div class="wtbcol-8 wtbfe-pf-right-col">
					  </div>
					</div>
				  </div>

				</div><!-- Change Password Block End -->
					
					<input type="hidden" name="chgpw_error" class="" value="no">
					<input type="hidden" name="chgpw_savemsg" class="" value="">	
					<input type="hidden" name="form_wtbfe_chgpw_submit" value="Change PW">
				</form>
				<!-- Form End -->

			</div><!--wtbfe-tabcontent-->

		</div>
	</span>
	<div class="wtb-clearfix" ></div>
   </div>
  </div>
 </div>
</div>