<?php

// Do not allow the file to be called directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class is used to handle anything multisite related.
 */
class P_Multisite extends P_Core {

	/**
	 * Stores any license activation errors.
	 *
	 * @var string
	 */
	public $error = '';

	/**
	 * Add the actions required for the multisite functionality.
	 *
	 * @param Patchstack $core
	 * @return void
	 */
	public function __construct( $core ) {
		parent::__construct( $core );
		if ( ! is_super_admin() ) {
			return;
		}

		// When settings are saved.
		if ( isset( $_POST['option_page'], $_POST['PatchstackNonce'] ) && wp_verify_nonce( $_POST['PatchstackNonce'], 'patchstack-option-page' ) ) {
			$this->save_settings();
		}

		// When sites are activated.
		if ( isset( $_POST['patchstack_do'], $_POST['PatchstackNonce'], $_POST['sites'] ) && $_POST['patchstack_do'] == 'do_licenses' && wp_verify_nonce( $_POST['PatchstackNonce'], 'patchstack-multisite-activation' ) ) {
			$this->activate_licenses();
		}
	}

	/**
	 * When a user selects sites that need to be activated.
	 *
	 * @return string
	 */
	private function activate_licenses() {
		if ( empty( $_POST['sites'] ) ) {
			$this->error = '<span style="color: #ff6262;">Please select at least 1 site to be activated.</span><br /><br />';
			return;
		}

		// Determine which sites are already activated and skip those.
		$activate = array();
		$sites    = get_sites();
		foreach ( $sites as $site ) {
			if ( in_array( $site->siteurl, $_POST['sites'] ) && get_blog_option( $site->id, 'patchstack_clientid' ) == '' ) {
				array_push( $activate, $site->siteurl );
			}
		}

		// Make sure there is a site that can be activated.
		if ( count( $activate ) == 0 ) {
			$this->error = '<span style="color: #ff6262;">None of the selected sites need activation.</span><br /><br />';
			return;
		}

		// Add the site to the app and retrieve the license for each site.
		$licenses = $this->plugin->api->get_site_licenses( array( 'sites' => $activate ) );

		// Did an error happen during the multisite license activation?
		if ( isset( $licenses['error'] ) ) {
			$this->error = '<span style="color: #ff6262;">' . $licenses['error'] . '</span><br /><br />';
			return;
		}

		// Activate licenses on given sites
		$sites = get_sites();
		foreach ( $sites as $site ) {
			if ( isset( $licenses[ $site->siteurl ] ) ) {
				$this->plugin->activation->activate_multisite_license( $site, $licenses[ $site->siteurl ] );
			}
		}
	}

	/**
	 * When the individual or global settings are saved.
	 *
	 * @return void
	 */
	private function save_settings() {
		switch ( $_POST['option_page'] ) {
			// Save hardening options
			case 'patchstack_hardening_settings_group':
				$options = array( 'patchstack_auto_update', 'patchstack_json_is_disabled', 'patchstack_register_email_blacklist', 'patchstack_move_logs', 'patchstack_basicscanblock', 'patchstack_userenum', 'patchstack_hidewpversion', 'patchstack_activity_log_is_enabled', 'patchstack_activity_log_failed_logins', 'patchstack_xmlrpc_is_disabled', 'patchstack_captcha_on_comments', 'patchstack_captcha_login_form', 'patchstack_captcha_registration_form', 'patchstack_captcha_reset_pwd_form', 'patchstack_captcha_type', 'patchstack_captcha_public_key', 'patchstack_captcha_public_key_v3', 'patchstack_captcha_public_key_v3_new', 'patchstack_captcha_private_key', 'patchstack_captcha_private_key_v3', 'patchstack_captcha_private_key_v3_new', 'patchstack_application_passwords_disabled' );
				$this->save_options( $options );
				break;

			// Save firewall settings
			case 'patchstack_firewall_settings_group':
				$options = array( 'patchstack_geo_block_countries', 'patchstack_geo_block_enabled', 'patchstack_geo_block_inverse', 'patchstack_ip_block_list', 'patchstack_basic_firewall', 'patchstack_autoblock_blocktime', 'patchstack_autoblock_attempts', 'patchstack_autoblock_minutes', 'patchstack_basic_firewall_roles', 'patchstack_disable_htaccess', 'patchstack_add_security_headers', 'patchstack_prevent_default_file_access', 'patchstack_block_debug_log_access', 'patchstack_index_views', 'patchstack_proxy_comment_posting', 'patchstack_image_hotlinking', 'patchstack_firewall_custom_rules', 'patchstack_firewall_custom_rules_loc', 'patchstack_blackhole_log', 'patchstack_whitelist', 'patchstack_firewall_ip_header' );
				$this->save_options( $options );
				break;

			// Save login settings
			case 'patchstack_login_settings_group':
				$options = array( 'patchstack_mv_wp_login', 'patchstack_rename_wp_login', 'patchstack_block_bruteforce_ips', 'patchstack_anti_bruteforce_blocktime', 'patchstack_anti_bruteforce_attempts', 'patchstack_anti_bruteforce_minutes', 'patchstack_login_time_block', 'patchstack_login_time_start', 'patchstack_login_time_end', 'patchstack_login_2fa', 'patchstack_login_whitelist' );
				$this->save_options( $options );
				break;

			// Save cookie notice settings
			case 'patchstack_cookienotice_settings_group':
				$options = array( 'patchstack_enable_cookie_notice_message', 'patchstack_cookie_notice_message', 'patchstack_cookie_notice_accept_text', 'patchstack_cookie_notice_backgroundcolor', 'patchstack_cookie_notice_textcolor', 'patchstack_cookie_notice_privacypolicy_enable', 'patchstack_cookie_notice_privacypolicy_text', 'patchstack_cookie_notice_privacypolicy_link', 'patchstack_cookie_notice_cookie_expiration', 'patchstack_cookie_notice_opacity', 'patchstack_cookie_notice_credits' );
				$this->save_options( $options );
				break;
		}
	}

	/**
	 * This will be called when the network admin clicks on the "Sites" button.
	 * It will show all sites.
	 *
	 * @return void
	 */
	public function sites_section_callback() {
		require_once dirname( __FILE__ ) . '/views/pages/multisite-table.php';
	}

	/**
	 * Save an array of options on a specific site.
	 *
	 * @param array $options
	 * @return void
	 */
	private function save_options( $options ) {
		if ( isset( $_GET['page'] ) && $_GET['page'] == 'patchstack-multisite-settings' ) {
			foreach ( $options as $option ) {
				$value = isset( $_POST[ $option ] ) ? $_POST[ $option ] : 0;
				$value = map_deep( $value, 'wp_filter_nohtml_kses' );
				update_site_option( $option, $value );
			}
		} else {
			foreach ( $options as $option ) {
				$value = isset( $_POST[ $option ] ) ? $_POST[ $option ] : 0;
				$value = map_deep( $value, 'wp_filter_nohtml_kses' );
				update_option( $option, $value );
			}
		}
	}
}
