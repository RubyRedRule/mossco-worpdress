<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

// function that runs when shortcode is called
function cc_theme_editor()
{
	$url = home_url(('/wp-admin/themes.php?page=gutenberg-edit-site'));
	return $url;
}
add_shortcode('gutenberg-editor', 'cc_theme_editor');
function cc_theme_category()
{
	$category_link = get_category_link(1);
	return $category_link;
}
add_shortcode('cc-category-link', 'cc_theme_category');

if (!function_exists('cwicly_support')) :
	function cwicly_support()
	{
		// Adding support for featured images.
		add_theme_support('post-thumbnails');

		// Adding support for alignwide and alignfull classes in the block editor.
		add_theme_support('align-wide');

		// Add support for editor styles.
		add_theme_support('editor-styles');

		// Adding support for responsive embedded content.
		add_theme_support('responsive-embeds');

		add_theme_support('experimental-link-color');
	}
	add_action('after_setup_theme', 'cwicly_support');
endif;

add_filter('should_load_separate_core_block_assets', '__return_true');

/**
 * Load theme updater functions.
 * Action is used so that child themes can easily disable.
 */

if (!class_exists('Cwicly_Theme_Updater')) {
	include get_template_directory() . '/includes/updater/theme-updater-class.php';
}

function cc_menu()
{
	register_nav_menus(
		array(
			'cc-menu' => __('Main Menu'),
		)
	);
}
add_action('init', 'cc_menu');

function cwicly_theme_enqueue()
{
	wp_enqueue_style(
		'cwicly',
		get_stylesheet_uri(),
		array(),
		'1.0'
	);
}
add_action('wp_enqueue_scripts', 'cwicly_theme_enqueue');

/*
* Comment
*/

add_filter(
	'comment_form_defaults',
	function ($fields) {
		$fields['submit_button'] = '<input name="%1$s" type="submit" id="%2$s" class="%3$s wp-block-button__link" value="%4$s" />';
		$fields['submit_field']  = '<p class="form-submit wp-block-button">%1$s %2$s</p>';

		return $fields;
	}
);


function cwicly_comment($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment; ?>
	<?php $add_below = ''; ?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		<div class="comment-body">
			<div class="comment-user-meta">
				<?php echo get_avatar($comment, 80); ?>
				<div class="comment-head">
					<h4 class="comment-user"><?php echo get_comment_author_link(); ?></h4>
					<div class="date">
						<?php
						printf(esc_html__('%1$s at %2$s', 'cwicly'), get_comment_date(),  get_comment_time())
						?>
					</div>
					<div class="comment-meta">
						<?php comment_reply_link(array_merge($args, array('reply_text' => esc_html__('Reply', 'cwicly'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
						<?php edit_comment_link(esc_html__('Edit', 'cwicly'), '  ', '') ?>
					</div>
				</div>
				<?php if ($comment->comment_type != 'pingback') : ?>
					<div class="comment-content">
						<?php if ($comment->comment_approved == '0') : ?>
							<p>
								<em><?php echo esc_html__('Your comment is awaiting moderation.', 'cwicly') ?></em><br />
							</p>
						<?php endif; ?>
						<?php comment_text() ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php
}
