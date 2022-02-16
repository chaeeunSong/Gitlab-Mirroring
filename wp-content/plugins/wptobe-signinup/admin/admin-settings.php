<?php
add_action( 'admin_menu', array( 'WTB_Admin_Init', 'init' ) );
class WTB_Admin_Init
{
    protected static $instance;

    public static function init()
    {
        is_null( self::$instance ) AND self::$instance = new self;
        return self::$instance;
    }

    public function __construct()
    {
		$this->wtb_signinup_admin_setting_menu();
    }

	public function wtb_signinup_admin_setting_menu()
	{
		if (!current_user_can('manage_options'))    {
		  wp_die( __('You do not have sufficient permissions to access this page.',WTB_TDOM) );
		}

		$page = add_menu_page(
							__('Wptobe Signinup', WTB_TDOM),		//	$page_title, 
							__('Wptobe Signinup', WTB_TDOM),		//  $menu_title, 
							'manage_options',						//	$capability, 
							'wtb-signinup',
							array( $this, 'wtbsigninup_admin_menu' ),
							'dashicons-id',							//	$icon_url,
							37.1									//	$position 
		);
	}

	public function wtbsigninup_admin_menu() {
	?>
		<div class="wrap">
			<!-- Print the page title -->
			<h3> <?php echo esc_html( get_admin_page_title() ); ?> </h3>
		</div>

		<div class="row">
		  <div class="small-12 medium-12 large-12">
			<div class="wtb-settings-wrapper">
				<?php $this->wtb_signinup_admin_main(); ?>
			</div>

		  </div>
		</div>

	<?php
	}

	public function wtb_signinup_admin_main()
	{
		?>
		<div class="wrap">
			<?php 
			$this->render_admin_user_interface();
			?>
		</div>
		<?php
		return;
	}

	public function render_admin_user_interface() 
	{ 
		?>
		<div class="metabox-holder">

			<div id="post-body">
				<div id="post-body-content">
				<?php 
					$this->wtb_signinup_select_language();
					$this->wtb_signinup_admin_settings(); 
				?>
				</div>
			</div>
		</div>
		<?php
	}

	public function wtb_signinup_select_language()
	{
		$wtbsinup_lang = get_option( 'wtbsinup_lang' );
		if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {	$_lang = $wtbsinup_lang[0]; }
		else { $_lang = 'en_US'; }

		switch ($_lang) {
					case 'ko_KR':
						$L_selectadesignstyle=__('디자인 스킨: ',WTB_TDOM);
						$L_download_premium=__('프리미엄 버전 다운로드 바로가기[무료]',WTB_TDOM);
						$L_default='Default';
						break;
					case 'ja':
						$L_selectadesignstyle=__('デザインを選択: ',WTB_TDOM);
						$L_download_premium=__('プレミアムバージョンのダウンロード[無料]',WTB_TDOM);
						$L_default='Default';
						break;
					default: //'en'
						$L_selectadesignstyle=__('Design style: ',WTB_TDOM);
						$L_download_premium=__('Premium version download[Free]',WTB_TDOM);
						$L_default='Default';
						break;	
		}// Language (End)
		$skins_dir = array();
		$dir = dir(WTBSIGN_SKIN);

		while (false !== ($entry = $dir->read())) {
			if ($entry != '.' && $entry != '..') {
			   if (is_dir(WTBSIGN_SKIN . '/' .$entry)) {
					$skins_dir[] = $entry; 
			   }
			}
		}
		$wtbsinup_skin = get_option( 'wtbsinup_skin' );
		if( isset($wtbsinup_skin[0]) && !empty($wtbsinup_skin[0]) ) {	$skin_name = $wtbsinup_skin[0]; }
		else { $skin_name = 'default'; }
		?>

		<div class="wtbadm-selelang">
			<span class="wtbadm-slang-title">
				<span class="dashicons dashicons-translation"></span>
			</span>
			
			<span  class="wtbadm-slang-sel">
				<select class="wtbadm-select" id='selectLang'>
					<option value='en_US' <?php if($_lang == 'en_US') echo "selected"; ?> ><?php _e('English',WTB_TDOM); ?></option>
					<option value='ko_KR' <?php if($_lang == 'ko_KR') echo "selected"; ?> ><?php _e('한국어',WTB_TDOM); ?></option>
					<option value='ja' <?php if($_lang == 'ja') echo "selected"; ?> ><?php _e('日本語',WTB_TDOM); ?></option>
				</select>
			</span>

			<span class="wtbadm-skin-sel">
				<span class="wtbadm-slang-title"><?php echo $L_selectadesignstyle; ?></span>
				<select class="wtbadm-select" id='selectSkin'>
					<option value='default' <?php if($skin_name == 'default') echo "selected"; ?> ><?php echo $L_default; ?></option>
					<?php	
					foreach ( $skins_dir as $skin) {
						if($skin!='default')
						{
						?>
							<option value='<?php echo $skin;?>' <?php if($skin_name == $skin) echo "selected"; ?>>
								<?php echo ucfirst($skin); ?>
							</option>
						<?php
						}
					}
					?>
				</select>
			</span>

			<span class="wtbadm-skin-sel">
				<span class="wtbadm-slang-title">
					<a target="_blank" href="http://www.wptobe.com/download">
					<?php echo $L_download_premium; ?>
					</a>
				
				</span>

			</span>
		</div>
		<?php
	}

	public function wtb_signinup_admin_settings()
	{
		// Language (Start)
		$wtbsinup_lang = get_option( 'wtbsinup_lang' );
		if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {$_lang = $wtbsinup_lang[0]; }else { $_lang = 'en_US'; }
		switch ($_lang) {
			case 'ko_KR':
				$L_signin='로그인';
				$L_signup='회원가입';
				$L_profile='프로파일';
				$L_logout='로그아웃';	
				$L_settings='설정';
				$L_shortcode='숏코드';
				$L_woocommerce='우커머스';
				break;
			case 'ja':
				$L_signin='ログイン';
				$L_signup='会員登録';
				$L_profile='プロファイル';
				$L_logout='ログアウト';
				$L_settings='設定';
				$L_shortcode='ショートコード';
				$L_woocommerce='WooCommerce';
				break;
			default: //'en'
				$L_signin='Sign In';
				$L_signup='Sign Up';
				$L_profile='Profile';
				$L_logout='Logout';		
				$L_settings='Settings';
				$L_shortcode='Shortcodes';
				$L_woocommerce='WooCommerce';
				break;	
		}// Language (End)

		$default_tab = 't_signin';
		$tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
		?>
			<div class="wrap wtb-signinup-wrap">

				<!-- Here are our tabs -->
				<nav class="nav-tab-wrapper">
				  <a href="?page=wtb-signinup&tab=t_signin" class="nav-tab <?php if($tab==='t_signin'):?>nav-tab-active<?php endif; ?>"><?php echo $L_signin; ?></a>
				  <a href="?page=wtb-signinup&tab=t_signup" class="nav-tab <?php if($tab==='t_signup'):?>nav-tab-active<?php endif; ?>"><?php echo $L_signup ?></a>
				  <a href="?page=wtb-signinup&tab=t_profile" class="nav-tab <?php if($tab==='t_profile'):?>nav-tab-active<?php endif; ?>"><?php echo $L_profile; ?></a>
				  <a href="?page=wtb-signinup&tab=t_logout" class="nav-tab <?php if($tab==='t_logout'):?>nav-tab-active<?php endif; ?>"><?php echo $L_logout; ?></a> 
				  <a href="?page=wtb-signinup&tab=t_options" class="nav-tab <?php if($tab==='t_options'):?>nav-tab-active<?php endif; ?>"><?php echo $L_settings; ?></a>
				  <!--<a href="?page=wtb-signinup&tab=t_shortcode" class="nav-tab <?php if($tab==='t_shortcode'):?>nav-tab-active<?php endif; ?>"><?php echo $L_shortcode; ?></a>-->
				  <a href="?page=wtb-signinup&tab=t_woocommerce" class="nav-tab <?php if($tab==='t_woocommerce'):?>nav-tab-active<?php endif; ?>"><?php echo $L_woocommerce; ?></a>
				</nav>

				<div class="tab-content">
				<?php switch($tab) :
				  case 't_signin':
					$this->Signin_form_html();
					break;
				  case 't_signup':
					$this->Signup_form_html();
					break;
				  case 't_profile':
					$this->Profile_form_html();
					break;
				  case 't_logout':
					$this->Logout_form_html();
					break;
				  case 't_options':
					$this->Options_form_html();
					break;
				  case 't_shortcode':
					//$this->Shortcodes_info();
					break;
				  case 't_woocommerce':
					$this->WooCommerce_addon_html();
					break;
				  default:
					$this->Signin_form_html();
					break;
				endswitch; ?>
				</div>
			</div>
		<?php
	}

