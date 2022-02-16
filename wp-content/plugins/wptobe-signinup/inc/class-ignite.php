<?php 
add_action( 'plugins_loaded', array( 'WTB_Setup_Init_Class', 'init' ) );
class WTB_Setup_Init_Class
{
    protected static $instance;

    public static function init()
    {
        is_null( self::$instance ) AND self::$instance = new self;
        return self::$instance;
    }

    public function __construct()
    {
		$wtbsinup_skin = get_option( 'wtbsinup_skin' );
		$skinname ='default';
		if ( isset($wtbsinup_skin[0]) && !empty($wtbsinup_skin[0]) ) 
		{
			$skinname = $wtbsinup_skin[0];
			if( 
				!(file_exists( WTBSIGN_SKIN.'/'.$skinname.'/sign-in-html.php')&&
				file_exists( WTBSIGN_SKIN.'/'.$skinname.'/sign-up-html.php')&&
				file_exists( WTBSIGN_SKIN.'/'.$skinname.'/password-reset-html.php')&&
				file_exists( WTBSIGN_SKIN.'/'.$skinname.'/profile-html.php')))
			{
				$skinname ='default';
			}
		}

		define("SIGNIN_HTML", WTBSIGN_SKIN.'/'.$skinname.'/sign-in-html.php');
		define("SIGNUP_HTML", WTBSIGN_SKIN.'/'.$skinname.'/sign-up-html.php');
		define("PWRESET_HTML", WTBSIGN_SKIN.'/'.$skinname.'/password-reset-html.php');
		define("PROFILE_HTML", WTBSIGN_SKIN.'/'.$skinname.'/profile-html.php');
		define("SIGNIN_CSS", WTBSIGN_SKINURL . '/'.$skinname.'/wtbfe-signin.css');
		define("SIGNUP_CSS", WTBSIGN_SKINURL . '/'.$skinname.'/wtbfe-signup.css');
		define("PROFILE_CSS", WTBSIGN_SKINURL . '/'.$skinname.'/wtbfe-profile.css');
		define("WOODAUMADDR_CSS", WTBSIGN_SKINURL . '/'.$skinname.'/wtbfe-wooc-daum-address.css');

		add_action( 'init', array( $this, 'wtb_form_actions' ) );
		add_filter( 'lostpassword_url', array( $this, 'wtb_signinup_lostpassword_url' ),10,0 );

		add_shortcode( 'wtb_signin', array( $this, 'shortcode_signin' ));
		add_shortcode( 'wtb_signup', array( $this, 'shortcode_signup' ));
		add_shortcode( 'wtb_profile',array( $this, 'shortcode_profile' ));

		add_action('wp_ajax_act_reset_wptobe_signinup', array( $this, 'reset_wptobe_signinup_func' ) );
		$file = apply_filters( 'wtb_signinup_local_file', WTBSIGN_LANG );
		load_plugin_textdomain( 'wtbsinup', false, $file );
    }

