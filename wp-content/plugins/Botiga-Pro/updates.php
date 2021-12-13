<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function botiga_pro_licensing_menu() {
	add_plugins_page( 'Botiga Pro License', 'Botiga Pro License', 'manage_options', 'botiga-pro-license', 'botiga_pro_license_page' );
}
add_action('admin_menu', 'botiga_pro_licensing_menu');

function botiga_pro_license_page() {
	$license 	= get_option( 'botiga_pro_license_key' );
	$status 	= get_option( 'botiga_pro_license_status' );

	?>
	<div class="wrap">
		<h2><?php _e('Botiga Pro License Options'); ?></h2>
		<form method="post" action="options.php">

			<?php settings_fields('botiga_pro_license'); ?>

			<table class="form-table">

				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>
							<input id="botiga_pro_license_key" name="botiga_pro_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="botiga_pro_license_key"><?php _e('Enter your license key'); ?></label>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e('Activate License'); ?>
							</th>
							<td>
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<span style="color:green;"><?php _e('active'); ?></span>
									<?php wp_nonce_field( 'botiga_pro_nonce', 'botiga_pro_nonce' ); ?>
									<input type="submit" class="button-secondary" name="botiga_pro_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
								<?php } else {
									wp_nonce_field( 'botiga_pro_nonce', 'botiga_pro_nonce' ); ?>
									<input type="submit" class="button-secondary" name="botiga_pro_license_activate" value="<?php _e('Activate License'); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php submit_button(); ?>

		</form>
	<?php
}

function botiga_pro_register_option() {
	// creates our settings in the options table
	register_setting('botiga_pro_license', 'botiga_pro_license_key', 'botiga_pro_sanitize_license' );
}
add_action('admin_init', 'botiga_pro_register_option');

function botiga_pro_sanitize_license( $new ) {
	$old = get_option( 'botiga_pro_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'botiga_pro_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

function botiga_pro_activate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['botiga_pro_license_activate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'botiga_pro_nonce', 'botiga_pro_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'botiga_pro_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'activate_license',
			'license' 	=> $license,
			'item_name' => urlencode( ATHEMES_PLUGIN_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( ATHEMES_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "valid" or "invalid"

		update_option( 'botiga_pro_license_status', $license_data->license );

	}
}
add_action('admin_init', 'botiga_pro_activate_license');

function botiga_pro_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['botiga_pro_license_deactivate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'botiga_pro_nonce', 'botiga_pro_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'botiga_pro_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license' 	=> $license,
			'item_name' => urlencode( ATHEMES_PLUGIN_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( ATHEMES_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' )
			delete_option( 'botiga_pro_license_status' );

	}
}
add_action('admin_init', 'botiga_pro_deactivate_license');

/**
 * License notice
 */
function botiga_pro_admin_notice(){

	$license = get_option( 'botiga_pro_license_key' );

	if (!$license) {
	    echo '<div class="updated">';
	    echo 	'<p>Please activate your license key for Botiga Pro to get the latest plugin updates automatically. You can get your key from your <a href="https://athemes.com/your-account/" target="_blank">aThemes account</a> and activate it <a href="' . menu_page_url( 'botiga-pro-license', 0 ) . '">here</a></p>';
	    echo '</div>';
	}
}
add_action('admin_notices', 'botiga_pro_admin_notice');