	public function Signin_form_html() {
		$wtb_signin_fields = get_option( 'wtb_signin_fields' );
		if(!is_array($wtb_signin_fields)) 
		{	
			return;
		}

		$wtbsinup_lang = get_option( 'wtbsinup_lang' );
		if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {$_lang = $wtbsinup_lang[0]; }else { $_lang = 'en_US'; }
		switch ($_lang) {
			case 'ko_KR':
				$L_sect_page='로그인 페이지';
				$L_sect_form='로그인 폼';
				$L_selectsigninpage='로그인 페이지 선택';
				$L_dispsigninsc='(로그인 숏코드 출력)';
				$L_beforesignin='로그인 전';
				$L_aftersignin='(로그인 후)';
				$L_redirectto='이동할 페이지';
				$L_select='선택';
				$L_home='홈';
				$L_save='저장';
				$L_google_login='구글 프리미엄 전용[무료]';
				$L_facebook_login='페이스북 프리미엄 전용[무료]';
				break;
			case 'ja':
				$L_sect_page='ログインページ';
				$L_sect_form='ログインフォーム';
				$L_selectsigninpage='ログインページの選択';
				$L_dispsigninsc='(ログインショートコード出力)';
				$L_beforesignin='ログイン前';
				$L_aftersignin='(ログイン後)';
				$L_redirectto='移動';
				$L_select='選択';
				$L_home='ホーム';
				$L_save='セーブ';
				$L_google_login='グーグルプレミアム専用[送料無料]';
				$L_facebook_login='フェイスブックプレミアム専用[送料無料]';
				break;
			default: //'en'
				$L_sect_page='SIGN IN PAGE';
				$L_sect_form='SIGN IN FORM';
				$L_selectsigninpage='Select sign in page';
				$L_dispsigninsc='(Display sign in shortcode)';
				$L_beforesignin='Before sign in';
				$L_aftersignin='(After sign in)';
				$L_redirectto='Redirect to';
				$L_select='Select';
				$L_home='Home';
				$L_save='Save changes';
				$L_google_login='Google Login Preminum only[Free]';
				$L_facebook_login='Facebook Login Preminum only[Free]';
				break;	
		}// Language (End)
	?>

		<div class="postbox">
			<div class="inside">

					<div class="wtbadm-selepage"> 
						<div class="wtbadm-sec-title"><?php echo $L_sect_page; ?></div>

					
					<table class="widefat fixed">
						<thead>
							<!--<tr class="">
								<th class="th-sin-select-title" scope="row" colspan="2"><?php echo $L_selectsigninpage; ?></th>
							</tr>-->
							<tr class="">
								<th class="th-before-login" colspan="1"><?php echo $L_selectsigninpage; ?><span class="th-sin-select-desc"><?php echo $L_dispsigninsc; ?></span></th>
								<th class="th-after-login" colspan="1"><?php echo $L_redirectto; ?>
								<span class="th-sin-select-desc"><?php echo $L_aftersignin; ?></span></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="td-before-login wtb-col-hilight" colspan="1">
									<?php
									$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
									if( isset($wtbsigninup_setopt[0]) && !empty($wtbsigninup_setopt[0]) ) {	$signin_beforePID = $wtbsigninup_setopt[0]; $signinpg_url = esc_url( get_permalink( $signin_beforePID ));}
									else { $signin_beforePID = 0; $signinpg_url = "#";}
									
									if ( $pages = get_pages()) {
										?>
										<select class="wtbadm-select" id='selectPageForSigninBf'>
											<option value='0' <?php if($signin_beforePID == 0) echo "selected"; ?> ><?php echo $L_select; ?></option>
											<?php		
											foreach ( $pages as $page ) {
												?>
													<option value='<?php echo $page->ID;?>' <?php if($signin_beforePID == $page->ID) echo "selected"; ?>>
														<?php if(isset($page->post_title) && !empty($page->post_title)) echo $page->post_title; else _e('(no title)',WTB_TDOM);?>
													</option>
												<?php
											}
											?>
										</select>
										<?php
									}
									// [End-Select]
									?> 
								</td>

								<td class="td-after-login" colspan="1" >
									<?php
									$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
									if( isset($wtbsigninup_setopt[3]) && !empty($wtbsigninup_setopt[3]) ) {	$signin_afterPID = $wtbsigninup_setopt[3]; $signinpg_url = esc_url( get_permalink( $signin_afterPID ));}
									else { $signin_afterPID = 0; $signinpg_url = "#";}
									
									if ( $pages = get_pages()) {
										?>
										<select class="wtbadm-select" id='selectPageForSigninAf'>
											<option value='0' <?php if($signin_afterPID == 0) echo "selected"; ?> ><?php echo $L_home; ?></option>
											<?php		
											foreach ( $pages as $page ) {
												?>
													<option value='<?php echo $page->ID;?>' <?php if($signin_afterPID == $page->ID) echo "selected"; ?>>
														<?php if(isset($page->post_title) && !empty($page->post_title)) echo $page->post_title; else _e('(no title)',WTB_TDOM);?>
													</option>
												<?php
											}
											?>
										</select>
										<?php
									}
									// [End-Select]
									?> 
								
								</td>
							</tr>

						</tbody>
					</table>

					</div>
					<hr class="wtbadm-hr">

					<table class="wtbadm-table" id="wptobefields_sin">
						<div class="wtbadm-sec-title"><?php echo $L_sect_form; ?></div>
						<thead><tr class="head">
							<th scope="col"><?php _e( '',    WTB_TDOM ); ?></th>
							<th scope="col"><?php _e( '',    WTB_TDOM ); ?></th>
						</tr></thead>
						
						<?php  
						for( $row = 0; $row < count($wtb_signin_fields); $row++ ) {?>

						<tr class="wtbadm-field-card wtbadm-sinf-tr<?php echo $wtb_signin_fields[$row][0];?>"  id="<?php echo $wtb_signin_fields[$row][0];?>">

							<td class="wtbadm-fgrid">
							  <div class="wtbadm-fgrid-twrap">
								<?php 
									if(isset($wtb_signin_fields[$row][3])&& !empty($wtb_signin_fields[$row][3])) {
										$chkonoff=$wtb_signin_fields[$row][3];
									}else {
										$chkonoff='off';
									}
									
								?>
								<span class="wtbsinfield-titlebar wtbadm-field-Lsec">
									<div class="wtbadm-dragindicator">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="12 0 12 22"><path d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2s.9-2 2-2s2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2s-2 .9-2 2s.9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2z" fill="#ddd"/></svg>
									</div>
									<div class="wtbadm-chktoggle">
										<label disabled class="wtbadm-togglesw form-check-label" for="sinchk<?php echo $wtb_signin_fields[$row][0];?>">
										  <input type="checkbox" <?php if($wtb_signin_fields[$row][0]=='12'||$wtb_signin_fields[$row][0]=='13') echo "disabled";?> name="wtb_signin_chk" class="chk_show_hide_sin mobileToggle" id="sinchk<?php echo $wtb_signin_fields[$row][0];?>" <?php if($chkonoff=='on') echo 'checked';?> value="<?php echo $wtb_signin_fields[$row][0];?>">
										  <span class="wtbadm-togslider"></span>
										</label>
									</div>

									
									<div class="wtbsinfield-edit">
										<a href="#TB_inline?width=200&height=250&inlineId=modal-sin-id<?php echo $wtb_signin_fields[$row][0];?>" class="thickbox" title="<?php echo ucfirst(substr($wtb_signin_fields[$row][2], 2));?>">
										<span class="dashicons dashicons-edit"></span>
										</a>
									
										<div id="modal-sin-id<?php echo $wtb_signin_fields[$row][0];?>" style="display:none;">
											<input class="wtbadm-edit-input" type="text" name="wtb_signin_chg" id="wtb_signin_chg<?php echo $wtb_signin_fields[$row][0];?>" placeholder="<?php echo $wtb_signin_fields[$row][1];?>">

											<button type="button" class="chg_signinfield_label wtbadm-edit-btn" value="<?php echo $wtb_signin_fields[$row][0];?>"><?php echo $L_save;?></button>
										</div>
									</div>
								</span> 
				
								<?php 
								switch ($wtb_signin_fields[$row][2]) {
									case 'o_header':
										?>
										<span class="wtbadm-field-Rsec">
										<div class="wtbsinfield-previewbar o-header">
											<?php echo $wtb_signin_fields[$row][1];?>
										</div>
										</span>
										<?php
										break;
									case 'o_username':
										?>
										<span class="wtbadm-field-Rsec">
										<div class="wtbsinfield-previewbar o-username">
											<input type="text" name="" class="" id="" value="" placeholder="<?php echo $wtb_signin_fields[$row][1];?>">
										</div>
										</span>
										<?php
										break;
									case 'o_email':
										?>
										<span class="wtbadm-field-Rsec">
										<div class="wtbsinfield-previewbar o-email">
											<input type="text" name="" class="" id="" value="" placeholder="<?php echo $wtb_signin_fields[$row][1];?>">
										</div>
										</span>
										<?php
										break;
									case 'o_unameemail':
										?>
										<span class="wtbadm-field-Rsec">
										<div class="wtbsinfield-previewbar o-unameemail">
											<input type="text" name="" class="" id="" value="" placeholder="<?php echo $wtb_signin_fields[$row][1];?>">
										</div>
										</span>
										<?php
										break;
									case 'o_password':
										?>
										<span class="wtbadm-field-Rsec">
										<div class="wtbsinfield-previewbar o-password">
											<input type="text" name="" class="" id="" value="" placeholder="<?php echo $wtb_signin_fields[$row][1];?>">
										</div>
										</span>
										<?php
										break;
									case 'o_captcha':
										?>
										<span class="wtbadm-field-Rsec">
										<div class="wtbsinfield-previewbar o-captcha">
											<img src='<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'img/captcha.jpg';?>' ></img>
										</div>
										</span>
										<?php
										break;
									case 'o_rememberme':
										?>
										<span class="wtbadm-field-Rsec">
										<div class="wtbsinfield-previewbar o-rememberme">
											<input type="checkbox" >
											<?php echo $wtb_signin_fields[$row][1];?>
										</div>
										</span>
										<?php
										break;
									case 'o_resetpw':
										?>
										<span class="wtbadm-field-Rsec">
										<div class="wtbsinfield-previewbar o-resetpw">
											<?php echo $wtb_signin_fields[$row][1];?>
										</div>
										</span>
										<?php
										break;
									case 'o_separator':
										?>
										<span class="wtbadm-field-Rsec">
										<div class="wtbsinfield-previewbar o-separator">
											<hr/>
										</div>
										</span>
										<?php
										break;
									case 'o_separatoror':
										?>
										<span class="wtbadm-field-Rsec">
										<div class="wtbsinfield-previewbar o-separator">
											<hr/>
											<?php echo $wtb_signin_fields[$row][1];?>
										</div>
										</span>
										<?php
										break;
									case 'o_button':
										?>
										<span class="wtbadm-field-Rsec">
										<div class="wtbsinfield-previewbar o-button">
											<button><?php echo $wtb_signin_fields[$row][1];?></button>
										</div>
										</span>
										<?php
										break;
									case 'o_google':
										?>
										<span class="wtbadm-field-Rsec">
										<div class="wtbsinfield-previewbar o-button">
											<button><?php echo $L_google_login;?></button>
										</div>
										</span>
										<?php
										break;
									case 'o_facebook':
										?>
										<span class="wtbadm-field-Rsec">
										<div class="wtbsinfield-previewbar o-button">
											<button><?php echo $L_facebook_login;?></button>
										</div>
										</span>
										<?php
										break;										
									case 'o_signuplink':
										?>
										<span class="wtbadm-field-Rsec">
										<div class="wtbsinfield-previewbar o-signuplink">
											<?php echo $wtb_signin_fields[$row][1];?>
										</div>
										</span>
										<?php
										break;										
									default:
										break;
								}
								?>
							  </div>
							</td>
						</tr>

						<?php } ?>

					</table>
					
					<?php 
						$this->Resetpw_form_html();
					?>
			</div>
		</div>	


		<script>
			 
			jQuery(document).ready(function($) {
				// [Before Login]Signin 숏코드를 출력할 페이지를 선택
				$("#selectPageForSigninBf").change(function(){
					var selectedPage =  $(this).val();
					//alert(selectedPage);

					var data = {
						'action': 'act_select_signin_sc_page_bf',
						'sin_scpid': selectedPage,
						'security': '<?php echo wp_create_nonce("select_signin_shortcode_page_bf"); ?>' 
					};

					$.post(ajaxurl, data, function(response) {
					});
				});
				// [After Login]Signin 숏코드를 출력할 페이지를 선택
				$("#selectPageForSigninAf").change(function(){
					var selectedPage =  $(this).val();
					var data = {
						'action': 'act_select_signin_sc_page_af',
						'sin_scpid': selectedPage,
						'security': '<?php echo wp_create_nonce("select_signin_shortcode_page_af"); ?>' 
					};

					$.post(ajaxurl, data, function(response) {
					});
				});

				$('.chk_show_hide_sin').on({

					change: function () { 
						var field_id = $(this).val();
						if(this.checked) { 
							var chk_display = "on";
						}
						else { 
							var chk_display = "off";
						}
						var data = {
							'action': 'act_chg_signin_page_fields',
							'sin_id': field_id,
							'sin_display': chk_display,
							'security': '<?php echo wp_create_nonce("chg_signin_fields_shownhide"); ?>' 
						};

						$.post(ajaxurl, data, function(response) {
						});
					}
				});

				$('.chg_signinfield_label').on({
					click: function () { 
						self.parent.tb_remove(); 
						var field_id = $(this).val();
						var el_id = "wtb_signin_chg"+field_id;
						var changed_val = document.getElementById(el_id).value;
						var data = {
							'action': 'act_chg_signin_fields_label',
							'sin_id': field_id,
							'sin_val': changed_val,
							'security': '<?php echo wp_create_nonce("chg_signin_fields_edit"); ?>' 
						};

						$.post(ajaxurl, data, function(response) {
							location.reload(); 
						});
					}
				});
			});

		</script>
		<?php	
	}