	public function wptobe_signinup_install( $reset)
	{

		if(get_option( 'wtb_sinup_installed' )) $installed=true; else $installed=false;

		if( !$installed || $reset ) {

			update_option('wtb_sinup_installed', "Installed");

			$wtbsigninup_setopt = array( 
				0,	//$wtbsigninup_setopt[0] : [Before Login]Signin Page ID
				0,	//$wtbsigninup_setopt[1] : [Before Login]Signup Page ID
				0,	//$wtbsigninup_setopt[2] : [Before Login]Profile Page ID (ex: Sign in or Information page)
				0,	//$wtbsigninup_setopt[3] : [After Login]Signin Page ID
				0,	//$wtbsigninup_setopt[4] : [Before login** - After Signup redirect page ]Signup Page ID
				0,	//$wtbsigninup_setopt[5] : [After Login]Profile Page ID
				0	//$wtbsigninup_setopt[6] : [After Logout]Redirected Page ID
			);
			update_option( 'wtbsigninup_setopt', $wtbsigninup_setopt);

			$c_lang= get_locale(); if(!isset($c_lang)) $c_lang='en_US';
			$wtbsinup_lang = array( 
				$c_lang,	//$wtbsinup_lang[0] : 
				0,			//$wtbsinup_lang[1] : 
				0,			//$wtbsinup_lang[2] : 
			);
			update_option( 'wtbsinup_lang', $wtbsinup_lang);

			$sin_label=array();
			switch ($c_lang) {
				case 'ko_KR':
					$sin_label[0]='로그인';					//[0]
					$sin_label[1]='아이디';					//[1]
					$sin_label[2]='이메일';					//[2]
					$sin_label[3]='아이디 또는 이메일';			//[3]
					$sin_label[4]='비밀번호';					//[4]
					$sin_label[5]='보안문자 입력:';				//[5]
					$sin_label[6]='기억하기';					//[6]
					$sin_label[7]='비밀번호 찾기';				//[7]
					$sin_label[8]='구분선';					//[8]
					$sin_label[9]='구분선(글자포함)';			//[9]
					$sin_label[10]='로그인';						//[10]
					$sin_label[11]='구글 계정으로 로그인';		//[11] 
					$sin_label[12]='페이스북 계정으로 로그인';		//[12]
					$sin_label[13]='아직 회원이 아니세요? 회원가입';	//[13]
					break;
				case 'ja':
					$sin_label[0]='ログイン';					//[0]
					$sin_label[1]='ユーザ名';					//[1]
					$sin_label[2]='Eメール';					//[2]
					$sin_label[3]='ユーザ名 または Eメール';	//[3]
					$sin_label[4]='パスワード';				//[4]
					$sin_label[5]='キャプチャコード:';			//[5]
					$sin_label[6]='覚えて';					//[6]
					$sin_label[7]='パスワードを再設定する';	//[7]
					$sin_label[8]='分離機';					//[8]
					$sin_label[9]='分離機(文字)';				//[9]
					$sin_label[10]='ログインする';				//[10]
					$sin_label[11]='グーグルアカウントにログイン';		//[11] 
					$sin_label[12]='フェイスブックのアカウントでログイン';//[12]
					$sin_label[13]='まだ会員でないですか？会員登録';	//[13]
					break;
				default: //'en'
					$sin_label[0]='Sign in';					//[0]
					$sin_label[1]='Username';					//[1]
					$sin_label[2]='Email';					//[2]
					$sin_label[3]='Username/Email';			//[3]
					$sin_label[4]='Password';					//[4]
					$sin_label[5]='Enter the words above:';	//[5]
					$sin_label[6]='Remember me';				//[6]
					$sin_label[7]='Reset password';			//[7]
					$sin_label[8]='Separator';				//[8]
					$sin_label[9]='Sep.(ch)';					//[9]
					$sin_label[10]='Sign in';					//[10]
					$sin_label[11]='Continue with Google';		//[11] 
					$sin_label[12]='Continue with Facebook';	//[12]
					$sin_label[13]='Not a member yet? Join now';	//[13]	
					break;	
			}// Language (End)

			$signin_fields_shownhide_initial = array(
				//	  Order		Label						variable			Signin	
				array( 1,		$sin_label[0],				'o_header',			'on'	),
				array( 2,		$sin_label[1],				'o_username',		'on'	),	
				array( 3,		$sin_label[2],				'o_email',			'off'	),
				array( 4,		$sin_label[3],				'o_unameemail',		'off'	),
				array( 5,		$sin_label[4],				'o_password',		'on'	),	
				array( 6,		$sin_label[5],				'o_captcha',		'off'	),
				array( 7,		$sin_label[6],				'o_rememberme',		'on'	),
				array( 8,		$sin_label[7],				'o_resetpw',		'on'	),
				array( 9,		$sin_label[8],				'o_separator',		'off'	),
				array( 10,		$sin_label[9],				'o_separatoror',	'off'	),
				array( 11,		$sin_label[10],				'o_button',			'on'	),
				array( 12,		$sin_label[11],				'o_google',			'off'	),
				array( 13,		$sin_label[12],				'o_facebook',		'off'	),				
				array( 14,		$sin_label[13],				'o_signuplink',		'on'	) 
			);
			update_option( 'wtb_signin_fields', $signin_fields_shownhide_initial ); 

			$wtb_signin_noti_en = array( 
				'Your account information was entered incorrectly. ',
				"Please fill out username or e-mail.",
				"Please fill out password.",
				'You must enter a valid text.'	
			);
			update_option( 'wtb_signin_noti_en', $wtb_signin_noti_en);
			
			$wtb_signin_noti_ko = array( 
				'가입하지 않은 아이디이거나, 잘못된 비밀번호입니다.',
				"아이디 또는 이메일 주소를 입력하세요.",
				"패스워드를 입력하세요.",
				'보안문자를 입력하세요.'	
			);
			update_option( 'wtb_signin_noti_ko', $wtb_signin_noti_ko);

			$wtb_signin_noti_ja = array( 
				'加入していないユーザ名であるか、誤ったパスワードです.',
				"ユーザー名またはメールアドレスを入力してください。",
				"パスワードを入力してください。",
				'有効なテキストを入力する必要があります。'	
			);
			update_option( 'wtb_signin_noti_ja', $wtb_signin_noti_ja);

			$sup_label=array();
			switch ($c_lang) {
				case 'ko_KR':
					$sup_label[0]='회원가입';					
					$sup_label[1]='아이디';					
					$sup_label[2]='이메일';						
					$sup_label[3]='비밀번호';					
					$sup_label[4]='비밀번호 확인';			
					$sup_label[5]='보안문자 입력:';		
					$sup_label[6]='구분선';					
					$sup_label[7]='구분선(글자)';					
					$sup_label[8]='회원가입';		
					$sup_label[9]='회원이세요? 로그인';						
					break;
				case 'ja':
					$sup_label[0]='会員登録';					
					$sup_label[1]='ユーザ名';					
					$sup_label[2]='Eメール';						
					$sup_label[3]='パスワード';					
					$sup_label[4]='パスワードの確認';			
					$sup_label[5]='キャプチャコード';		
					$sup_label[6]='分離機';					
					$sup_label[7]='分離機(文字)';		
					$sup_label[8]='会員登録';		
					$sup_label[9]='すでにメンバーですか？ ログイン';						
					break;
				default: //'en'
					$sup_label[0]='Sign up';					
					$sup_label[1]='Username';					
					$sup_label[2]='Email';						
					$sup_label[3]='Password';					
					$sup_label[4]='Confirm Password';			
					$sup_label[5]='Enter the words above:';		
					$sup_label[6]='Separator';					
					$sup_label[7]='Sep.(ch)';					
					$sup_label[8]='Sign up';
					$sup_label[9]='Already a member? Sign In';					
					break;	
			}// Language (End)

			$signup_fields_shownhide_initial = array(
				//	  Order		Label			variable			Signup	
				array( 1,		$sup_label[0],	'o_header',			'on'	),
				array( 2,		$sup_label[1],	'o_username',		'on'	),	
				array( 3,		$sup_label[2],	'o_email',			'on'	),
				array( 4,		$sup_label[3],	'o_password',		'on'	),	
				array( 5,		$sup_label[4],	'o_confirmpw',		'off'	),
				array( 6,		$sup_label[5],	'o_captcha',		'on'	),
				array( 7,		$sup_label[6],	'o_separator',		'off'	),
				array( 8,		$sup_label[7],	'o_separatoror',	'off'	),
				array( 9,		$sup_label[8],	'o_button',			'on'	),
				array( 10,		$sup_label[9],	'o_signinlink',		'on'	)
			);
			update_option( 'wtb_signup_fields', $signup_fields_shownhide_initial ); 

			$wtb_signup_noti_en = array( 
				'Your account created successfully.',	//[0]
				'User ID already taken by others',		//[1]
				'This username is not valid',			//[2]
				'Email already taken by others',		//[3]
				'This email is not valid',				//[4]
				'This password is not valid',			//[5]
				'Password did not match',				//[6]
				'You must enter a valid text.'			//[7]
			);
			update_option( 'wtb_signup_noti_en', $wtb_signup_noti_en);

			$wtb_signup_noti_ko = array( 
				'축하합니다. 계정이 생성되었습니다. ',	//[0]
				'이미 사용중인 아이디 입니다. ',		//[1]
				'유효하지 않은 아이디입니다. ',			//[2]
				'이미 사용중인 이메일입니다. ',			//[3]
				'유효한 이메일이 아닙니다.',			//[4]
				'유효한 암호가 아닙니다. ',			//[5]
				'암호가 일치하지 않습니다. ',			//[6]
				'보안 문자가 일치하지 않습니다.'		//[7]
			);
			update_option( 'wtb_signup_noti_ko', $wtb_signup_noti_ko);

			$wtb_signup_noti_ja = array( 
				'アカウントが正常に作成されました。',			//[0]
				'他のユーザーがすでに使用しているユーザーID',		//[1]
				'このユーザー名は無効です',						//[2]
				'他のユーザーが既に使用しているメール',				//[3]
				'このメールは無効です',							//[4]
				'このパスワードは無効です',						//[5]
				'パスワードが一致しませんでした',				//[6]
				'有効なテキストを入力する必要があります。'		//[7]
			);
			update_option( 'wtb_signup_noti_ja', $wtb_signup_noti_ja);

			$pro_label=array();
			switch ($c_lang) {
				case 'ko_KR':
					$pro_label[0]='프로파일';			//[0]
					$pro_label[1]='계정';			//[1]
					$pro_label[2]='비밀번호';			//[2]
					$pro_label[3]='아이디';			//[3]
					$pro_label[4]='이메일';			//[4]
					$pro_label[5]='이름';			//[5]
					$pro_label[6]='역할';			//[6]
					$pro_label[7]='홈페이지';			//[7]
					$pro_label[8]='자기소개';			//[8]
					$pro_label[9]='가입일';			//[9]
					$pro_label[10]='저장';			//[10]
					$pro_label[11]='비밀번호 변경';	//[11]
					$pro_label[12]='현재 비밀번호';	//[12]
					$pro_label[13]='새 비밀번호';		//[13]
					$pro_label[14]='새 비밀번호 확인';//[14]
					$pro_label[15]='변경하기';		//[15]
					break;
				case 'ja':
					$pro_label[0]='プロフィール';		//[0]
					$pro_label[1]='アカウント';			//[1]
					$pro_label[2]='パスワード';			//[2]
					$pro_label[3]='ユーザ名';			//[3]
					$pro_label[4]='Eメール';				//[4]
					$pro_label[5]='名前';				//[5]
					$pro_label[6]='役割';				//[6]
					$pro_label[7]='ウェブサイト';		//[7]
					$pro_label[8]='自己紹介';			//[8]
					$pro_label[9]='以降のメンバー';		//[9]
					$pro_label[10]='セーブ';				//[10]
					$pro_label[11]='パスワードを変更する';//[11]
					$pro_label[12]='現在のパスワード';	//[12]
					$pro_label[13]='新しいパスワード';	//[13]
					$pro_label[14]='新しいパスワードを確認';//[14]
					$pro_label[15]='変化する';				//[15]
					break;
				default: //'en'
					$pro_label[0]='Profile';			//[0]
					$pro_label[1]='Account';			//[1]
					$pro_label[2]='Password';			//[2]
					$pro_label[3]='Username';			//[3]
					$pro_label[4]='Email';				//[4]
					$pro_label[5]='Name';				//[5]
					$pro_label[6]='Role';				//[6]
					$pro_label[7]='Homepage';			//[7]
					$pro_label[8]='Biographical info.';	//[8]
					$pro_label[9]='Member since';		//[9]
					$pro_label[10]='Save changes';		//[10]
					$pro_label[11]='Change your password';//[11]
					$pro_label[12]='Current Password';	//[12]
					$pro_label[13]='New Password';		//[13]
					$pro_label[14]='Confirm Password';	//[14]
					$pro_label[15]='Change Password';		//[15]
					break;	
			}
			
			$profile_fields_shownhide_initial = array(
				//	  Order		Label			variable			Profile	
				array( 1,		$pro_label[0],	'o_header',			'on'	),
				array( 2,		$pro_label[1],	'o_account_t',		'on'	),
				array( 3,		$pro_label[2],	'o_password_t',		'on'	),
				array( 4,		$pro_label[3],	'o_username',		'on'	),	
				array( 5,		$pro_label[4],	'o_email',			'on'	),	
				array( 6,		$pro_label[5],	'o_name',			'on'	),
				array( 7,		$pro_label[6],	'o_role',			'on'	),
				array( 8,		$pro_label[7],	'o_website',		'on'	),
				array( 9,		$pro_label[8],	'o_bioginfo',		'on'	),
				array( 9,		$pro_label[9],	'o_msince',			'on'	),
				array( 10,		$pro_label[10],	'o_savebtn',		'on'	),
				array( 11,		$pro_label[11],	'o_chpwhead',		'on'	),
				array( 12,		$pro_label[12],	'o_curpassword',	'on'	),
				array( 13,		$pro_label[13],	'o_newpassword',	'on'	),
				array( 14,		$pro_label[14],	'o_confpassword',	'on'	),
				array( 15,		$pro_label[15],	'o_chgpwbtn',		'on'	)
			);
			update_option( 'wtb_profile_fields', $profile_fields_shownhide_initial ); 

			$wtb_profile_noti_en = array( 
				'Your profile has been saved successfully.',						//[0]
				'Update failed! Please check your account(E-mail) information.',	//[1]
				'Update failed! Please check your account information.',			//[2]
				'Your password changed successfully.',								//[3]
				'The change password operation failed.'								//[4]
			);
			update_option( 'wtb_profile_noti_en', $wtb_profile_noti_en);
			
			$wtb_profile_noti_ko = array( 
				'프로파일 정보가 성공적으로 변경되었습니다.',							//[0]
				'업데이트에 실패했습니다. 올바른 이메일을 입력했는지 확인해 주세요.',	//[1]
				'저장에 실패했습니다. 입력하신 계정 정보를 다시 확인해 주세요.',		//[2]
				'암호가 성공적으로 변경되었습니다.',									//[3]
				'암호 변경에 실패했습니다.'											//[4]
			);
			update_option( 'wtb_profile_noti_ko', $wtb_profile_noti_ko);

			$wtb_profile_noti_ja = array( 
				'プロフィールが保存されました。',							//[0]
				'更新失敗！ アカウント（メール）情報をご確認ください。',		//[1]
				'更新失敗！ アカウント情報をご確認ください。',				//[2]
				'パスワードが変更されました。',								//[3]
				'パスワードの変更操作が失敗しました。'						//[4]
			);
			update_option( 'wtb_profile_noti_ja', $wtb_profile_noti_ja);

			$rpw_label=array();
			switch ($c_lang) {
				case 'ko_KR':
					$rpw_label[0]='비밀번호 찾기';					//[0]
					$rpw_label[1]='비밀번호를 찾고자 하는 아이디나 이메일을 입력하시면 회원 가입시 등록된 이메일로 새로운 비밀번호가 전송됩니다.';					//[1]
					$rpw_label[2]='아이디 또는 이메일';					//[2]
					$rpw_label[3]='새 비밀번호 신청';		//[3]
					$rpw_label[4]='구분선';					//[4]
					$rpw_label[5]='로그인';			//[5]
					break;
				case 'ja':
					$rpw_label[0]='パスワードを再設定する';				//[0]
					$rpw_label[1]='ユーザー名またはメールアドレスを入力してください。 メールで新しいパスワードを作成するためのリンクが届きます。';				//[1]
					$rpw_label[2]='ユーザー名またはメールアドレス';					//[2]
					$rpw_label[3]='新しいパスワードを取得';	//[3]
					$rpw_label[4]='セパレーター';				//[4]
					$rpw_label[5]='サインインに戻る';		//[5]
					break;
				default: //'en'
					$rpw_label[0]='Reset Password';			//[0]
					$rpw_label[1]='Please enter your username or email address. You will receive a link to create a new password via email. ';					//[1]
					$rpw_label[2]='Username or Email Address ';					//[2]
					$rpw_label[3]='Get new password';			//[3]
					$rpw_label[4]='Separator';					//[4]
					$rpw_label[5]='Back to Sign in';	//[5]
					break;	
			}// Language (End)
			$resetpw_fields_shownhide_initial = array(
				//	  Order		Label						variable			Display	
				array( 1,		$rpw_label[0],				'o_header',			'on'	),
				array( 2,		$rpw_label[1],				'o_desc',			'on'	),	
				array( 3,		$rpw_label[2],				'o_unameemail',		'on'	),
				array( 4,		$rpw_label[3],				'o_button',			'on'	),
				array( 5,		$rpw_label[4],				'o_separator',		'on'	),	
				array( 6,		$rpw_label[5],				'o_backtosin',		'on'	)
			);
			update_option( 'wtb_resetpw_fields', $resetpw_fields_shownhide_initial ); 

			$wtb_resetpw_noti_en = array( 
				'Password reset successfully! <br /><br />An email containing a new password has been sent to the email address on file for your account.',
				'Either the username or email address do not exist in our records.'
			);
			update_option( 'wtb_resetpw_noti_en', $wtb_resetpw_noti_en);
			
			$wtb_resetpw_noti_ko = array( 
				'새로운 비밀번호가 등록하신 이메일로 전송되었습니다. 메일이 수신함에 없을 경우 스팸으로 분류되었는지 다시 한번 확인해 주시기 바랍니다.',
				'존재하지 않는 아이디나 이메일입니다. .'
			);
			update_option( 'wtb_resetpw_noti_ko', $wtb_resetpw_noti_ko);

			$wtb_resetpw_noti_ja = array( 
				'パスワードのリセットに成功しました！ <br /> <br />新しいパスワードを含むメールが、アカウントに登録されているメールアドレスに送信されました。',
				'ユーザー名またはメールアドレスのいずれかが記録に存在しません。'
			);
			update_option( 'wtb_resetpw_noti_ja', $wtb_resetpw_noti_ja);

			$em_resetpw_title	= '[bloginfo]';
			$em_resetpw_header	= 'You recentely requested to reset your password for your account.<br/> Your new password is included below.<br/> You may wish to retain a copy for your records.';
			$em_resetpw_body	= 'Username: [username] <br/> Password: [password]';
			$em_resetpw_footer	= 'This is an automated message. Please do not reply to this address.	Thanks, ';

			$em_resetpw_title_ko	= '[bloginfo]';
			$em_resetpw_header_ko	= '암호 초기화를 요청하셨습니다. <br/> 아래 보내드린 새 암호로 로그인 하시기 바랍니다.';
			$em_resetpw_body_ko	= '아이디: [username] <br/> 패스워드: [password]';
			$em_resetpw_footer_ko	= '본 메일은 발신전용 메일이므로 문의 및 회신하실 경우 답변되지 않습니다.';

			$em_resetpw_title_ja	= '[bloginfo]';
			$em_resetpw_header_ja	= '最近、アカウントのパスワードをリセットするように要求しました。<br/>新しいパスワードは以下に含まれています。<br/>記録用にコピーを保持したい場合があります。';
			$em_resetpw_body_ja	= 'ユーザ名: [username] <br/> パスワード: [password]';
			$em_resetpw_footer_ja	= 'これは自動メッセージです。このアドレスには返信しないでください。';

			$email_resetpw_en = array(
				//	  Order		Description		Variable			Content	
				array( 1,		'Title',		'em_title',			$em_resetpw_title	),
				array( 2,		'Header',		'em_header',		$em_resetpw_header	),
				array( 3,		'Body',			'em_body',			$em_resetpw_body	),	
				array( 4,		'Footer',		'em_footer',		$em_resetpw_footer	)
			);	
			update_option( 'wtb_resetpw_email_en', $email_resetpw_en ); 

			$email_resetpw_ko = array(
				//	  Order		Description		Variable			Content	
				array( 1,		'Title',		'em_title',			$em_resetpw_title_ko	),
				array( 2,		'Header',		'em_header',		$em_resetpw_header_ko	),
				array( 3,		'Body',			'em_body',			$em_resetpw_body_ko	),	
				array( 4,		'Footer',		'em_footer',		$em_resetpw_footer_ko	)
			);	
			update_option( 'wtb_resetpw_email_ko', $email_resetpw_ko ); 

			$email_resetpw_ja = array(
				//	  Order		Description		Variable			Content	
				array( 1,		'Title',		'em_title',			$em_resetpw_title_ja	),
				array( 2,		'Header',		'em_header',		$em_resetpw_header_ja	),
				array( 3,		'Body',			'em_body',			$em_resetpw_body_ja	),	
				array( 4,		'Footer',		'em_footer',		$em_resetpw_footer_ja	)
			);	
			update_option( 'wtb_resetpw_email_ja', $email_resetpw_ja ); 

			$em_email_from_name = get_bloginfo( 'name');
			$admin_email = get_option( 'admin_email' );
			$email_sender_initial = array(
				//	  Order		
				array( 1,		'From Email',	'em_from_email',	$admin_email	),
				array( 2,		'From Name',	'em_from_name',		$em_email_from_name	)
			);
			update_option( 'wtb_esender_fields', $email_sender_initial ); 

			$wtbsinup_skin = array( 
				'default',	//$wtbsinup_skin[0] : default
				0,	//$wtbsinup_skin[1] : 
				0,	//$wtbsinup_skin[2] : 
				0,	//$wtbsinup_skin[3] : 
				0,	//$wtbsinup_skin[4] : 
				0	//$wtbsinup_skin[5] : 
			);
			update_option( 'wtbsinup_skin', $wtbsinup_skin);

		} 
		else 
		{
			// If it is not first installation
		}
	}

