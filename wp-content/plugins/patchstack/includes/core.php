<?php

// Do not allow the file to be called directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The core class is used as a base class for all the other classes.
 * This will allow us to declare certain global methods/variables.
 */
class P_Core {

	/**
	 * This will allow us to communicate between classes.
	 *
	 * @var Patchstack
	 */
	public $plugin;

	/**
	 * Whether or not the site is a multisite.
	 *
	 * @var boolean
	 */
	private $is_multi_site = false;

	/**
	 * Allowed HTML for the wp_kses function used to render certain paragraphs of texts.
	 * 
	 * @var array
	 */
	public $allowed_html = array(
		'a'        => array(
			'href'     => array(),
			'title'    => array(),
			'target'    => array()
		),
		'p'        => array(
			'style'    => array()
		),
		'span'     => array(
			'style'    => array()
		),
		'br'       => array(),
		'strong'   => array(),
		'b'        => array(),
		'i'		   => array(
			'style'    => array()
		),
		'label'	   => array(
			'for'      => array(),
			'style'    => array()
		),
		'input'    => array(
			'type' 	   => array(),
			'class'	   => array(),
			'name'	   => array(),
			'id'  	   => array(),
			'value'    => array(),
			'checked'  => array(),
			'style'    => array()
		),
		'textarea' => array(
			'rows'     => array(),
			'id'       => array(),
			'name'     => array()
		),
		'select'   => array(
			'name'     => array(),
			'id'       => array(),
			'data-selected' => array()
		),
		'option'   => array(
			'value'    => array(),
			'selected' => array()
		),
		'table'    => array(
			'class'    => array(),
			'style'    => array()
		),
		'thead'    => array(),
		'th'       => array(
			'style'    => array()
		),
		'tr' 	   => array(),
		'td' 	   => array(),
		'div' 	   => array(
			'class'    => array(),
			'style'    => array()
		)
	);

	/**
	 * Some of the IP addresses of Patchstack.
	 * 
	 * @var array
	 */
	public $ips = array(
		'18.221.197.243',
		'52.15.237.250',
		'3.19.3.34',
		'3.18.238.17',
		'13.58.49.77',
		'18.222.191.77',
		'3.131.108.250',
		'3.23.157.140',
		'18.220.70.233',
		'3.140.84.221',
		'185.212.171.100',
		'3.133.121.93',
		'18.219.61.133',
		'3.14.29.150'
	);

	/**
	 * @param Patchstack $plugin
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->plugin        = $plugin;
		$this->is_multi_site = is_multisite();
	}

	/**
	 * In case of multisite we want to determine if there's a difference between the
	 * network setting and site setting and if so, use the site setting.
	 *
	 * @param string $name
	 * @param mixed  $default
	 * @return mixed
	 */
	public function get_option( $name, $default = false ) {
		// We always want to return the site option on the default settings management page.
		if ( isset( $_GET['page'] ) && $_GET['page'] == 'patchstack-multisite-settings' && is_super_admin() ) {
			return get_site_option( $name, $default );
		}

		// Get the setting of the current site.
		$secondary = get_option( $name, $default );

		// Get the setting of the network and in case there's a difference,
		// return the value of site.
		$main = get_site_option( $name, $default );
		return $main != $secondary ? $secondary : $main;
	}

	/**
	 * In case we need to retrieve the option of a specific site, we can use this.
	 * It will determine if it's on a multisite environment and if so, use get_blog_option.
	 *
	 * @param int    $site_id
	 * @param string $name
	 * @param mixed  $default
	 * @return mixed
	 */
	public function get_blog_option( $site_id, $name, $default = false ) {
		if ( $this->is_multi_site ) {
			return get_blog_option( $site_id, $name, $default );
		}

		return get_option( $name, $default );
	}

	/**
	 * In case we need to update the option of a specific site, we can use this.
	 * It will determine if it's on a multisite environment and if so, use update_blog_option.
	 *
	 * @param int    $site_id
	 * @param string $name
	 * @param mixed  $value
	 * @return mixed
	 */
	public function update_blog_option( $site_id, $name, $value ) {
		if ( $this->is_multi_site ) {
			return update_blog_option( $site_id, $name, $value );
		}

		return update_option( $name, $value );
	}

