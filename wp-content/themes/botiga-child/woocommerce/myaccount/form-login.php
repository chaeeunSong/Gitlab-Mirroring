<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

<div class="u-columns col2-set" id="customer_login">

    <div class="u-column1 col-1">

        <?php endif; ?>

        <h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>

        <form class="woocommerce-form woocommerce-form-login login" method="post">

            <?php do_action( 'woocommerce_login_form_start' ); ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row f


            orm-row-wide">
                <label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
            </p>

            <?php do_action( 'woocommerce_login_form' ); ?>

            <p class="form-row">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
                </label>
                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
            </p>
            <p class="woocommerce-LostPassword lost_password">
                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
            </p>

            <?php do_action( 'woocommerce_login_form_end' ); ?>

            <!-- 네이버 간편로그인 api -->
            <div class="naver_login">
                <div>
                    <div>
                        <!-- 아래와같이 아이디를 꼭 써준다. -->
                        <a id="naverIdLogin_loginButton" href="javascript:void(0)">
                            <img src="https://ivenet02.cafe24.com/brandshop/naver_login.png" alt="">
                        </a>
                    </div>
                    <div onclick="naverLogout(); return false;">
                        <a href="javascript:void(0)">
                            <img src="https://ivenet02.cafe24.com/brandshop/naver_logout.png" alt="">
                        </a>
                    </div>
                </div>

                <!-- 네이버 스크립트 -->
                <script src="https://static.nid.naver.com/js/naveridlogin_js_sdk_2.0.2.js" charset="utf-8"></script>

                <script>

                    var naverLogin = new naver.LoginWithNaverId(
                        {
                            clientId: "Dkev_M65pD9vSrxwMgeJ", //내 애플리케이션 정보에 cliendId를 입력해줍니다.
                            callbackUrl: "https://brand.venet.kr", // 내 애플리케이션 API설정의 Callback URL 을 입력해줍니다.
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

            <div class="kakao_login">

                <!-- 카카오 간편로그인 api -->
                <a href="#0" id="kakaoLogin"><img src="https://ivenet02.cafe24.com/brandshop/kakao_login.png" alt="카카오계정 로그인"/></a>
                <a href="#0" id="kakaoLogout"><img src="https://ivenet02.cafe24.com/brandshop/kakao_loginout.png" alt="카카오계정 로그아웃"/></a>

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
                                        window.location.href='https://brand.venet.kr/'
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

        </form>

        <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

    </div>

    <div class="u-column2 col-2">

        <h2><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>

        <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

            <?php do_action( 'woocommerce_register_form_start' ); ?>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </p>

            <?php endif; ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </p>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
                </p>

            <?php else : ?>

                <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

            <?php endif; ?>

            <?php do_action( 'woocommerce_register_form' ); ?>

            <p class="woocommerce-form-row form-row">
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
            </p>

            <?php do_action( 'woocommerce_register_form_end' ); ?>

        </form>

    </div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