	public function wtb_form_actions() {	
		global $wtb_sinup_act;
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );

		$wtbsinup_lang = get_option( 'wtbsinup_lang' );
		if( isset($wtbsinup_lang[0]) && !empty($wtbsinup_lang[0]) ) {	$lang = $wtbsinup_lang[0]; } else { $lang = 'en_US'; }
		
		switch ($lang) {
				case 'ko_KR':	
						$wtb_signin_noti_ko = get_option('wtb_signin_noti_ko');
						if(isset($wtb_signin_noti_ko)) 
						{
							$sinnoti_0 = 	$wtb_signin_noti_ko[0];
							$sinnoti_1 = 	$wtb_signin_noti_ko[1];
							$sinnoti_2 = 	$wtb_signin_noti_ko[2];
							$sinnoti_3 = 	$wtb_signin_noti_ko[3];
						}
						$wtb_signup_noti_ko = get_option('wtb_signup_noti_ko');
						if(isset($wtb_signup_noti_ko)) 
						{
							$supnoti_0 = 	$wtb_signup_noti_ko[0];$supnoti_1 = 	$wtb_signup_noti_ko[1];
							$supnoti_2 = 	$wtb_signup_noti_ko[2];$supnoti_3 = 	$wtb_signup_noti_ko[3];
							$supnoti_4 = 	$wtb_signup_noti_ko[4];$supnoti_5 = 	$wtb_signup_noti_ko[5];
							$supnoti_6 = 	$wtb_signup_noti_ko[6];$supnoti_7 = 	$wtb_signup_noti_ko[7];
						}
					break;
				case 'ja':
						$wtb_signin_noti_ja = get_option('wtb_signin_noti_ja');
						if(isset($wtb_signin_noti_ja)) 
						{
							$sinnoti_0 = 	$wtb_signin_noti_ja[0];
							$sinnoti_1 = 	$wtb_signin_noti_ja[1];
							$sinnoti_2 = 	$wtb_signin_noti_ja[2];
							$sinnoti_3 = 	$wtb_signin_noti_ja[3];
						}
						$wtb_signup_noti_ja = get_option('wtb_signup_noti_ja');
						if(isset($wtb_signup_noti_ja)) 
						{
							$supnoti_0 = 	$wtb_signup_noti_ja[0];$supnoti_1 = 	$wtb_signup_noti_ja[1];
							$supnoti_2 = 	$wtb_signup_noti_ja[2];$supnoti_3 = 	$wtb_signup_noti_ja[3];
							$supnoti_4 = 	$wtb_signup_noti_ja[4];$supnoti_5 = 	$wtb_signup_noti_ja[5];
							$supnoti_6 = 	$wtb_signup_noti_ja[6];$supnoti_7 = 	$wtb_signup_noti_ja[7];
						}
					break;
				default: //'en'
						$wtb_signin_noti_en = get_option('wtb_signin_noti_en');
						if(isset($wtb_signin_noti_en)) 
						{
							$sinnoti_0 = 	$wtb_signin_noti_en[0];
							$sinnoti_1 = 	$wtb_signin_noti_en[1];
							$sinnoti_2 = 	$wtb_signin_noti_en[2];
							$sinnoti_3 = 	$wtb_signin_noti_en[3];
						}
						$wtb_signup_noti_en = get_option('wtb_signup_noti_en');
						if(isset($wtb_signup_noti_en)) 
						{
							$supnoti_0 = 	$wtb_signup_noti_en[0];$supnoti_1 = 	$wtb_signup_noti_en[1];
							$supnoti_2 = 	$wtb_signup_noti_en[2];$supnoti_3 = 	$wtb_signup_noti_en[3];
							$supnoti_4 = 	$wtb_signup_noti_en[4];$supnoti_5 = 	$wtb_signup_noti_en[5];
							$supnoti_6 = 	$wtb_signup_noti_en[6];$supnoti_7 = 	$wtb_signup_noti_en[7];
						}
					break;
		}

