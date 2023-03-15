<?php

// Do not allow the file to be called directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Determine if the subscription of the account is expired.
$status = $this->plugin->client_id != 'PATCHSTACK_CLIENT_ID' || get_option( 'patchstack_clientid', false ) != false;
$free   = get_option( 'patchstack_license_free', 0 ) == 1;
if ( isset( $_GET['activated'] ) && $status ) {
	echo "<script>window.location = 'admin.php?page=patchstack&tab=license&active=1';</script>";
}

// Generate the link to turn on settings management.
$url = '?page=' . esc_attr( $page ) . '&tab=license&action=enable_settings&patchstack_settings_nonce=' . wp_create_nonce( 'patchstack_settings_nonce' );
?>
<div>
	<div class="patchstack-plan patchstack-plan1">
		<span class="patchstack-has-text-white patchstack-is-size-4">Community <span>FREE</span></span><br />
		<p>Monitor your sites for core, theme and plugin vulnerabilities</p>
		<ul>
			<li><span class="patchstack-check"></span> Up To 99 Websites</li>
			<li><span class="patchstack-check"></span> Component Detection</li>
			<li><span class="patchstack-check"></span> Vulnerability Monitoring</li>
			<li><span class="patchstack-check"></span> Real-time Threat Alerts</li>
			<li class="patchstack-strike"><span class="patchstack-minus"></span> Virtual Patching</li>
		</ul>

		<a href="https://app.patchstack.com/sites?add=1&url=<?php echo rawurlencode( esc_url( get_site_url() ) ); ?>" target="_blank" class="patchstack-activate button-primary ps-b1" style="<?php echo $status ? 'display: none;' : ''; ?>">
			<?php echo __( 'Set up Patchstack', 'patchstack' ); ?>
		</a>

		<a href="https://patchstack.com/pricing/" target="_blank" class="patchstack-activate button-primary ps-b2" style="<?php echo ! $status ? 'display: none;' : ''; ?>">
			<?php echo __( 'See full list of Features', 'patchstack' ); ?>
		</a>
	</div>

	<div class="patchstack-plan patchstack-plan2">
		<p style="<?php echo $status ? 'display: none;' : ''; ?>" class="ps-p1">Just <a href="https://app.patchstack.com/sites?add=1&url=<?php echo rawurlencode( esc_url( get_site_url() ) ); ?>" target="_blank" class="patchstack-has-text-white">+ Add new website</a> in the Patchstack app and activate</p>
		<p style="<?php echo ! $status ? 'display: none;' : ''; ?>" class="ps-p2">Visit the Patchstack App to monitor and manage your sites</p>

		<div class="form-table patchstack-form-table">
			<label for="patchstack_api_client_id">Site ID</label>
			<input class="regular-text" type="text" id="patchstack_api_client_id" value="<?php echo esc_attr( get_option( 'patchstack_clientid', false ) ); ?>" placeholder="Enter Site ID">

			<label for="patchstack_api_client_secret_key">Site Secret Key</label>
			<input class="regular-text" type="text" id="patchstack_api_client_secret_key" value="<?php echo esc_attr( $this->get_secret_key() ); ?>" placeholder="Enter Site Secret Key">
		</div>

		<div class="patchstack-sub">
			<span>Subscription Type</span>
			<span style="color: #fff;" class="patchstack-sub-type">
				<?php echo $status ? 'Community (Free)' : '-'; ?>
			</span>
		</div>

		<div class="patchstack-sub" style="width: 30%;">
			<span>Status</span>
			<span style="color: <?php echo $status ? '#B2D675' : '#ED645E'; ?>" class="patchstack-license-status">
				<?php echo $status ? 'Active' : 'Inactive'; ?>
			</span>
		</div>

		<div class="patchstack-license-button">
			<input type="submit" id="patchstack-activate" value="<?php echo $status ? __( 'Save', 'patchstack' ) : __( 'Activate', 'patchstack' ); ?>" class="button-primary ps-b3 <?php echo ! $status ? 'patchstack-fullwidth' : ''; ?>" />
			<a href="https://app.patchstack.com/dashboard" class="patchstack-activate button-primary ps-b4" style="<?php echo ! $status ? 'display: none;' : ''; ?>" target="_blank"><?php echo __( 'Go to App', 'patchstack' ); ?></a>
		</div>

		<div id="hiddenstatusbox" class="patchstackInfo patchstack-font blue">
			<span class="label label-success" id="patchstack_license_key_result"></span>
		</div>
	</div>
	<div style="clear: both;"></div>
</div>

<p class="patchstack-upsell">
	Experience the full catalog of features with our Professional plan.<br>
	<a href="https://app.patchstack.com/setup" target="_blank">Upgrade</a> with our <img src="<?php echo esc_url( $this->plugin->url ); ?>assets/images/card.svg"> 30 day money-back guarantee.
</p>
