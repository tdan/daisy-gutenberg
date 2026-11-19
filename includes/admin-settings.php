<?php

/**
 * WordPress Admin Dashboard settings page and Settings API handling.
 */

namespace DaisyGutenberg;

defined('ABSPATH') || exit;

/**
 * Register plugin settings with WordPress Settings API.
 */
function register_settings(): void {
	register_setting(
		'daisy_gutenberg_settings_group',
		DAISY_GUTENBERG_OPTION_THEME,
		array(
			'type' => 'string',
			'sanitize_callback' => function ($input) {
				$themes = get_daisy_themes();
				return array_key_exists($input, $themes) ? $input : 'light';
			},
			'default' => 'light',
		)
	);

	add_settings_section(
		'daisy_gutenberg_main_section',
		__('Theme Configuration', 'daisy-gutenberg'),
		function () {
			echo '<p>' . esc_html__('Select the active DaisyUI theme applied across your website and editor canvas.', 'daisy-gutenberg') . '</p>';
		},
		'daisy-gutenberg'
	);

	add_settings_field(
		'daisy_gutenberg_theme_field',
		__('Active DaisyUI Theme', 'daisy-gutenberg'),
		__NAMESPACE__ . '\render_theme_select_field',
		'daisy-gutenberg',
		'daisy_gutenberg_main_section'
	);
}
add_action('admin_init', __NAMESPACE__ . '\register_settings');

/**
 * Render the dropdown select control for themes.
 */
function render_theme_select_field(): void
{
	$current_theme = get_active_theme();
	$themes        = get_daisy_themes();
?>
	<select name="<?php echo esc_attr(DAISY_GUTENBERG_OPTION_THEME); ?>" id="<?php echo esc_attr(DAISY_GUTENBERG_OPTION_THEME); ?>" style="min-width: 250px;">
		<?php foreach ($themes as $slug => $label) : ?>
			<option value="<?php echo esc_attr($slug); ?>" <?php selected($current_theme, $slug); ?>>
				<?php echo esc_html($label); ?>
			</option>
		<?php endforeach; ?>
	</select>
	<p class="description">
		<?php esc_html_e('Sets data-theme on the frontend <html> tag and Gutenberg editor canvas.', 'daisy-gutenberg'); ?>
	</p>
<?php
}

/**
 * Register settings subpage under "Settings".
 */
function add_settings_menu(): void
{
	add_options_page(
		__('Daisy Gutenberg Settings', 'daisy-gutenberg'),
		__('Daisy Gutenberg', 'daisy-gutenberg'),
		'manage_options',
		'daisy-gutenberg',
		__NAMESPACE__ . '\render_settings_page'
	);
}
add_action('admin_menu', __NAMESPACE__ . '\add_settings_menu');

/**
 * Render the settings page view.
 */
function render_settings_page(): void
{
	if (! current_user_can('manage_options')) {
		return;
	}
?>
	<div class="wrap">
		<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
		<form method="post" action="options.php">
			<?php
			settings_fields('daisy_gutenberg_settings_group');
			do_settings_sections('daisy-gutenberg');
			submit_button(__('Save Theme Settings', 'daisy-gutenberg'));
			?>
		</form>
	</div>
<?php
}