		if((isset($_POST['form_wtb_signin_submit'])) && ($_POST['form_wtb_signin_submit']=="Sign in")) {
			if ( is_user_logged_in() ) { return;}
		
			$signin_field_option = get_option( 'wtb_signin_fields' );
			$ERR_MSG = "";
			$SIN_ID = "";
			$SIN_PW = "";
			if((isset($signin_field_option[5][3])) && ($signin_field_option[5][3]=="on")) { $SIN_CAP_ONOFF=TRUE;}else {$SIN_CAP_ONOFF=FALSE;}
			$SIN_CAP_T = "";
			$SIN_REME = FALSE;
			$NEED_SIGNIN=TRUE;

			if( isset($_POST['sin_username']) || isset($_POST['sin_email']) || isset($_POST['sin_unameemail'])) {
				 
				if( !empty($_POST['sin_username'])) {$SIN_ID = sanitize_user( $_POST['sin_username']);}

				elseif( !empty($_POST['sin_email'])) {
					$SIN_EMAIL = sanitize_email($_POST['sin_email']); 
					$temp_user_sinemail = get_user_by( 'email', $SIN_EMAIL );
					if($temp_user_sinemail) $SIN_ID = $temp_user_sinemail->user_login;
				}
				elseif ( !empty($_POST['sin_unameemail'])) {
					if (is_email( $_POST['sin_unameemail'] )) { 
						$SIN_UNAMEEMAIL = sanitize_email($_POST['sin_unameemail']);
						$temp_user_sinunameemail = get_user_by( 'email', $SIN_UNAMEEMAIL );
						if($temp_user_sinunameemail) $SIN_ID = $temp_user_sinunameemail->user_login;
					}
					else { $SIN_ID = sanitize_user( $_POST['sin_unameemail'] ); }
				}
				else { $SIN_ID = ""; $ERR_MSG = $sinnoti_1; $NEED_SIGNIN=false;}
			}

			if( isset($_POST['sin_password'])) {
				if( !empty($_POST['sin_password'])) { $SIN_PW = $_POST['sin_password']; } 
				else {$SIN_PW =""; $ERR_MSG = $sinnoti_2;/*"Please fill out password."*/; $NEED_SIGNIN=false;}
			}

			if( (isset($_POST['sin_password'])) && (!empty($_POST['sin_password'])) && ($_POST['sin_password']=="on")) {
				$SIN_REME = TRUE;	
			}

			if($SIN_CAP_ONOFF) {
				process_sin_contact_form(); // Process the form, if it was submitted

				if (isset($_POST['ctform']['error']) &&  $_POST['ctform']['error'] == true) {
					$ERR_MSG =  $sinnoti_3;//__( 'You must enter a valid text.', WTB_TDOM );
					$NEED_SIGNIN=false;
				}
				elseif (isset($_POST['ctform']['success']) && $_POST['ctform']['success'] == true){ 
					//The captcha was correct and the message has been sent!  The captcha was solved in 
				}
			}

			$credentials = array();
			$credentials['user_login']=$SIN_ID;
			$credentials['user_password'] = $SIN_PW;
			$credentials['remember'] = $SIN_REME;

			if($NEED_SIGNIN) 
			{
				$sinin_user = wp_signon( $credentials, false );
			}

			if( isset($sinin_user) && !is_wp_error( $sinin_user ) ) {
					
				$Sin_userID = $sinin_user->ID;
				wp_set_current_user( $Sin_userID, $SIN_ID );
				wp_set_auth_cookie( $Sin_userID, true, is_ssl() );
				do_action( 'wp_login', $SIN_ID,10,2 );	

				if( (isset($wtbsigninup_setopt[0])) && (isset($wtbsigninup_setopt[3])) && ($wtbsigninup_setopt[3]!='0') && ($wtbsigninup_setopt[3]!=$wtbsigninup_setopt[0]))
				{
					wp_redirect(get_permalink($wtbsigninup_setopt[3]));
					exit();
				}
				elseif( (isset($wtbsigninup_setopt[3])) && ($wtbsigninup_setopt[3]=='0')) 
				{
					wp_redirect(WTBSIGN_REDHOME);
					exit();
				}
			}else {

				$_POST['sin_error']="yes";
				$_POST['sin_errmsg']=$ERR_MSG;
			}
		}