	public function Signup_form_html() 
	{
		$wtb_signup_fields = get_option( 'wtb_signup_fields' );
		$wtbsinup_lang = get_option( 'wtbsinup_lang' );
		if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {$_lang = $wtbsinup_lang[0]; }else { $_lang = 'en_US'; }
		switch ($_lang) {
			case 'ko_KR':
				$L_sect_page='회원가입 페이지';
				$L_sect_form='회원가입 폼';
				$L_selectsignuppage='회원가입 페이지 선택';
				$L_dispsignupsc='(회원가입 숏코드 출력)';
				$L_beforesignup='회원가입 전';
				$L_aftersignup='(회원가입 후)';
				$L_redirectto='이동할 페이지';
				$L_select='선택';
				$L_home='홈';
				$L_savebtn='저장';
				break;
			case 'ja':
				$L_sect_page='会員登録ページ';
				$L_sect_form='会員登録フォーム';
				$L_selectsignuppage='会員登録ページの選択';
				$L_dispsignupsc='(会員登録ショートコード出力)';
				$L_beforesignup='会員登録前';
				$L_aftersignup='(会員登録後)';
				$L_redirectto='移動';
				$L_select='選択する';
				$L_home='ホーム';
				$L_savebtn='セーブ';
				break;
			default: //'en'
				$L_sect_page='SIGN UP PAGE';
				$L_sect_form='SIGN UP FORM';
				$L_selectsignuppage='Select sign up page';
				$L_dispsignupsc='(Display sign up shortcode)';
				$L_beforesignup='Before sign up';
				$L_aftersignup='(After sign up)';
				$L_redirectto='Redirect to';
				$L_select='Select';
				$L_home='Home';
				$L_savebtn='Save';
				break;	
		}// Language (End)
	?>
		<div class="postbox">
			<div class="inside">

					<div class="wtbadm-selepage"> 
						<div class="wtbadm-sec-title"><?php echo $L_sect_page; ?></div>
	
					<table class="widefat fixed">
						<thead>
							<!--<tr class="">
								<th class="th-sin-select-title" scope="row" colspan="2"><?php echo $L_selectsignuppage; ?></th>
							</tr>-->
							<tr class="">
								<th class="th-before-login" colspan="1"><?php echo $L_selectsignuppage; ?><span class="th-sin-select-desc"><?php echo $L_dispsignupsc; ?></span></th>
								<th class="th-after-login" colspan="1"><?php echo $L_redirectto; ?><span class="th-sin-select-desc"><?php echo $L_aftersignup; ?></span></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="td-before-login wtb-col-hilight" colspan="1">
									<?php
									$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
									if( isset($wtbsigninup_setopt[1]) && !empty($wtbsigninup_setopt[1]) ) {	$signup_beforePID = $wtbsigninup_setopt[1]; $signuppgbf_url = esc_url( get_permalink( $signup_beforePID ));}
									else { $signup_beforePID = 0; $signuppgbf_url = "#";}
									
									if ( $pages = get_pages()) {
										?>
										<select class="wtbadm-select" id='selectPageForSignupBf'>
											<option value='0' <?php if($signup_beforePID == 0) echo "selected"; ?> ><?php echo $L_select; ?></option>
											<?php
											foreach ( $pages as $page ) {
												?>
													<option value='<?php echo $page->ID;?>' <?php if($signup_beforePID == $page->ID) echo "selected"; ?>>
														<?php if(isset($page->post_title) && !empty($page->post_title)) echo $page->post_title; else _e('(no title)',WTB_TDOM);?>
													</option>
												<?php
											}
											?>
										</select>
										<?php
									}
									?> 
								</td>

								<td class="td-after-login" colspan="1" >
									<?php
									$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
									if( isset($wtbsigninup_setopt[4]) && !empty($wtbsigninup_setopt[4]) ) {	$signup_afterPID = $wtbsigninup_setopt[4]; $signuppgaf_url = esc_url( get_permalink( $signup_afterPID ));}
									else { $signup_afterPID = 0; $signuppgaf_url = "#";}
									
									if ( $pages = get_pages()) {
										?>
										<select class="wtbadm-select" id='selectPageForSignupAf'>
											<option value='0' <?php if($signup_afterPID == 0) echo "selected"; ?> ><?php echo $L_select; ?></option>
											<?php		
											foreach ( $pages as $page ) {
												?>
													<option value='<?php echo $page->ID;?>' <?php if($signup_afterPID == $page->ID) echo "selected"; ?>>
														<?php if(isset($page->post_title) && !empty($page->post_title)) echo $page->post_title; else _e('(no title)',WTB_TDOM);?>
													</option>
												<?php
											}
											?>
										</select>
										<?php
									}
									?> 
								
								</td>
							</tr>

						</tbody>
					</table>
					</div>
					<hr class="wtbadm-hr">

					<table class="wtbadm-table" id="wptobefields_sup">
						<div class="wtbadm-sec-title"><?php echo $L_sect_form; ?></div>
						<thead><tr class="head">
							<th scope="col"><?php _e( '',    WTB_TDOM ); ?></th>
							<th scope="col"><?php _e( '',    WTB_TDOM ); ?></th>
						</tr></thead>
						
						<?php 
						for( $row = 0; $row < count($wtb_signup_fields); $row++ ) {?>

						<tr class="wtbadm-field-card wtbadm-supf-tr<?php echo $wtb_signup_fields[$row][0];?>"  id="<?php echo $wtb_signup_fields[$row][0];?>">

							<td class="wtbadm-fgrid">
							  <div class="wtbadm-fgrid-twrap">
								<?php 
									if(isset($wtb_signup_fields[$row][3])&& !empty($wtb_signup_fields[$row][3])) {
										$chkonoff=$wtb_signup_fields[$row][3];
									}else {
										$chkonoff='off';
									}
								?>
								<div class="wtbsinfield-titlebar">
									<div class="wtbadm-dragindicator">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="12 0 12 22"><path d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2s.9-2 2-2s2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2s-2 .9-2 2s.9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2z" fill="#ddd"/></svg>
									</div>
									<div class="wtbadm-chktoggle">
										<label class="wtbadm-togglesw form-check-label" for="supchk<?php echo $wtb_signup_fields[$row][0];?>">
										  <input type="checkbox" name="wtb_signin_chk" class="chk_show_hide_sup mobileToggle"id="supchk<?php echo $wtb_signup_fields[$row][0];?>" <?php if($chkonoff=='on') echo 'checked';?> value="<?php echo $wtb_signup_fields[$row][0];?>" <?php if(($wtb_signup_fields[$row][2]=='o_email')||($wtb_signup_fields[$row][2]=='o_username')||($wtb_signup_fields[$row][2]=='o_password')) echo 'disabled'; ?>>
										  <span class="wtbadm-togslider"></span>
										</label>
									</div>
									<span class="wtbsinfield-edit">
										<a href="#TB_inline?width=400&height=250&inlineId=modal-sup-id<?php echo $wtb_signup_fields[$row][0];?>" class="thickbox" title="<?php echo ucfirst(substr($wtb_signup_fields[$row][2], 2));?>">
										<span class="dashicons dashicons-edit"></span>
										</a>
										<div class="wtbadm-edit-popup" id="modal-sup-id<?php echo $wtb_signup_fields[$row][0];?>" style="display:none;">
											<input class="wtbadm-edit-input" type="text" name="wtb_signup_chg" id="wtb_signup_chg<?php echo $wtb_signup_fields[$row][0];?>" placeholder="<?php echo $wtb_signup_fields[$row][1];?>">

											<button type="button" class="chg_signupfield_label wtbadm-edit-btn" value="<?php echo $wtb_signup_fields[$row][0];?>"><?php echo $L_savebtn; ?></button>
										</div>
									</span>
								</div> 
								<?php 
								switch ($wtb_signup_fields[$row][2]) {
									case 'o_header':
										?>
										<div class="wtbsupfield-previewbar o-header">
											<?php echo $wtb_signup_fields[$row][1];?>
										</div>
										<?php
										break;
									case 'o_username':
										?>
										<div class="wtbsupfield-previewbar o-username">
											<input type="text" name="" class="" id="" value="" placeholder="<?php echo $wtb_signup_fields[$row][1];?>">
										</div>
										<?php
										break;
									case 'o_email':
										?>
										<div class="wtbsupfield-previewbar o-email">
											<input type="text" name="" class="" id="" value="" placeholder="<?php echo $wtb_signup_fields[$row][1];?>">
										</div>
										<?php
										break;
									case 'o_password':
										?>
										<div class="wtbsupfield-previewbar o-password">
											<input type="text" name="" class="" id="" value="" placeholder="<?php echo $wtb_signup_fields[$row][1];?>">
										</div>
										<?php
										break;
									case 'o_confirmpw':
										?>
										<div class="wtbsupfield-previewbar o-confirmpw">
											<input type="text" name="" class="" id="" value="" placeholder="<?php echo $wtb_signup_fields[$row][1];?>">
										</div>
										<?php
										break;
									case 'o_captcha':
										?>
										<div class="wtbsupfield-previewbar o-captcha">
											<img src='<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'img/captcha.jpg';?>' ></img>
										</div>
										<?php
										break;
									case 'o_separator':
										?>
										<div class="wtbsupfield-previewbar o-separator">
											<hr/>
										</div>
										<?php
										break;
									case 'o_separatoror':
										?>
										<div class="wtbsupfield-previewbar o-separator">
											<hr/>
											<?php echo $wtb_signup_fields[$row][1];?>
										</div>
										<?php
										break;
									case 'o_button':
										?>
										<div class="wtbsupfield-previewbar o-button">
											<button><?php echo $wtb_signup_fields[$row][1];?></button>
										</div>
										<?php
										break;
									case 'o_signinlink':
										?>
										<div class="wtbsupfield-previewbar o-signinlink">
											<?php echo $wtb_signup_fields[$row][1];?>
										</div>
										<?php
										break;											
									default:
										break;
								}
								?>
							  </div>
							</td>
						</tr>
						<?php } ?>
					</table>
			</div>
		</div>	

		<script>
			jQuery(document).ready(function($) {
				// Signup 숏코드를 출력할 페이지를 선택 (Before Sign up)
				$("#selectPageForSignupBf").change(function(){
					var selectedPage =  $(this).val();
					var data = {
						'action': 'act_select_signup_sc_page_bf',
						'sup_scpid': selectedPage,
						'security': '<?php echo wp_create_nonce("select_signup_shortcode_page_bf"); ?>' 
					};
					$.post(ajaxurl, data, function(response) {
					});
				});
				// Signup 숏코드를 출력할 페이지를 선택 (After Sign up)
				$("#selectPageForSignupAf").change(function(){
					var selectedPage =  $(this).val();
					var data = {
						'action': 'act_select_signup_sc_page_af',
						'sup_scpid': selectedPage,
						'security': '<?php echo wp_create_nonce("select_signup_shortcode_page_af"); ?>' 
					};
					$.post(ajaxurl, data, function(response) {
					});
				});

				$('.chk_show_hide_sup').on({
					change: function () { 
						var field_id = $(this).val();
						if(this.checked) { 
							var chk_display = "on";
						}
						else { 
							var chk_display = "off";
						}
						var data = {
							'action': 'act_chg_signup_page_fields',
							'sup_id': field_id,
							'sup_display': chk_display,
							'security': '<?php echo wp_create_nonce("chg_signup_fields_shownhide"); ?>' 
						};
						$.post(ajaxurl, data, function(response) {
						});
					}
				});

				// 사인업 필드 레이블을 수정 클래스 on click 발생 
				$('.chg_signupfield_label').on({
					click: function () { 
						self.parent.tb_remove();
						var field_id = $(this).val();
						var el_id = "wtb_signup_chg"+field_id;
						var changed_val = document.getElementById(el_id).value;
						var data = {
							'action': 'act_chg_signup_fields_label',
							'sup_id': field_id,
							'sup_val': changed_val,
							'security': '<?php echo wp_create_nonce("chg_signup_fields_edit"); ?>' 
						};
						$.post(ajaxurl, data, function(response) {
							location.reload(); 
						});
					}
				});
			});
		</script>
		<?php	
	}

