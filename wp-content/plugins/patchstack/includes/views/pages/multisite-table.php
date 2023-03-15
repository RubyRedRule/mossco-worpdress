<?php

// Do not allow the file to be called directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Output the form and table.
require_once dirname( __FILE__ ) . '/../../admin/multisite-table.php';
?>
<div class="patchstack-font">
	<form method="GET" style="display: table;">
		<div class="wrap">
			<h2>Available Sites</h2>
		</div>
		<input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ); ?>" />
		<?php
			$table = new Patchstack_Network_Sites_Table();
			$table->prepare_items();
			$table->search_box( 'Search', 'search' );
		?>
	</form>
	<?php
		$table->display();
	?>
</div>