		if((isset($_POST['form_wtb_signup_submit'])) && ($_POST['form_wtb_signup_submit']=="Sign up")) {
			if ( is_user_logged_in() ) { return;}
			
			$signup_field_option = get_option( 'wtb_signup_fields' );
			$ERR_MSG = "";
			$SUP_ID = "";
			$SUP_EMAIL="";
			$SUP_PW = "";
			$SUP_CFPW= "";
			$SUP_CAP_T = "";
			$NEED_CREATE=TRUE;

			for($i=0;$i<9;$i++) 
			{
				//echo $i.":".$signup_field_option[$i][2]."<br>";
				if((isset($signup_field_option[$i][2])) && ($signup_field_option[$i][2]=="o_captcha")) 
				{
					if((isset($signup_field_option[$i][3])) && ($signup_field_option[$i][3]=="on")) { $SUP_CAP_ONOFF=TRUE;}else {$SUP_CAP_ONOFF=FALSE;}
				}
				if((isset($signup_field_option[$i][2])) && ($signup_field_option[$i][2]=="o_confirmpw")) 
				{
					if((isset($signup_field_option[$i][3])) && ($signup_field_option[$i][3]=="on")) { $SUP_CFPW_ONOFF=TRUE;}else {$SUP_CFPW_ONOFF=FALSE;}
				}
			}

			if( isset($_POST['sup_username']) && !empty($_POST['sup_username'])) 
			{
				$SUP_ID = sanitize_user( $_POST['sup_username']);
				$CHK_UID = username_exists( $SUP_ID );
			}
				
			if( isset($_POST['sup_email']) && !empty($_POST['sup_email'])) 
			{
				$SUP_EMAIL = sanitize_email( $_POST['sup_email']);
				$CHK_EMAIL = email_exists( $SUP_EMAIL );
			}

			if( isset($_POST['sup_password'])) 
			{
				if( !empty($_POST['sup_password'])) { $SUP_PW = $_POST['sup_password']; } 
			}

			if( isset($_POST['sup_confirmpw'])) 
			{
				if( !empty($_POST['sup_confirmpw'])) { $SUP_CFPW = $_POST['sup_confirmpw']; } 
			}

			if( isset($_POST['sup_captcha'])) 
			{
				if( !empty($_POST['sup_captcha'])) { $SUP_CAP_T = sanitize_text_field( $_POST['sup_captcha']); } 
			}
		
			if($CHK_UID) 
			{
				$NEED_CREATE=FALSE; 
				$ERR_MSG = $supnoti_1;//__('User ID already taken by others',WTB_TDOM);
			}
			elseif(empty($SUP_ID)) 
			{
				$NEED_CREATE=FALSE;
				$ERR_MSG =  $supnoti_2;//__('This username is not valid',WTB_TDOM);
			}
			elseif( $CHK_EMAIL )
			{
				$NEED_CREATE=FALSE;
				$ERR_MSG =  $supnoti_3;//__('Email already taken by others',WTB_TDOM);
			}
			elseif(empty($SUP_EMAIL)) 
			{
				$NEED_CREATE=FALSE;
				$ERR_MSG =  $supnoti_4;//__('This email is not valid',WTB_TDOM);
			}
			elseif(empty($SUP_PW)) 
			{
				$NEED_CREATE=FALSE;
				$ERR_MSG = $supnoti_5;// __('This password is not valid',WTB_TDOM);
			}
			else 
			{
				if($SUP_CFPW_ONOFF) 
				{
					if( $SUP_PW != $SUP_CFPW)
					{
						$NEED_CREATE=FALSE;
						$ERR_MSG = $supnoti_6;// __('Password did not match',WTB_TDOM);
					}
				}
				if($SUP_CAP_ONOFF) 
				{
					process_sup_contact_form(); // Process the form, if it was submitted
					if (isset($_POST['ctform']['error']) &&  $_POST['ctform']['error'] == true) {
						$ERR_MSG =   $supnoti_7;//__( 'You must enter a valid text.', WTB_TDOM );
						$NEED_CREATE=FALSE;
					}
					elseif (isset($_POST['ctform']['success']) && $_POST['ctform']['success'] == true){ 
					}
				}
			}

			if($NEED_CREATE) 
			{
				$new_user = wp_create_user( $SUP_ID, $SUP_PW, $SUP_EMAIL );
				if( ! is_wp_error( $new_user ) ) 
				{
					$_POST['sup_error']="no";
					if( (isset($wtbsigninup_setopt[1])) && (isset($wtbsigninup_setopt[4])) && ($wtbsigninup_setopt[4]!='0') && ($wtbsigninup_setopt[4]!=$wtbsigninup_setopt[1]))
					{
						wp_redirect(get_permalink($wtbsigninup_setopt[4]));
						exit();
					}
					elseif( (isset($wtbsigninup_setopt[4])) && ($wtbsigninup_setopt[4]=='0')) 
					{
						wp_redirect(WTBSIGN_REDHOME);
						exit();
					}
				}
				else 
				{
					$_POST['sup_error']="yes";
				}
			}
			else {
				$_POST['sup_error']="yes";
			}
			$_POST['sup_errmsg']=$ERR_MSG;
		}
	}

	public function wtb_signinup_lostpassword_url() {
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
		if(isset($wtbsigninup_setopt[0]) && !empty($wtbsigninup_setopt[0]) ) {
			$lost_password_url = get_permalink( $wtbsigninup_setopt[0] );
			$lost_password_url=substr($lost_password_url, 0, -1);
			$lost_password_url .= "?action=lostpassword";
			return $lost_password_url;
		}
	}

	public function shortcode_signin()
	{
		if(isset($_GET['action']) && ($_GET['action']=="lostpassword")) { 
			load_template( PWRESET_HTML);
		}
		elseif(isset($_GET['action']) && ($_GET['action']=="sentpassword")) {
			load_template( PWSENT_HTML );
		}
		else { 
			load_template(SIGNIN_HTML);
		}
	}

	public function shortcode_signup()
	{
		load_template( SIGNUP_HTML );
	}

	public function shortcode_profile(){
		$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );

		if ( is_user_logged_in() ) 
		{
			load_template(PROFILE_HTML);
		}
	}

	public function reset_wptobe_signinup_func() {
		check_ajax_referer('chg_reinitialize_wptobe_signinup', 'security');

		if(isset($_POST['reset_val']) && !empty($_POST['reset_val']) && ($_POST['reset_val']=='reset') ) {
			$this->wptobe_signinup_install(true);
		}
		else {
			_e("Reset failed",WTB_TDOM);
		}
		wp_die();
	}
}