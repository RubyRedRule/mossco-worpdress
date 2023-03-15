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

if (!$show_settings) {
?>
<div class="patchstack-free" style="<?php echo $show_settings ? 'display: none;' : ''; ?>">
	<div>
		<div class="patchstack-plan patchstack-plan2">
			<p>Visit the Patchstack app to monitor and manage your sites</p>

			<div class="form-table patchstack-form-table">
				<label for="patchstack_api_client_id">Site ID</label>
				<input class="regular-text" type="text" id="patchstack_api_client_id" value="<?php echo esc_attr( get_option( 'patchstack_clientid', false ) ); ?>" placeholder="Enter Site ID">

				<label for="patchstack_api_client_secret_key">Site Secret Key</label>
				<input class="regular-text" type="text" id="patchstack_api_client_secret_key" value="<?php echo esc_attr( $this->get_secret_key() ); ?>" placeholder="Enter Site Secret Key">
			</div>

			<div class="patchstack-sub">
				<span>Subscription Type</span>
				<span style="color: #fff;" class="patchstack-sub-type">
					Professional
				</span>
			</div>

			<div class="patchstack-sub" style="width: 30%;">
				<span>Status</span>
				<span style="color: <?php echo $status ? '#B2D675' : '#ED645E'; ?>" class="patchstack-license-status">
					<?php echo $status ? 'Active' : 'Inactive'; ?>
				</span>
			</div>

			<div class="patchstack-license-button">
				<input type="submit" id="patchstack-activate" value="<?php echo $status ? __( 'Save', 'patchstack' ) : __( 'Activate', 'patchstack' ); ?>" class="button-primary <?php echo ! $status ? 'patchstack-fullwidth' : ''; ?>" />
				<a href="https://app.patchstack.com/dashboard" class="patchstack-activate button-primary" style="<?php echo ! $status ? 'display: none;' : ''; ?>" target="_blank"><?php echo __( 'Go to App', 'patchstack' ); ?></a>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>

	<p class="patchstack-upsell">
		Click <a href="<?php echo esc_url( $url ); ?>">here</a> to manage the Patchstack settings through WordPress.
	</p>
</div>
<?php
}
?>

<div style="<?php echo ! $show_settings ? 'display: none;' : ''; ?>">
	<div class="patchstack-font" 
	<?php
	if ( $show_settings ) {
		echo ' style="display: none;"'; }
	?>
	>
		<br />
		<h2>Thank you for using Patchstack<?php echo ( $free ? '' : ' Professional' ); ?></h2>
		<br />
		<p>
			The default settings of Patchstack are tweaked to provide a good baseline of security.<br />
			If however you still want to tweak the settings of Patchstack, you can do so through the "Hardening" tab at <a href="https://app.patchstack.com/sites" target="_blank">app.patchstack.com</a> after logging in and clicking on your site.<br /><br />
			Alternatively, you can turn on the setting management feature on WordPress itself by clicking <a href="">here</a>.
		</p>
		<br />
	</div>

	<h2 class="patchstack-license-h2 patchstack-hover"><?php echo __( 'Settings', 'patchstack' ); ?></h2>
	<div class="patchstack-font patchstack-license-info">
		<div id="hiddenstatusbox" class="patchstackInfo patchstack-font blue">
			<span class="label label-success" id="patchstack_license_key_result"></span>
		</div>
		<p<?php echo ( $show_settings ? '' : ' style="display: none;"' ); ?>>
			You can enter your site ID and secret key values below.<br />
			You generally do not have to touch these values.<br /><br />
			
			If both are empty and you do not know your site ID and secret key, you can find it by following these steps:<br />
			1. Go to your site on the <a href="https://app.patchstack.com/sites" target="_blank">Patchstack App</a>.<br />
			2. Click on the green gear icon next to the site URL on top of the page.<br />
			3. The site ID and secret key will be displayed on this page.
		</p>
		<table class="form-table patchstack-form-table">
			<tr>
				<th>
					<label for="patchstack_api_client_id"><?php echo __( 'Site ID', 'patchstack' ); ?></label>
				</th>
				<td>
					<input class="regular-text" type="text" id="patchstack_api_client_id" value="<?php echo esc_attr( get_option( 'patchstack_clientid', false ) ); ?>" placeholder="Enter your site ID here...">
				</td>
			</tr>
			<tr>
				<th><label for="patchstack_api_client_secret_key"><?php echo __( 'Site Secret Key', 'patchstack' ); ?></label></th>
				<td>
					<input class="regular-text" type="text" id="patchstack_api_client_secret_key" value="<?php echo esc_attr( $this->get_secret_key() ); ?>" placeholder="Enter your site secret key here...">
				</td>
			</tr>
			<tr>
				<th>
					<label><?php echo __( 'Status', 'patchstack' ); ?></label>
				</th>
				<td>
					<span class="patchstack-license-status" style="font-size: 13px; color: #fff;"><?php echo ( $status ? '' : 'Not ' ); ?>Activated</span>
				</td>
			</tr>
			<tr>
				<th>
					<label><?php echo __( 'Subscription Type', 'patchstack' ); ?></label>
				</th>
				<td>
					<span style="font-size: 13px; color: #fff;"><?php echo ( $free ? 'Community (Free)' : 'Professional' ); ?></span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p class="submit">
						<input type="submit" id="patchstack-activate" value="<?php echo __( 'Save', 'patchstack' ); ?>" class="button-primary" />
					</p>
				</td>
			</tr>
		</table>
	</div>
</div>