	/**
	 * Determine if the license is active and not expired.
	 *
	 * @return boolean
	 */
	public function license_is_active() {
		if ( get_option( 'patchstack_license_activated', 0 ) ) {
			return true;
		}

		$expiry = get_option( 'patchstack_license_expiry', '' );
		if ( $expiry != '' && ( strtotime( $expiry ) < ( time() + ( 3600 * 24 ) ) ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Grab the IP address of the user. Give the override IP header priority.
	 * If this does not exist, we should always default to REMOTE_ADDR.
	 *
	 * @return string
	 */
	public function get_ip() {
		$override = get_site_option( 'patchstack_firewall_ip_header', '' );
		if ( $override != '' && isset( $_SERVER[ $override ] ) ) {
			return $_SERVER[ $override ];
		}

		return isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '';
	}

	/**
	 * Grab the secret key used for API communication.
	 * 
	 * @param string $custom
	 * @return string
	 */
	public function get_secret_key( $custom = '' ) {
		if ( $custom != '' ) {
			return $this->encrypt( $custom );
		}

		$secret = get_option( 'patchstack_secretkey', '' );
		if ( ! $secret ) {
			return '';
		}

		if ( strlen( $secret ) === 40 ) {
			$enc = $this->encrypt( $secret );

			update_option( 'patchstack_secretkey', $enc['cipher'] );
			update_option( 'patchstack_secretkey_nonce', $enc['nonce'] );

			return $secret;
		}

		$nonce = get_option( 'patchstack_secretkey_nonce' );
		return $this->decrypt( $secret, $nonce );
	}

	/**
	 * Set the secret key used for API communication.
	 * 
	 * @param string $secret
	 * @return void
	 */
	public function set_secret_key( $secret ) {
		$enc = $this->encrypt( $secret );

		update_option( 'patchstack_secretkey', $enc['cipher'] );
		update_option( 'patchstack_secretkey_nonce', $enc['nonce'] );
	}

	/**
	 * Determine which encryption dependency we can use.
	 * 
	 * @return string
	 */
	public function get_enc_type() {
		if ( function_exists('sodium_crypto_generichash') ) {
			return 'native';
		}

		return 'compat';
	}

	/**
	 * Get the unique nonce that is used for the secretbox.
	 * 
	 * @return string
	 */
	public function get_enc_nonce() {
		if ( function_exists('random_bytes') ) {
			return random_bytes( 24 );
		}

		require_once dirname( __FILE__ ) . '/2fa/polyfill/lib/random.php';
		return random_bytes( 24 );
	}

	/**
	 * Encrypt a string.
	 * 
	 * @param string $message
	 * @return array
	 */
	public function encrypt( $message ) {
		$enc_type = $this->get_enc_type();
		$nonce = $this->get_enc_nonce();

		try {
			// Use the PHP native encryption functions.
			if ( $enc_type == 'native' ) {
				$key = sodium_crypto_generichash( AUTH_KEY );

				return [
					'cipher' => sodium_bin2hex( sodium_crypto_secretbox( $message, $nonce, $key ) ),
					'nonce' => sodium_bin2hex( $nonce )
				];
			}

			// Use the Sodium polyfill library part of WordPress core.
			require_once ABSPATH . WPINC . '/sodium_compat/autoload.php';
			$key = \Sodium\crypto_generichash( AUTH_KEY );

			return [
				'cipher' => \Sodium\bin2hex( \Sodium\crypto_secretbox( $message, $nonce, $key ) ),
				'nonce' => \Sodium\bin2hex( $nonce )
			];
		} catch ( Exception $e ) {
			return [
				'cipher' => $message,
				'nonce' => ''
			];
		}
	}

	/**
	 * Decrypt a cipher to plain-text.
	 * 
	 * @param string $cipher
	 * @param string $nonce
	 * @return string
	 */
	public function decrypt( $cipher, $nonce ) {
		$enc_type = $this->get_enc_type();

		// If we received an empty nonce, we assume it was never properly encrypted to begin with.
		if ( $nonce == '' ) {
			return $cipher;
		}

		try {
			// Determine if we should use native or polyfill functions.
			if ( $enc_type == 'native' ) {
				$key = sodium_crypto_generichash( AUTH_KEY );
				$dec = sodium_crypto_secretbox_open( sodium_hex2bin( $cipher ), sodium_hex2bin( $nonce ), $key );
			} else {
				require_once ABSPATH . WPINC . '/sodium_compat/autoload.php';
				$key = \Sodium\crypto_generichash( AUTH_KEY );
				$dec = \Sodium\crypto_secretbox_open( sodium_hex2bin( $cipher ), sodium_hex2bin( $nonce ), $key );
			}
		} catch ( Exception $e ) {
			return $cipher;
		}

		// In case decryption failed, return null.
		if ( ! $dec ) {
			return null;
		}

		return $dec;
	}
}
