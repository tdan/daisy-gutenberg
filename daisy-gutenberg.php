<?php
/**
 * Plugin Name:       Daisy Gutenberg
 * Description:       A Gutenberg blocks library powered by DaisyUI
 * Version:           0.1.0
 * Requires at least: 6.8
 * Requires PHP:      7.4
 * Author:            Trung (Daniel) An
 * License:           MIT
 * License URI:       https://mit-license.org/
 * Text Domain:       daisy-gutenberg
 *
 */

namespace DaisyGutenberg;

defined('ABSPATH') || exit;

// Define core constants.
define('DAISY_GUTENBERG_VERSION', '0.1.0');
define('DAISY_GUTENBERG_PATH', plugin_dir_path(__FILE__));
define('DAISY_GUTENBERG_URL', plugin_dir_url(__FILE__));
define('DAISY_GUTENBERG_OPTION_THEME', 'daisy_gutenberg_active_theme');

// 1. Theme dictionary and injection engine (frontend & editor).
require_once DAISY_GUTENBERG_PATH . 'includes/themes.php';

// 2. Global CSS asset registration and dynamic block discovery.
require_once DAISY_GUTENBERG_PATH . 'includes/assets-and-blocks.php';

// 3. Admin settings page and options management (loaded in wp-admin).
if (is_admin()) {
	require_once DAISY_GUTENBERG_PATH . 'includes/admin-settings.php';
}
