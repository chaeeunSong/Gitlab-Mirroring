<?php 
	$signin_field_order = get_option( 'wtb_signin_fields' );
	$wtbsigninup_setopt = get_option( 'wtbsigninup_setopt' );
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

 <div class="wtbfe-signin-pgtitlebox">
	<div class="wtbfe-signin-pgtitle-wrapper">
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
					default:
						break;
				}//switch
			  }//if
			}//foreach
		?>
	</div>
 </div>
 
 <div class="wtbfe-signin-box">
  <div class="wtbfe-signin-inner">
	<div class="wtbfe-signin-fields-wrapper">

        <div class="easy_login">
            <div class="easy_login_wrap">

                <div class="kakao_login">
                    <!-- 카카오 간편로그인 api -->
                    <a href="#0" id="kakaoLogin"><img src="https://ivenet02.cafe24.com/brandshop/kakao_login2.png" alt="카카오계정 로그인"/></a>
                    <!--<a href="#0" id="kakaoLogout"><img src="https://ivenet02.cafe24.com/brandshop/kakao_loginout.png" alt="카카오계정 로그아웃"/></a>-->

                    <script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
                    <script>
                        function saveToDos(token) { //item을 localStorage에 저장합니다.
                            typeof(Storage) !== 'undefined' && sessionStorage.setItem('AccessKEY', JSON.stringify(token));
                        };

                        window.Kakao.init('c67fe9f893b1825d518ba612f35a64fc');

                        function kakaoLogin() {
                            window.Kakao.Auth.login({
                                scope: 'profile_nickname, account_email', //동의항목 페이지에 있는 개인정보 보호 테이블의 활성화된 ID값을 넣습니다.
                                success: function(response) {
                                    saveToDos(response.access_token)  // 로그인 성공하면 사용자 엑세스 토큰 sessionStorage에 저장
                                    window.Kakao.API.request({ // 사용자 정보 가져오기
                                        url: '/v2/user/me',
                                        success: (res) => {
                                            const kakao_account = res.kakao_account;
                                            alert('로그인 성공');
                                            window.location.href='https://brand.venet.kr/wp-content/plugins/wordpress-social-login/hybridauth/callbacks/kakao.php'
                                        }
                                    });
                                },
                                fail: function(error) {
                                    console.log(error);
                                }
                            });
                        };

                        const login = document.querySelector('#kakaoLogin');
                        login.addEventListener('click', kakaoLogin);
                    </script>
                    <script>

                        window.Kakao.init('c67fe9f893b1825d518ba612f35a64fc');
                        window.Kakao.Auth.setAccessToken(JSON.parse(sessionStorage.getItem('AccessKEY'))); //sessionStorage에 저장된 사용자 엑세스 토큰 받아온다.

                        function kakaoLogout() {
                            if (!Kakao.Auth.getAccessToken()) {
                                console.log('Not logged in.');
                                return;
                            }
                            Kakao.Auth.logout(function(response) {
                                alert(response +' logout');
                                window.location.href='/'
                            });
                        };

                        function secession() {
                            Kakao.API.request({
                                url: '/v1/user/unlink',
                                success: function(response) {
                                    console.log(response);
                                    //callback(); //연결끊기(탈퇴)성공시 서버에서 처리할 함수
                                    window.location.href='/'
                                },
                                fail: function(error) {
                                    console.log('탈퇴 미완료')
                                    console.log(error);
                                },
                            });
                        };

                        const logout = document.querySelector('#kakaoLogout');
                        const sion = document.querySelector('#secession');

                        logout.addEventListener('click', kakaoLogout);
                        sion.addEventListener('click', secession);
                    </script>
                </div>

                <!-- 네이버 간편로그인 api -->
                <div class="naver_login">
                    <div>
                        <div>
                            <!-- 아래와같이 아이디를 꼭 써준다. -->
                            <a id="naverIdLogin_loginButton" href="javascript:void(0)">
                                <img src="https://ivenet02.cafe24.com/brandshop/naver_login2.png" alt="">
                            </a>
                        </div>
                        <!--<div onclick="naverLogout(); return false;">
                            <a href="javascript:void(0)">
                                <img src="https://ivenet02.cafe24.com/brandshop/naver_logout.png" alt="">
                            </a>
                        </div>-->
                    </div>

                    <!-- 네이버 스크립트 -->
                    <script src="https://static.nid.naver.com/js/naveridlogin_js_sdk_2.0.2.js" charset="utf-8"></script>

                    <script>

                        var naverLogin = new naver.LoginWithNaverId(
                            {
                                clientId: "Dkev_M65pD9vSrxwMgeJ", //내 애플리케이션 정보에 cliendId를 입력해줍니다.
                                callbackUrl: "https://brand.venet.kr/wp-content/plugins/wordpress-social-login/hybridauth/callbacks/naver.php", // 내 애플리케이션 API설정의 Callback URL 을 입력해줍니다.
                                isPopup: false,
                                callbackHandle: true
                            }
                        );

                        naverLogin.init();

                        window.addEventListener('load', function () {
                            naverLogin.getLoginStatus(function (status) {
                                if (status) {
                                    var email = naverLogin.user.getEmail(); // 필수로 설정할것을 받아와 아래처럼 조건문을 줍니다.

                                    console.log(naverLogin.user);

                                    if( email == undefined || email == null) {
                                        alert("이메일은 필수정보입니다. 정보제공을 동의해주세요.");
                                        naverLogin.reprompt();
                                        return;
                                    }
                                } else {
                                    console.log("callback 처리에 실패하였습니다.");
                                }
                            });
                        });


                        var testPopUp;
                        function openPopUp() {
                            testPopUp= window.open("https://nid.naver.com/nidlogin.logout", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,width=1,height=1");
                        }
                        function closePopUp(){
                            testPopUp.close();
                        }

                        function naverLogout() {
                            openPopUp();
                            setTimeout(function() {
                                closePopUp();
                            }, 1000);


                        }
                    </script>
                </div>

                <div class="sns_login">
                    <div class="wp-social-login-widget">
                        <div class="wp-social-login-provider-list">
                            <a rel="nofollow" href="https://brand.venet.kr/wp-login.php?action=wordpress_social_authenticate&amp;mode=login&amp;provider=Facebook&amp;redirect_to=https%3A%2F%2Fbrand.venet.kr%2Fwp-login.php%3Floggedout%3Dtrue%26wp_lang%3Dko_KR" title="Facebook: 사용하여 연동" class="wp-social-login-provider wp-social-login-provider-facebook" data-provider="Facebook" role="button" style="text-decoration:none;">
                                <img alt="Facebook" src="https://ivenet02.cafe24.com/brandshop/facebook_login2.png" aria-hidden="true">
                            </a>
                            <a rel="nofollow" href="https://brand.venet.kr/wp-login.php?action=wordpress_social_authenticate&amp;mode=login&amp;provider=Google&amp;redirect_to=https%3A%2F%2Fbrand.venet.kr%2Fwp-login.php%3Floggedout%3Dtrue%26wp_lang%3Dko_KR" title="Google: 사용하여 연동" class="wp-social-login-provider wp-social-login-provider-google" data-provider="Google" role="button">
                                <img alt="Google" src="https://ivenet02.cafe24.com/brandshop/google_login2.png" aria-hidden="true">
                            </a>
                        </div> <!-- / div.wp-social-login-connect-options -->

                        <div class="wp-social-login-widget-clearing"></div>

                    </div> <!-- / div.wp-social-login-widget -->
                </div>
            </div>

        </div>


		<?php
			foreach($signin_field_order as $value) {
			  if($value[3]=='on') {
				switch ($value[2]) {

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
					case 'o_signuplink':
						?>
						<div class="wtbfe-input-field sin_signuplink">
							<a href="<?php if ( (isset($wtbsigninup_setopt[1])) && ($wtbsigninup_setopt[1]!=1) ) echo get_permalink($wtbsigninup_setopt[1]); else echo "#";?>"> <?php if(isset($value[1])) echo esc_html($value[1]);?> </a>
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