	public function Resetpw_form_html() 
	{
		$wtb_resetpw_fields = get_option( 'wtb_resetpw_fields' );
		$wtbsinup_lang = get_option( 'wtbsinup_lang' );
		if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {$_lang = $wtbsinup_lang[0]; }else { $_lang = 'en_US'; }
		switch ($_lang) {
			case 'ko_KR':
				$L_savebtn='저장';
				break;
			case 'ja':
				$L_savebtn='セーブ';
				break;
			default: //'en'
				$L_savebtn='Save';
				break;	
		}// Language (End)
		?>
					<table class="wtbadm-table" id="wptobefields_rpw">
						
						<thead><tr class="head">
							<th scope="col"><?php _e( '',    WTB_TDOM ); ?></th>
							<th scope="col"><?php _e( '',    WTB_TDOM ); ?></th>
						</tr></thead>
						
						<?php 
						for( $row = 0; $row < count($wtb_resetpw_fields); $row++ ) {?>

						<tr class="wtbadm-field-card wtbadm-rpwf-tr<?php echo $wtb_resetpw_fields[$row][0];?>"  id="<?php echo $wtb_resetpw_fields[$row][0];?>">

							<td class="wtbadm-fgrid">
							  <div class="wtbadm-fgrid-twrap">
								<?php 
									if(isset($wtb_resetpw_fields[$row][3])&& !empty($wtb_resetpw_fields[$row][3])) {
										$chkonoff=$wtb_resetpw_fields[$row][3];
									}else {
										$chkonoff='off';
									}
								?>
								<div class="wtbsinfield-titlebar">
									<div class="wtbadm-dragindicator">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="12 0 12 22"><path d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2s.9-2 2-2s2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2s-2 .9-2 2s.9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2z" fill="#ddd"/></svg>
									</div>
									<div class="wtbadm-chktoggle">
										<label class="wtbadm-togglesw form-check-label" for="rpwchk<?php echo $wtb_resetpw_fields[$row][0];?>">
										  <input type="checkbox" name="wtb_signin_chk" class="chk_show_hide_rpw mobileToggle" id="rpwchk<?php echo $wtb_resetpw_fields[$row][0];?>" <?php if($chkonoff=='on') echo 'checked';?> value="<?php echo $wtb_resetpw_fields[$row][0];?>">
										  <span class="wtbadm-togslider"></span>
										</label>
									</div>

									<span class="wtbsinfield-edit">
										<a href="#TB_inline?width=400&height=250&inlineId=modal-rpw-id<?php echo $wtb_resetpw_fields[$row][0];?>" class="thickbox" title="<?php echo ucfirst(substr($wtb_resetpw_fields[$row][2], 2));?>">
										<span class="dashicons dashicons-edit"></span>
										</a>

										<div id="modal-rpw-id<?php echo $wtb_resetpw_fields[$row][0];?>" style="display:none;">
											<input type="text" name="wtb_resetpw_chg" class="wtbadm-edit-input" id="wtb_resetpw_chg<?php echo $wtb_resetpw_fields[$row][0];?>" placeholder="<?php echo $wtb_resetpw_fields[$row][1];?>">

											<button type="button" class="chg_resetpwfield_label wtbadm-edit-btn" value="<?php echo $wtb_resetpw_fields[$row][0];?>"><?php echo $L_savebtn; ?></button>

										</div>
									</span>
								</div> 
								
								<?php 
								switch ($wtb_resetpw_fields[$row][2]) {
									case 'o_header':
										?>
										<div class="wtbsupfield-previewbar o-header">
											<?php echo $wtb_resetpw_fields[$row][1];?>
										</div>
										<?php
										break;
									case 'o_desc':
										?>
										<div class="wtbsupfield-previewbar o-username o-desc">
											<input type="text" name="" class="" id="" value="" placeholder="<?php echo $wtb_resetpw_fields[$row][1];?>">
										</div>
										<?php
										break;
									case 'o_unameemail':
										?>
										<div class="wtbsupfield-previewbar o-email o_unameemail">
											<input type="text" name="" class="" id="" value="" placeholder="<?php echo $wtb_resetpw_fields[$row][1];?>">
										</div>
										<?php
										break;
									case 'o_button':
										?>
										<div class="wtbsupfield-previewbar o-button">
											<button><?php echo $wtb_resetpw_fields[$row][1];?></button>
										</div>
										<?php
										break;
									case 'o_separator':
										?>
										<div class="wtbsupfield-previewbar o-separator">
											<hr/>
										</div>
										<?php
										break;
									case 'o_backtosin':
										?>
										<div class="wtbsupfield-previewbar o-password">
											<input type="text" name="" class="" id="" value="" placeholder="<?php echo $wtb_resetpw_fields[$row][1];?>">
										</div>
										<?php
										break;
									default:
										break;
								}
								?>
							  </div>
							</td>
						</tr>
						<?php } ?>
					</table>

					<script>
						jQuery(document).ready(function($) {

							$('.chk_show_hide_rpw').on({
								change: function () { 
									var field_id = $(this).val();
									if(this.checked) { 
										var chk_display = "on";
									}
									else { 
										var chk_display = "off";
									}
									var data = {
										'action': 'act_chg_resetpw_page_fields',
										'rpw_id': field_id,
										'rpw_display': chk_display,
										'security': '<?php echo wp_create_nonce("chg_resetpw_fields_shownhide"); ?>' 
									};
									$.post(ajaxurl, data, function(response) {
									});
								}
							});

							$('.chg_resetpwfield_label').on({
								click: function () { 
									self.parent.tb_remove();
									var field_id = $(this).val();
									var el_id = "wtb_resetpw_chg"+field_id;
									var changed_val = document.getElementById(el_id).value;
									var data = {
										'action': 'act_chg_resetpw_fields_label',
										'rpw_id': field_id,
										'rpw_val': changed_val,
										'security': '<?php echo wp_create_nonce("chg_resetpw_fields_edit"); ?>' 
									};
									$.post(ajaxurl, data, function(response) {
										location.reload(); 
									});
								}
							});
						});
					</script>
		<?php	
	}

	public function Profile_form_html() 
	{	
		$wtb_profile_fields = get_option( 'wtb_profile_fields' );
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
		$wtbsinup_lang = get_option( 'wtbsinup_lang' );
		if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {$_lang = $wtbsinup_lang[0]; }else { $_lang = 'en_US'; }
		switch ($_lang) {
			case 'ko_KR':
				$L_sect_page='프로파일 페이지';
				$L_sect_form='프로파일 폼';
				$L_selectprofilepage='프로파일 페이지 선택';
				$L_dispprofilesc='(프로파일 숏코드 출력)';
				$L_beforesignin='(로그인 전)';
				$L_aftersignin='(로그인 후)';
				$L_redirectto='이동할 페이지';
				$L_select='선택';
				$L_home='홈';
				break;
			case 'ja':
				$L_sect_page='自己紹介ページ';
				$L_sect_form='プロフィールフォーム';
				$L_selectprofilepage='プロファイルページの選択';
				$L_dispprofilesc='(プロファイルショートコード出力)';
				$L_beforesignin='(ログイン前)';
				$L_aftersignin='(ログイン後)';
				$L_redirectto='移動';
				$L_select='選択';
				$L_home='ホーム';
				break;
			default: //'en'
				$L_sect_page='PROFILE PAGE';
				$L_sect_form='PROFILE FORM';
				$L_selectprofilepage='Select profile page';
				$L_dispprofilesc='(Display profile shortcode)';
				$L_beforesignin='(Before sign in)';
				$L_aftersignin='(After sign in)';
				$L_redirectto='Redirect to';
				$L_select='Select';
				$L_home='Home';
				break;	
		}// Language (End)
		?>
		<div class="postbox">
			<div class="inside">

					<div class="wtbadm-selepage"> 
						<div class="wtbadm-sec-title"><?php echo $L_sect_page; ?></div>

					<table class="widefat fixed">
						<thead>
							<!--<tr class="">
								<th class="th-sin-select-title" scope="row" colspan="2"><?php echo $L_selectprofilepage; ?></th>
							</tr>-->
							<tr class="">
								<th class="th-before-login" colspan="1"><?php echo $L_selectprofilepage; ?><span class="th-sin-select-desc"><?php echo $L_dispprofilesc; ?></span></th>
								<th class="th-after-login" colspan="1"><?php echo $L_redirectto; ?><span class="th-sin-select-desc"><?php echo $L_beforesignin; ?></span></th>
							</tr>

						</thead>
						<tbody>
							<tr>
								<td class="td-before-login wtb-col-hilight" colspan="1">
 									<?php
									$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
									if( isset($wtbsigninup_setopt[5]) && !empty($wtbsigninup_setopt[5]) ) {	$profile_afterPID = $wtbsigninup_setopt[5]; $profilepgaf_url = esc_url( get_permalink( $profile_afterPID ));}
									else { $profile_afterPID = 0; $profilepgaf_url = "#";}
									
									if ( $pages = get_pages()) {
										?>
										<select class="wtbadm-select" id='selectPageForProfileAf'>
											<option value='0' <?php if($profile_afterPID == 0) echo "selected"; ?> ><?php echo $L_select; ?></option>
											<?php		
											foreach ( $pages as $page ) {
												?>
													<option value='<?php echo $page->ID;?>' <?php if($profile_afterPID == $page->ID) echo "selected"; ?>>
														<?php if(isset($page->post_title) && !empty($page->post_title)) echo $page->post_title; else _e('(no title)',WTB_TDOM);?>
													</option>
												<?php
											}
											?>
										</select>
										<?php
									}
									?> 
									
								</td>

								<td class="td-after-login" colspan="1" >
									<?php
									if( isset($wtbsigninup_setopt[2]) && !empty($wtbsigninup_setopt[2]) ) {	$profile_beforePID = $wtbsigninup_setopt[2]; $profilepgbf_url = esc_url( get_permalink( $profile_beforePID ));}
									else { $profile_beforePID = 0; $profilepgbf_url = "#";}
									
									if ( $pages = get_pages()) {
										?>
										<select class="wtbadm-select" id='selectPageForProfileBf'>
											<option value='0' <?php if($profile_beforePID == 0) echo "selected"; ?> ><?php echo $L_select; ?></option>
											<?php		
											foreach ( $pages as $page ) {
												?>
													<option value='<?php echo $page->ID;?>' <?php if($profile_beforePID == $page->ID) echo "selected"; ?>>
														<?php if(isset($page->post_title) && !empty($page->post_title)) echo $page->post_title; else _e('(no title)',WTB_TDOM);?>
													</option>
												<?php
											}
											?>
										</select>
										<?php
									}
									?>
								</td>
							</tr>

						</tbody>
					</table>
					</div>
			</div>
		</div>

		<script>
			jQuery(document).ready(function($) {
				$("#selectPageForProfileBf").change(function(){
					var selectedPage =  $(this).val();
					var data = {
						'action': 'act_select_profile_sc_page_bf',
						'sup_scpid': selectedPage,
						'security': '<?php echo wp_create_nonce("select_profile_shortcode_page_bf"); ?>' 
					};
					$.post(ajaxurl, data, function(response) {
					});
				});

				$("#selectPageForProfileAf").change(function(){
					var selectedPage =  $(this).val();
					var data = {
						'action': 'act_select_profile_sc_page_af',
						'sup_scpid': selectedPage,
						'security': '<?php echo wp_create_nonce("select_profile_shortcode_page_af"); ?>' 
					};

					$.post(ajaxurl, data, function(response) {
					});
				});
			});
		</script>
		<?php
	}

	public function Logout_form_html() {
		
		$wtbsinup_lang = get_option( 'wtbsinup_lang' );
		if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {$_lang = $wtbsinup_lang[0]; }else { $_lang = 'en_US'; }
		switch ($_lang) {
			case 'ko_KR':
				$L_sect_page='로그아웃 페이지';
				$L_afterlogout='(로그아웃 후)';
				$L_redirectto='이동할 페이지';
				$L_select='선택';
				$L_home='홈';

				break;
			case 'ja':
				$L_sect_page='ログアウトページ';
				$L_afterlogout='(ログアウト後)';
				$L_redirectto='移動';
				$L_select='選択';
				$L_home='ホーム';
				break;
			default: //'en'
				$L_sect_page='LOG OUT PAGE';
				$L_afterlogout='(After Logout)';
				$L_redirectto='Redirect to';
				$L_select='Select';
				$L_home='Home';
				break;	
		}// Language (End)
		?>

		<div class="postbox">
			<div class="inside">

					<div class="wtbadm-selepage"> 
						<div class="wtbadm-sec-title"><?php echo $L_sect_page; ?></div>

					<table class="widefat fixed">
						<thead>
							<tr class="">
								<th class="th-before-login" colspan="1"><?php echo $L_redirectto; ?>
								<span class="th-sin-select-desc"><?php echo $L_afterlogout; ?></span></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="td-before-login wtb-col-hilight" colspan="1" >
									<?php
									$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
									if( isset($wtbsigninup_setopt[6]) && !empty($wtbsigninup_setopt[6]) ) {	$logout_afterPID = $wtbsigninup_setopt[6]; $logoutpg_url = esc_url( get_permalink( $logout_afterPID ));}
									else { $logout_afterPID = 0; $logoutpg_url = "#";}
									
									if ( $pages = get_pages()) {
										?>
										<select class="wtbadm-select" id='selectPageForLogoutAf'>
											<option value='0' <?php if($logout_afterPID == 0) echo "selected"; ?> ><?php echo $L_home; ?></option>
											<?php		
											foreach ( $pages as $page ) {
												?>
													<option value='<?php echo $page->ID;?>' <?php if($logout_afterPID == $page->ID) echo "selected"; ?>>
														<?php if(isset($page->post_title) && !empty($page->post_title)) echo $page->post_title; else _e('(no title)',WTB_TDOM);?>
													</option>
												<?php
											}
											?>
										</select>
										<?php
									}
									// [End-Select]
									?> 
								
								</td>
								<td class="td-after-login" colspan="1" ></td>
							</tr>

						</tbody>
					</table>
			
			</div>
		</div>

		<script>
			jQuery(document).ready(function($) {
				// [After Logout] 로그아웃 후 리다이렉트할 페이지를 선택
				$("#selectPageForLogoutAf").change(function(){
					var selectedPage =  $(this).val();
					var data = {
						'action': 'act_select_logout_sc_page_af',
						'logout_scpid': selectedPage,
						'security': '<?php echo wp_create_nonce("select_logout_shortcode_page_af"); ?>' 
					};

					$.post(ajaxurl, data, function(response) {

					});
				});

			});

		</script>
		<?php
	}

	public function Options_form_html() 
	{
		$wtbsinup_lang = get_option( 'wtbsinup_lang' );
		if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {$_lang = $wtbsinup_lang[0]; }else { $_lang = 'en_US'; }
		switch ($_lang) {
			case 'ko_KR':
				$L_default='Default';
				$wtb_signin_noti = get_option('wtb_signin_noti_ko');
				$wtb_signup_noti = get_option('wtb_signup_noti_ko');
				$wtb_profile_noti = get_option('wtb_profile_noti_ko');
				$wtb_resetpw_email = get_option('wtb_resetpw_email_ko');
				 $save_chg = '저장';
				 $save_success = '변경사항이 저장 되었습니다.';
				$tit_signin_noti =  '로그인 페이지 알림 메시지';
				$tit_signup_noti =  '회원가입 페이지 알림 메시지';
				$tit_profile_noti=  '프로파일 페이지 알림 메시지';
				$em_cont_resetpw =  '비밀번호 재 설정 메일 <div>[bloginfo] : 사이트 제목</div> <div>[username]: 아이디</div> <div>[password] : 비밀번호</div>';
				 $initialize_wptobe_signinup = 'Wptobe Signinup 초기화';
				 $initialize_btn = '초기화';
				 $initialize_desc = '단어입력';
				 $initialize_warning='초기화 작업을 수행하면 Wptobe Signinup 에 설정되어 있는 모든 데이터가 초기 설치 상태로 복원됩니다. 기존에 설정되어 있던 모든 설정 데이터는 복구되지 않으니 주의해 주시기 바랍니다. 메시지를 포함한 모든 언어 설정은 현재 워드프레스에 설정된 언어로 초기화 됩니다. 현재 워드프레스 언어가 영어로 설정되어 있다면 한국어로 변경 하신 뒤 초기화 작업을 수행해 주시면 편리하게 이용하실 수 있습니다.';
				break;
			case 'ja':
				$L_default='Default';
				$wtb_signin_noti = get_option('wtb_signin_noti_ja');
				$wtb_signup_noti = get_option('wtb_signup_noti_ja');
				$wtb_profile_noti = get_option('wtb_profile_noti_ja');
				$wtb_resetpw_email = get_option('wtb_resetpw_email_ja');
				$save_chg = 'セーブ';
				$save_success = '設定が正常に更新されました。';
				$tit_signin_noti =  'ログイン通知';
				$tit_signup_noti =  '会員登録の通知';
				$tit_profile_noti=  'プロファイル通知';
				$em_cont_resetpw =  'パスワードの電子メールをリセットします。 予約済みのショートコードを編集しないでください [bloginfo], [username], [password]';
				$initialize_wptobe_signinup = 'Wptobe Signinup 初期化';
				$initialize_btn = '初期化';
				$initialize_desc = 'タイプ';
				$initialize_warning='初期化プロセスは、すべてのデータを削除し、設定Wptobe Signinupを初期化します。 これはWptobe Signinupにのみ影響します。 これらのデータに変更を加えた場合、変更は失われます。';
				break;
			default: //'en'
				$L_default='Default';
				$wtb_signin_noti = get_option('wtb_signin_noti_en');
				$wtb_signup_noti = get_option('wtb_signup_noti_en');
				$wtb_profile_noti = get_option('wtb_profile_noti_en');
				$wtb_resetpw_email = get_option('wtb_resetpw_email_en');
				$save_chg = 'Save Changes';
				$tit_signin_noti =  'Sign in notification';
				$tit_signup_noti =  'Sign up notification';
				$tit_profile_noti=  'Profile notification';
				$em_cont_resetpw =  'Reset password e-mail. Do not edit reserved shortcode [bloginfo], [username], [password]';
				$save_success = 'Your settings updated successfully.';
				$initialize_wptobe_signinup = 'Reset Wptobe Signinup';
				$initialize_btn = 'Initialize';
				$initialize_desc = 'Type';
				$initialize_warning='The initialize process will remove all data and initialize settings Wptobe Signinup. This effects only to Wptobe Signinup. If you have made any modifications to those data, your changes will be lost.';
				break;	
		}// Language (End)
		?>

		<div class="postbox">
			<div class="inside">
				<?php
				if((isset($_POST['form_wtbadm_chgsent_submit'])) && ($_POST['form_wtbadm_chgsent_submit']=="Change sent")) {
					if ( !is_user_logged_in() ) { return;}
					$wtbsinup_lang = get_option( 'wtbsinup_lang' );
					if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {$_lang = $wtbsinup_lang[0]; }else { $_lang = 'en_US'; }

					if(isset($_POST['signin_noti0']) && !empty($_POST['signin_noti0'])) $sinnoti0=sanitize_text_field($_POST['signin_noti0']); else $sinnoti0='';
					if(isset($_POST['signin_noti1']) && !empty($_POST['signin_noti1'])) $sinnoti1=sanitize_text_field($_POST['signin_noti1']); else $sinnoti1='';
					if(isset($_POST['signin_noti2']) && !empty($_POST['signin_noti2'])) $sinnoti2=sanitize_text_field($_POST['signin_noti2']); else $sinnoti2='';
					if(isset($_POST['signin_noti3']) && !empty($_POST['signin_noti3'])) $sinnoti3=sanitize_text_field($_POST['signin_noti3']); else $sinnoti3='';
					$wtb_signin_noti = array( $sinnoti0,$sinnoti1,$sinnoti2,$sinnoti3);

					if(isset($_POST['signup_noti0']) && !empty($_POST['signup_noti0'])) $supnoti0=sanitize_text_field($_POST['signup_noti0']); else $supnoti0='';
					if(isset($_POST['signup_noti1']) && !empty($_POST['signup_noti1'])) $supnoti1=sanitize_text_field($_POST['signup_noti1']); else $supnoti1='';
					if(isset($_POST['signup_noti2']) && !empty($_POST['signup_noti2'])) $supnoti2=sanitize_text_field($_POST['signup_noti2']); else $supnoti2='';
					if(isset($_POST['signup_noti3']) && !empty($_POST['signup_noti3'])) $supnoti3=sanitize_text_field($_POST['signup_noti3']); else $supnoti3='';
					if(isset($_POST['signup_noti4']) && !empty($_POST['signup_noti4'])) $supnoti4=sanitize_text_field($_POST['signup_noti4']); else $supnoti4='';
					if(isset($_POST['signup_noti5']) && !empty($_POST['signup_noti5'])) $supnoti5=sanitize_text_field($_POST['signup_noti5']); else $supnoti5='';
					if(isset($_POST['signup_noti6']) && !empty($_POST['signup_noti6'])) $supnoti6=sanitize_text_field($_POST['signup_noti6']); else $supnoti6='';
					if(isset($_POST['signup_noti7']) && !empty($_POST['signup_noti7'])) $supnoti7=sanitize_text_field($_POST['signup_noti7']); else $supnoti7='';
					$wtb_signup_noti = array( $supnoti0,$supnoti1,$supnoti2,$supnoti3,$supnoti4,$supnoti5,$supnoti6,$supnoti7);

					if(isset($_POST['pf_noti_0']) && !empty($_POST['pf_noti_0'])) $n0=sanitize_text_field($_POST['pf_noti_0']); else $n0='';
					if(isset($_POST['pf_noti_1']) && !empty($_POST['pf_noti_1'])) $n1=sanitize_text_field($_POST['pf_noti_1']); else $n1='';
					if(isset($_POST['pf_noti_2']) && !empty($_POST['pf_noti_2'])) $n2=sanitize_text_field($_POST['pf_noti_2']); else $n2='';
					if(isset($_POST['pf_noti_3']) && !empty($_POST['pf_noti_3'])) $n3=sanitize_text_field($_POST['pf_noti_3']); else $n3='';
					if(isset($_POST['pf_noti_4']) && !empty($_POST['pf_noti_4'])) $n4=sanitize_text_field($_POST['pf_noti_4']); else $n4='';
					$wtb_profile_noti=array($n0,$n1,$n2,$n3,$n4);

					if(isset($_POST['resetpw_em0']) && !empty($_POST['resetpw_em0'])) $em0=sanitize_text_field($_POST['resetpw_em0']); else $em0='';
					if(isset($_POST['resetpw_em1']) && !empty($_POST['resetpw_em1'])) $em1=sanitize_text_field($_POST['resetpw_em1']); else $em1='';
					if(isset($_POST['resetpw_em2']) && !empty($_POST['resetpw_em2'])) $em2=sanitize_text_field($_POST['resetpw_em2']); else $em2='';
					if(isset($_POST['resetpw_em3']) && !empty($_POST['resetpw_em3'])) $em3=sanitize_text_field($_POST['resetpw_em3']); else $em3='';
					$email_resetpw = array(array( 1,'Title','em_title',$em0),array( 2,'Header','em_header',$em1),array(3,'Body','em_body',$em2),array(4,'Footer','em_footer',$em3));

					switch ($_lang) {
						case 'ko_KR':
							 update_option( 'wtb_signin_noti_ko', $wtb_signin_noti);
							 update_option( 'wtb_profile_noti_ko', $wtb_profile_noti);
							 update_option( 'wtb_resetpw_email_ko', $email_resetpw);
							 update_option( 'wtb_signup_noti_ko', $wtb_signup_noti);

							break;
						case 'ja':
							update_option( 'wtb_signin_noti_ja', $wtb_signin_noti);
							update_option( 'wtb_profile_noti_ja', $wtb_profile_noti);
							update_option( 'wtb_resetpw_email_ja', $email_resetpw);
							update_option( 'wtb_signup_noti_ja', $wtb_signup_noti);

							break;
						default: //'en'
							update_option( 'wtb_signin_noti_en', $wtb_signin_noti);
							update_option( 'wtb_profile_noti_en', $wtb_profile_noti);
							update_option( 'wtb_resetpw_email_en', $email_resetpw);
							update_option( 'wtb_signup_noti_en', $wtb_signup_noti);

							break;	
					}
				}//End if [Submit Profile]
				?>
				
				<div class="wtbadm-set-sentence"> 
					<form action="" method="post">
						<input class="wtbadm-chgsent-btn button-primary" class="" type="submit" value="<?php echo $save_chg;//_e('Save Changes',WTB_TDOM); ?>"  />
							<?php if(isset($_POST['chgsent_error']) && ($_POST['chgsent_error']=='no')) 
							{	
								echo '<div class="wtbadm-setsen-noti wtbadm-noti success">';
								echo $save_success;//_e("Your settings updated successfully.",WTB_TDOM);
								echo '</div>';
							} 
							?>
						<div class="wtbadm-setsen-form">	
					
							<table class="widefat fixed wtbadm-setsen-table">
								<thead>
								</thead>
								<tbody>
									<tr>
										<td class="td-before-login" colspan="1">
											<?php echo $tit_signin_noti;//_e( 'Sign in notification', WTB_TDOM);?>
										</td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="signin_noti0" rows="2" cols="60"><?php if(isset($_POST['signin_noti0']) && !empty($_POST['signin_noti0'])) echo esc_html( $_POST['signin_noti0']); else echo esc_html($wtb_signin_noti[0]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1">
										</td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="signin_noti1" rows="2" cols="60"><?php if(isset($_POST['signin_noti1']) && !empty($_POST['signin_noti1'])) echo esc_html( $_POST['signin_noti1']); else echo esc_html($wtb_signin_noti[1]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1">
										</td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="signin_noti2" rows="2" cols="60"><?php if(isset($_POST['signin_noti2']) && !empty($_POST['signin_noti2'])) echo esc_html( $_POST['signin_noti2']); else echo esc_html($wtb_signin_noti[2]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1">
										</td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="signin_noti3" rows="2" cols="60"><?php if(isset($_POST['signin_noti3']) && !empty($_POST['signin_noti3'])) echo esc_html( $_POST['signin_noti3']); else echo esc_html($wtb_signin_noti[3]); ?></textarea>
										</td>
									</tr>

									<tr><td class="wtbadm-separator" colspan="4"></td ></tr>
									<tr>
										<td class="td-before-login" colspan="1">
											<?php echo $tit_signup_noti;//_e( 'Sign up notification', WTB_TDOM);?>
										</td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="signup_noti0" rows="2" cols="60"><?php if(isset($_POST['signup_noti0']) && !empty($_POST['signup_noti0'])) echo esc_html( $_POST['signup_noti0']); else echo esc_html($wtb_signup_noti[0]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1"></td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="signup_noti1" rows="2" cols="60"><?php if(isset($_POST['signup_noti1']) && !empty($_POST['signup_noti1'])) echo esc_html( $_POST['signup_noti1']); else echo esc_html($wtb_signup_noti[1]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1"></td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="signup_noti2" rows="2" cols="60"><?php if(isset($_POST['signup_noti2']) && !empty($_POST['signup_noti2'])) echo esc_html( $_POST['signup_noti2']); else echo esc_html($wtb_signup_noti[2]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1"></td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="signup_noti3" rows="2" cols="60"><?php if(isset($_POST['signup_noti3']) && !empty($_POST['signup_noti3'])) echo esc_html($_POST['signup_noti3']); else echo esc_html($wtb_signup_noti[3]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1"></td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="signup_noti4" rows="2" cols="60"><?php if(isset($_POST['signup_noti4']) && !empty($_POST['signup_noti4'])) echo esc_html($_POST['signup_noti4']); else echo esc_html($wtb_signup_noti[4]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1"></td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="signup_noti5" rows="2" cols="60"><?php if(isset($_POST['signup_noti5']) && !empty($_POST['signup_noti5'])) echo esc_html($_POST['signup_noti5']); else echo esc_html($wtb_signup_noti[5]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1"></td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="signup_noti6" rows="2" cols="60"><?php if(isset($_POST['signup_noti6']) && !empty($_POST['signup_noti6'])) echo esc_html($_POST['signup_noti6']); else echo esc_html($wtb_signup_noti[6]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1"></td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="signup_noti7" rows="2" cols="60"><?php if(isset($_POST['signup_noti7']) && !empty($_POST['signup_noti7'])) echo esc_html($_POST['signup_noti7']); else echo esc_html($wtb_signup_noti[7]); ?></textarea>
										</td>
									</tr>

									<tr><td class="wtbadm-separator" colspan="4"></td ></tr>
									<tr>
										<td class="td-before-login" colspan="1">
											<?php echo $tit_profile_noti;//_e( 'Profile notification', WTB_TDOM);?>
										</td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="pf_noti_0" rows="2" cols="60"><?php if(isset($_POST['pf_noti_0']) && !empty($_POST['pf_noti_0'])) echo esc_html($_POST['pf_noti_0']); else echo esc_html($wtb_profile_noti[0]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1">
											
										</td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="pf_noti_1" rows="2" cols="60"><?php if(isset($_POST['pf_noti_1']) && !empty($_POST['pf_noti_1'])) echo esc_html($_POST['pf_noti_1']); else echo esc_html($wtb_profile_noti[1]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1">
											
										</td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="pf_noti_2" rows="2" cols="60"><?php if(isset($_POST['pf_noti_2']) && !empty($_POST['pf_noti_2'])) echo esc_html($_POST['pf_noti_2']); else echo esc_html($wtb_profile_noti[2]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1">
											
										</td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="pf_noti_3" rows="2" cols="60"><?php if(isset($_POST['pf_noti_3']) && !empty($_POST['pf_noti_3'])) echo esc_html($_POST['pf_noti_3']); else echo esc_html($wtb_profile_noti[3]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1">
											
										</td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="pf_noti_4" rows="2" cols="60"><?php if(isset($_POST['pf_noti_4']) && !empty($_POST['pf_noti_4'])) echo esc_html($_POST['pf_noti_4']); else echo esc_html($wtb_profile_noti[4]); ?></textarea>
										</td>
									</tr>

									<tr><td class="wtbadm-separator" colspan="4"></td ></tr>
									<tr>
										<td class="td-before-login" colspan="1">
											<div><?php echo $em_cont_resetpw;//_e( 'Reset password e-mail. Do not edit reserved shortcode [bloginfo], [username], [password]', WTB_TDOM);?></div>
										</td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="resetpw_em0" rows="2" cols="60"><?php if(isset($_POST['resetpw_em0']) && !empty($_POST['resetpw_em0'])) echo esc_html($_POST['resetpw_em0']); else echo esc_html($wtb_resetpw_email[0][3]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1">
										</td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="resetpw_em1" rows="2" cols="60"><?php if(isset($_POST['resetpw_em1']) && !empty($_POST['resetpw_em1'])) echo esc_html($_POST['resetpw_em1']); else echo esc_html($wtb_resetpw_email[1][3]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1">
										</td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="resetpw_em2" rows="2" cols="60"><?php if(isset($_POST['resetpw_em2']) && !empty($_POST['resetpw_em2'])) echo esc_html($_POST['resetpw_em2']); else echo esc_html($wtb_resetpw_email[2][3]); ?></textarea>
										</td>
									</tr>
									<tr>
										<td class="td-before-login" colspan="1">
										</td>
										<td class="td-before-login" colspan="3">
											<textarea id="" class="wtb-chgs-input" name="resetpw_em3" rows="2" cols="60"><?php if(isset($_POST['resetpw_em3']) && !empty($_POST['resetpw_em3'])) echo esc_html($_POST['resetpw_em3']); else echo esc_html($wtb_resetpw_email[3][3]); ?></textarea>
										</td>
									</tr>
								</tbody>
							</table>

							<input type="hidden" name="chgsent_error" class="" value="no">
							<input type="hidden" name="chgsent_savemsg" class="" value="">	
							<input type="hidden" name="form_wtbadm_chgsent_submit" value="Change sent">
						</div>
					</form>
				</div>

				<hr class="wtbadm-hr"/>
				<div class="wtbadm-signinup-reset-wrapper"> 
					<a href="#TB_inline?width=600&height=250&inlineId=modal-window-id-initialize" class="thickbox" title="<?php echo $initialize_wptobe_signinup;//_e('Reset Wptobe Signinup',WTB_TDOM);?>">
					<span class="button-primary"><?php echo $initialize_wptobe_signinup;?></span>
					</a>

					<div id="modal-window-id-initialize" style="display:none;">
						<div class='wtbadm-noti danger'>
							<?php echo $initialize_warning;?>
						</div>
						
						<div>
							<span class=''> <?php echo $initialize_desc;?> <span class='wtbadm-initialize-input-reset'>Reset</span></span>
							<span> <input type="text" name="wtb_signinup_initialize" id="wtb_signinup_initialize"></span>
							<button type="button" id="initbtn" class="reset_wtb_signinup button-primary" disabled value=""><?php echo $initialize_btn; ?></button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script>
			 
			jQuery(document).ready(function($) {
				document.getElementById("wtb_signinup_initialize").addEventListener("keyup", function() {
					var nameInput = document.getElementById('wtb_signinup_initialize').value;
					if (nameInput == "Reset" || nameInput == "reset") {
						document.getElementById('initbtn').removeAttribute("disabled");
					} else {
						document.getElementById('initbtn').setAttribute("disabled", null);
					}
				});

				$('.reset_wtb_signinup').on({

					click: function () { 
						self.parent.tb_remove();
						var el_id = "wtb_signinup_initialize";
						var chk_value = document.getElementById(el_id).value;
						var data = {
							'action': 'act_reset_wptobe_signinup',
							'reset_val': chk_value,
							'security': '<?php echo wp_create_nonce("chg_reinitialize_wptobe_signinup"); ?>' 
						};
						$.post(ajaxurl, data, function(response) {
							location.reload(); 
						});
					}
				});
			});
		</script>
	<?php
	}

	// 우커머스 체크아웃 주소를 다음 주소로 변경할 수 있는 기능
	public function Woocommerce_addon_html() {
		
		$wtbsinup_lang = get_option( 'wtbsinup_lang' );
		if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {$_lang = $wtbsinup_lang[0]; }else { $_lang = 'en_US'; }
		switch ($_lang) {
			case 'ko_KR':
				$L_wooc_addon_title='우커머스 체크아웃 국내 주소';
				$L_afterlogout='';
				$L_selectAPI='국내 주소 API 선택';
				$L_select='선택';
				$L_nonelocal='국내주소 사용안함';
				$L_Korea_Daum ="다음(Daum) 주소";
				break;
			case 'ja':
				$L_wooc_addon_title='WooCommerceチェックアウトアドレスのローカリゼーション';
				$L_afterlogout='';
				$L_selectAPI='アドレスAPIを選択';
				$L_select='選択';
				$L_nonelocal='Woocommerceのデフォルト';
				$L_Korea_Daum ="Korea Daum Address";
				break;
			default: //'en'
				$L_wooc_addon_title='WooCommerce checkout address localization';
				$L_afterlogout='';
				$L_selectAPI='Select address API';
				$L_select='Select';
				$L_nonelocal='None';
				$L_Korea_Daum ="Korea Daum Address";
				break;	
		}// Language (End)
		?>

		<div class="postbox">
			<div class="inside">

					<div class="wtbadm-selepage"> 
						<div class="wtbadm-sec-title"><?php echo $L_wooc_addon_title; ?></div>

					<table class="widefat fixed">
						<thead>
							<tr class="">
								<th class="th-before-login" colspan="1"><?php echo $L_selectAPI; ?>
								<span class="th-sin-select-desc"><?php echo $L_afterlogout; ?></span></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="td-before-login wtb-col-hilight" colspan="1" >
									<?php
									$wtbsigninup_woocaddrapi = get_option( 'wtbsigninup_woocaddrapi' );

									if( isset($wtbsigninup_woocaddrapi) && !empty($wtbsigninup_woocaddrapi) ) {	$wooaddr_API_ID = $wtbsigninup_woocaddrapi;}
									else { $wooaddr_API_ID = 0; }
									
									?>
									<select class="wtbadm-select" id='selectWooCheckoutLocAddr'>
										<option value='0' <?php if($wooaddr_API_ID == 0) echo "selected"; ?> ><?php echo $L_nonelocal; ?></option>
										<option value='1' <?php if($wooaddr_API_ID == 1) echo "selected"; ?> ><?php echo $L_Korea_Daum; ?></option>
									</select>

								
								</td>
								<td class="td-after-login" colspan="1" ></td>
							</tr>

						</tbody>
					</table>
			
			</div>
		</div>


		<script>
			jQuery(document).ready(function($) {
				// [우커머스 체크아웃 국내주소] 선택
				$("#selectWooCheckoutLocAddr").change(function(){
					var selectedAPI =  $(this).val();
					//alert(selectedAPI);
					var data = {
						'action': 'act_select_wooc_locaddr_api',
						'woochkout_apiid': selectedAPI,
						'security': '<?php echo wp_create_nonce("sec_select_wooc_locaddr_api"); ?>' 
					};

					$.post(ajaxurl, data, function(response) {

					});
				});

			});

		</script>
		<?php
	}


	public function Shortcodes_info() 
	{
		$wtbsinup_lang = get_option( 'wtbsinup_lang' );
		if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {$_lang = $wtbsinup_lang[0]; }else { $_lang = 'en_US'; }
		switch ($_lang) {
			case 'ko_KR':
				$L_title = '숏코드(shortcode) 정보';
				$L_subdesc='(메뉴에서 제공하는 페이지 선택 기능을 통해 내부적으로 사용됨)';
				$Cols_shortcode =  '숏코드';
				$Cols_description =  '설명';
				$Desc_signin ='로그인 화면을 보여준다. ';
				$Desc_signup ='회원가입 화면을 보여준다.';
				$Desc_profile ='회원에 대한 기본 프로파일 정보를 보여준다.';
				break;
			case 'ja':
				$L_title = 'ショートコード 情報';
				$L_subdesc='（メニューで提供されるページ選択機能を使用して内部的に使用される）';
				$Cols_shortcode =  'ショートコード';
				$Cols_description =  '解説';
				$Desc_signin ='ログイン画面を表示します。';
				$Desc_signup ='会員登録画面を示す。';
				$Desc_profile ='会員の基本的なプロファイル情報を示す。';
				break;
			default: //'en'
				$L_title = 'Shortcode Information';
				$L_subdesc='(Used internally through the page selection function provided by the menu)';
				$Cols_shortcode =  'Shortcode';
				$Cols_description =  'Description';
				$Desc_signin ='Show the login screen.';
				$Desc_signup ='Displays the membership registration screen.';
				$Desc_profile ='Displays basic profile information for members.';
				break;
		}// Language (End)
		?>

		<div class="postbox">
			<div class="inside">

					<div class="wtbadm-selepage"> 
					<table class="widefat fixed">
						<thead>
							<tr class="">
								<th class="th-sin-select-title" scope="row" colspan="3">
									<?php echo $L_title; ?>
									<div class="wtbadm-sc-subdesc" > <?php echo $L_subdesc; ?> </div>
								</th>
							</tr>
							<tr class="">
								<th class="th-before-login" colspan="1"><?php echo $Cols_shortcode; ?></th>
								<th class="th-after-login" colspan="2"><?php echo $Cols_description; ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="td-before-login" colspan="1">
									[wtb_signin]
								</td>

								<td class="td-after-login" colspan="2" >
									<?php echo $Desc_signin;?>
								</td>
							</tr>
							<tr>
								<td class="td-before-login" colspan="1">
									[wtb_signup]
								</td>

								<td class="td-after-login" colspan="2" >
									<?php echo $Desc_signup;?>
								
								</td>
							</tr>
							<tr>
								<td class="td-before-login" colspan="1">
									[wtb_profile]
								</td>

								<td class="td-after-login" colspan="2" >
									<?php echo $Desc_profile;?>
								</td>
							</tr>
						</tbody>
					</table>
					</div>
			</div>
		</div>	
		<?php
	}
}


add_action( 'plugins_loaded', array( 'WTB_Admin_Ajax', 'init' ) );
class WTB_Admin_Ajax
{
    protected static $instance;

    public static function init()
    {
        is_null( self::$instance ) AND self::$instance = new self;
        return self::$instance;
    }

    public function __construct()
    {
		add_action('wp_ajax_act_select_signin_sc_page_bf', array( $this, 'change_signin_sc_rendering_page_bf' ) );
		add_action('wp_ajax_act_select_signin_sc_page_af', array( $this, 'change_signin_sc_rendering_page_af' ) );
		add_action('wp_ajax_act_select_signup_sc_page_bf', array( $this,'change_signup_sc_rendering_page_bf') );
		add_action('wp_ajax_act_select_signup_sc_page_af', array( $this,'change_signup_sc_rendering_page_af') );
		add_action('wp_ajax_act_select_profile_sc_page_bf', array( $this, 'change_profile_sc_rendering_page_bf' ) );
		add_action('wp_ajax_act_select_profile_sc_page_af', array( $this, 'change_profile_sc_rendering_page_af' ) );
		add_action('wp_ajax_act_select_logout_sc_page_af', array( $this, 'change_logout_sc_rendering_page_af' ) );

		//우커머스 주소를 다음 주소로
		add_action('wp_ajax_act_select_wooc_locaddr_api', array( $this, 'change_wooc_locaddr_api' ) );
		if(function_exists('is_woocommerce') &&  function_exists('is_checkout') && function_exists('is_account_page')) 
		{
			$wtbsigninup_woocaddrapi = get_option( 'wtbsigninup_woocaddrapi' );

			if( isset($wtbsigninup_woocaddrapi) && !empty($wtbsigninup_woocaddrapi) ) {	$flag_daum_addr = $wtbsigninup_woocaddrapi;} else { $flag_daum_addr = 0; }
					
			if($flag_daum_addr == 1) 
			{
				add_filter('woocommerce_checkout_fields', array( $this, 'woocommerce_chkout_daum_address' ) );
				// Add Daum address style and script
				add_action( 'woocommerce_after_checkout_form', array( $this, 'enqueue_daum_address_for_woocommerce' ) );
				//add_action( 'woocommerce_account_content',  array( $this, 'enqueue_daum_address_for_woocommerce' ) );
			}
		}

		add_action('wp_ajax_act_chg_signin_page_fields', array( $this, 'change_signin_page_fields_show_and_hide' ) );
		add_action('wp_ajax_act_chg_signup_page_fields', array( $this, 'change_signup_page_fields_show_and_hide' ) );
		add_action('wp_ajax_act_chg_signin_fields_label', array( $this, 'change_signin_page_fields_labels' ) );
		add_action('wp_ajax_act_chg_signup_fields_label', array( $this, 'change_signup_page_fields_labels' ) );
		add_action('wp_ajax_act_chg_resetpw_page_fields', array( $this, 'change_resetpw_page_fields_show_and_hide' ) );
		add_action('wp_ajax_act_chg_resetpw_fields_label', array( $this, 'change_resetpw_page_fields_labels' ) );
		add_action('wp_ajax_act_select_a_skin', array( $this, 'change_applied_skin' ) );
		add_action('wp_ajax_wtbadm_signin_field_reorder', array( $this, 'wtbadm_signinfield_reorder_func' ) );
		add_action('wp_ajax_wtbadm_signup_field_reorder', array( $this, 'wtbadm_signupfield_reorder_func' ) );
		add_action('wp_ajax_wtbadm_resetpw_field_reorder', array( $this, 'wtbadm_resetpwfield_reorder_func' ) );
		add_action('wp_ajax_act_select_a_lang', array( $this, 'change_applied_lang' ) );
    }

	//체크아웃 페이지 우커머스 주소를 다음 주소로
	public function woocommerce_chkout_daum_address( $fields ) 
	{
		 $fields['billing']['billing_postcode']['label'] = '<input type="button" id="billing_postcode_search" value="우편번호" class="wtbfe-daum-postcode" onclick="sample4_execDaumPostcode_billing();" >';

		 $fields['shipping']['shipping_postcode']['label'] = '<input type="button" id="shipping_postcode_search" value="우편번호" class="wtbfe-daum-postcode" onclick="sample4_execDaumPostcode_shipping();" >';

		 return $fields;
	}

	public function enqueue_daum_address_for_woocommerce() {

		wp_enqueue_style('wtb-fe-wooc-daumaddr-style');
	?>
		<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>	
		<script type="text/javascript">
			function sample4_execDaumPostcode_billing() {
					new daum.Postcode({
						oncomplete: function(data) {
							// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

							// 도로명 주소의 노출 규칙에 따라 주소를 표시한다.
							// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
							var roadAddr = data.roadAddress; // 도로명 주소 변수
							var extraRoadAddr = ''; // 참고 항목 변수

							// 법정동명이 있을 경우 추가한다. (법정리는 제외)
							// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
							if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
								extraRoadAddr += data.bname;
							}
							// 건물명이 있고, 공동주택일 경우 추가한다.
							if(data.buildingName !== '' && data.apartment === 'Y'){
							   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
							}
							// 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
							if(extraRoadAddr !== ''){
								extraRoadAddr = ' (' + extraRoadAddr + ')';
							}

							// 우편번호와 주소 정보를 해당 필드에 넣는다.
							document.getElementById('billing_postcode').value = data.zonecode;
							document.getElementById("billing_address_1").value = roadAddr;
							document.getElementById('billing_address_2').focus();

						}
					}).open();
				}

			function sample4_execDaumPostcode_shipping() {
				new daum.Postcode({
					oncomplete: function(data) {

							// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

							// 도로명 주소의 노출 규칙에 따라 주소를 표시한다.
							// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
							var roadAddr = data.roadAddress; // 도로명 주소 변수
							var extraRoadAddr = ''; // 참고 항목 변수

							// 법정동명이 있을 경우 추가한다. (법정리는 제외)
							// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
							if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
								extraRoadAddr += data.bname;
							}
							// 건물명이 있고, 공동주택일 경우 추가한다.
							if(data.buildingName !== '' && data.apartment === 'Y'){
							   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
							}
							// 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
							if(extraRoadAddr !== ''){
								extraRoadAddr = ' (' + extraRoadAddr + ')';
							}

							// 우편번호와 주소 정보를 해당 필드에 넣는다.
							document.getElementById('shipping_postcode').value = data.zonecode;
							document.getElementById("shipping_address_1").value = roadAddr;
							document.getElementById('shipping_address_2').focus();
					}
				}).open();
			}
		</script>
	 <?php
	}


	public function change_signin_sc_rendering_page_bf() 
	{
		check_ajax_referer('select_signin_shortcode_page_bf', 'security');

		if(isset($_POST['sin_scpid']) && !empty($_POST['sin_scpid']) ) {
			
			$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
			$wtbsigninup_setopt[0] = intval($_POST['sin_scpid']);
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt );
			$signinpg_url = esc_url( get_permalink( $wtbsigninup_setopt[0] ));
		}else {
			$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
			$wtbsigninup_setopt[0] = 0;
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt );
			$signinpg_url="#";
		}

		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
		wp_die();
	}


	public function change_signin_sc_rendering_page_af() 
	{
		check_ajax_referer('select_signin_shortcode_page_af', 'security');

		if(isset($_POST['sin_scpid']) && !empty($_POST['sin_scpid']) ) {
			
			$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
			$wtbsigninup_setopt[3] = intval($_POST['sin_scpid']);
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt );
			$signinpg_url = esc_url( get_permalink( $wtbsigninup_setopt[3] ));
		}else {
			$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
			$wtbsigninup_setopt[3] = 0;
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt );
			$signinpg_url="#";
		}
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
		wp_die();
	}

	public function change_signup_sc_rendering_page_bf() 
	{
		check_ajax_referer('select_signup_shortcode_page_bf', 'security');

		if(isset($_POST['sup_scpid']) && !empty($_POST['sup_scpid']) ) {
			$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
			$wtbsigninup_setopt[1] = intval($_POST['sup_scpid']);
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt );
			$signuppg_url = esc_url( get_permalink( $wtbsigninup_setopt[1] ));
		}else {
			$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
			$wtbsigninup_setopt[1] = 0;
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt );
			$signuppg_url="#";
		}
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
		wp_die();
	}

	public function change_signup_sc_rendering_page_af() 
	{
		check_ajax_referer('select_signup_shortcode_page_af', 'security');

		if(isset($_POST['sup_scpid']) && !empty($_POST['sup_scpid']) ) {
			$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
			$wtbsigninup_setopt[4] = intval($_POST['sup_scpid']);
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt );
			$signuppg_url = esc_url( get_permalink( $wtbsigninup_setopt[4] ));
		}else {
			$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
			$wtbsigninup_setopt[4] = 0;
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt );
			$signuppg_url="#";
		}
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
		wp_die();
	}

	public function change_profile_sc_rendering_page_bf() 
	{
		check_ajax_referer('select_profile_shortcode_page_bf', 'security');

		if(isset($_POST['sup_scpid']) && !empty($_POST['sup_scpid']) ) {
			
			$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
			$wtbsigninup_setopt[2] = intval($_POST['sup_scpid']);
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt );
			$profilepgbf_url = esc_url( get_permalink( $wtbsigninup_setopt[2] ));
		}else {
			$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
			$wtbsigninup_setopt[2] = 0;
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt );
			$profilepgbf_url="#";
		}

		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
		wp_die();
	}

	public function change_profile_sc_rendering_page_af() 
	{
		check_ajax_referer('select_profile_shortcode_page_af', 'security');

		if(isset($_POST['sup_scpid']) && !empty($_POST['sup_scpid']) ) {
			$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
			$wtbsigninup_setopt[5] = intval($_POST['sup_scpid']);
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt );
			$profilepgaf_url = esc_url( get_permalink( $wtbsigninup_setopt[5] ));
		}else {
			$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
			$wtbsigninup_setopt[5] = 0;
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt );
			$profilepgaf_url="#";
		}
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
		wp_die();
	}

	public function change_logout_sc_rendering_page_af() 
	{
		check_ajax_referer('select_logout_shortcode_page_af', 'security');

		if(isset($_POST['logout_scpid']) && !empty($_POST['logout_scpid']) ) {
			
			$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
			$wtbsigninup_setopt[6] = intval($_POST['logout_scpid']);
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt );
			$logoutpg_url = esc_url( get_permalink( $wtbsigninup_setopt[6] ));
		}else {
			$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
			$wtbsigninup_setopt[6] = 0;
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt );
			$logoutpg_url="#";
		}
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
		wp_die();
	}

	// 우커머스 체크아웃 기본주소를 다음 주소로 변경
	public function change_wooc_locaddr_api() 
	{
		check_ajax_referer('sec_select_wooc_locaddr_api', 'security'); 

		if(isset($_POST['woochkout_apiid']) && !empty($_POST['woochkout_apiid']) ) {
			$wtbsigninup_woocaddrapi = get_option( 'wtbsigninup_woocaddrapi' );
			update_option( 'wtbsigninup_woocaddrapi', $_POST['woochkout_apiid'] );
		}else {
			$wtbsigninup_woocaddrapi = get_option( 'wtbsigninup_woocaddrapi' );
			update_option( 'wtbsigninup_woocaddrapi', 0 );	
		}

		wp_die();
	}

	public function change_signin_page_fields_show_and_hide() 
	{
		check_ajax_referer('chg_signin_fields_shownhide', 'security');
		if(isset($_POST['sin_id']) && !empty($_POST['sin_id']) && isset($_POST['sin_display']) && !empty($_POST['sin_display'])) {
			$prev_signin_fields = get_option( 'wtb_signin_fields' );

			foreach($prev_signin_fields as &$sinfields) {
				if($sinfields[0]==$_POST['sin_id']) { 
					$sinfields[3] = $_POST['sin_display']; 
				}
			}
			update_option( 'wtb_signin_fields', $prev_signin_fields ); 
		}
		wp_die();
	}

	public function change_signup_page_fields_show_and_hide() 
	{
		check_ajax_referer('chg_signup_fields_shownhide', 'security');
		if(isset($_POST['sup_id']) && !empty($_POST['sup_id']) && isset($_POST['sup_display']) && !empty($_POST['sup_display'])) {
			$prev_signup_fields = get_option( 'wtb_signup_fields' );
			foreach($prev_signup_fields as &$supfields) {
				if($supfields[0]==$_POST['sup_id']) { 
					$supfields[3] = $_POST['sup_display']; 
				}
			}
			update_option( 'wtb_signup_fields', $prev_signup_fields ); 
		}
		wp_die();
	}

	public function change_signin_page_fields_labels() 
	{
		check_ajax_referer('chg_signin_fields_edit', 'security');

		if(isset($_POST['sin_id']) && !empty($_POST['sin_id']) && isset($_POST['sin_val']) && !empty($_POST['sin_val'])) {
			$prev_signin_fields = get_option( 'wtb_signin_fields' );

			foreach($prev_signin_fields as &$sinfields) {
				if($sinfields[0]==$_POST['sin_id']) { 
					$sinfields[1] = $_POST['sin_val']; 
				}
			}
			update_option( 'wtb_signin_fields', $prev_signin_fields ); 
		}
		wp_die();
	}


	public function change_signup_page_fields_labels() 
	{
		check_ajax_referer('chg_signup_fields_edit', 'security');

		if(isset($_POST['sup_id']) && !empty($_POST['sup_id']) && isset($_POST['sup_val']) && !empty($_POST['sup_val'])) {
			$prev_signup_fields = get_option( 'wtb_signup_fields' );

			foreach($prev_signup_fields as &$supfields) {
				if($supfields[0]==$_POST['sup_id']) { 
					$supfields[1] = $_POST['sup_val']; 
				}
			}
			update_option( 'wtb_signup_fields', $prev_signup_fields ); 
		}
		wp_die();
	}

	public function change_resetpw_page_fields_show_and_hide() 
	{
		check_ajax_referer('chg_resetpw_fields_shownhide', 'security');

		if(isset($_POST['rpw_id']) && !empty($_POST['rpw_id']) && isset($_POST['rpw_display']) && !empty($_POST['rpw_display'])) {
			$prev_resetpw_fields = get_option( 'wtb_resetpw_fields' );
			foreach($prev_resetpw_fields as &$rpwfields) {
				if($rpwfields[0]==$_POST['rpw_id']) { 
					$rpwfields[3] = $_POST['rpw_display']; 
				}
			}
			update_option( 'wtb_resetpw_fields', $prev_resetpw_fields ); 
		}
		wp_die();
	}

	public function change_resetpw_page_fields_labels() 
	{
		check_ajax_referer('chg_resetpw_fields_edit', 'security');
		if(isset($_POST['rpw_id']) && !empty($_POST['rpw_id']) && isset($_POST['rpw_val']) && !empty($_POST['rpw_val'])) {

			$prev_resetpw_fields = get_option( 'wtb_resetpw_fields' );

			foreach($prev_resetpw_fields as &$rpwfields) {
				if($rpwfields[0]==$_POST['rpw_id']) { 
					$rpwfields[1] = $_POST['rpw_val']; 
				}
			}
			update_option( 'wtb_resetpw_fields', $prev_resetpw_fields ); 
		}
		wp_die();
	}

	public function change_applied_skin() 
	{
		check_ajax_referer('select_a_skin_nonce', 'security');

		if(isset($_POST['skin_name']) && !empty($_POST['skin_name']) ) {
			$wtbsinup_skin = get_option( 'wtbsinup_skin' );
			$wtbsinup_skin[0] = sanitize_text_field($_POST['skin_name']);
			update_option( 'wtbsinup_skin', $wtbsinup_skin );
		}else {
			$wtbsinup_skin = get_option( 'wtbsinup_skin' );
			$wtbsinup_skin[0] = 'default';
			update_option( 'wtbsinup_skin', $wtbsinup_skin );
		}

		$wtbsinup_skin = get_option( 'wtbsinup_skin' );

		echo esc_html($wtbsinup_skin[0]);
		wp_die();
	}

	public function wtbadm_signinfield_reorder_func() 
	{
		$signin_new_fields=array();
		$signin_old_fields=array();
		$new_order ='';
		$key = '';
		$row = '';
		$new_order = sanitize_text_field($_REQUEST['orderstring']);
		$new_order = explode( "&", $new_order );	
		$signin_old_fields = get_option( 'wtb_signin_fields' );

		for( $row = 0; $row < count( $new_order ); $row++ )  {
			if( $row > 0 ) {
				$key = $new_order[$row];
				$key = substr( $key, 19 );

				for( $x = 0; $x < count( $signin_old_fields ); $x++ )  {
					if( $signin_old_fields[$x][0] == $key ) {
						$signin_new_fields[$row - 1] = $signin_old_fields[$x];
					}
				}
			}
		}
		update_option( 'wtb_signin_fields', $signin_new_fields ); 
		die(); 
	}

	public function wtbadm_signupfield_reorder_func() 
	{
		$signup_new_fields=array();
		$signup_old_fields=array();
		$new_order ='';
		$key = '';
		$row = '';
		$new_order = sanitize_text_field($_REQUEST['orderstring']);
		$new_order = explode( "&", $new_order );	
		$signup_old_fields = get_option( 'wtb_signup_fields' );

		for( $row = 0; $row < count( $new_order ); $row++ )  {
			if( $row > 0 ) {
				$key = $new_order[$row]; 
				$key = substr( $key, 19 );
				
				for( $x = 0; $x < count( $signup_old_fields ); $x++ )  {
					if( $signup_old_fields[$x][0] == $key ) {
						$signup_new_fields[$row - 1] = $signup_old_fields[$x];
					}
				}
			}
		}
		update_option( 'wtb_signup_fields', $signup_new_fields ); 
		die(); 
	}

	public function wtbadm_resetpwfield_reorder_func() 
	{
		$resetpw_new_fields=array();
		$resetpw_old_fields=array();
		$new_order ='';
		$key = '';
		$row = '';
		$new_order = sanitize_text_field($_REQUEST['orderstring']);
		$new_order = explode( "&", $new_order );	
		$resetpw_old_fields = get_option( 'wtb_resetpw_fields' );

		for( $row = 0; $row < count( $new_order ); $row++ )  {
			if( $row > 0 ) {
				$key = $new_order[$row]; 
				$key = substr( $key, 19 ); 
				for( $x = 0; $x < count( $resetpw_old_fields ); $x++ )  {
					if( $resetpw_old_fields[$x][0] == $key ) {
						$resetpw_new_fields[$row - 1] = $resetpw_old_fields[$x];
					}
				}
			}
		}
		update_option( 'wtb_resetpw_fields', $resetpw_new_fields ); 
		die(); 
	}

	public function change_applied_lang() 
	{
		check_ajax_referer('select_a_lang_nonce', 'security');
		if(isset($_POST['sel_lang']) && !empty($_POST['sel_lang']) ) {
			$wtbsinup_lang = get_option( 'wtbsinup_lang' );
			$wtbsinup_lang[0] = sanitize_text_field($_POST['sel_lang']);
			update_option( 'wtbsinup_lang', $wtbsinup_lang );
		}else {
			$wtbsinup_lang = get_option( 'wtbsinup_lang' );
			$wtbsinup_lang[0] = 'en';
			update_option( 'wtbsinup_lang', $wtbsinup_lang );
		}

		$wtbsinup_lang = get_option( 'wtbsinup_lang' );
		echo esc_html($wtbsinup_lang[0]);
		wp_die();
	}
}
