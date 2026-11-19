<?php

/**
 * Asset registration, multi-block discovery, and inserter categories.
 */

namespace DaisyGutenberg;

defined('ABSPATH') || exit;

/**
 * Register core global stylesheets with modification-time cache busting.
 * Priority 9 ensures assets exist before blocks initialize.
 */
function register_assets(): void
{
	$main_css_file   = DAISY_GUTENBERG_PATH . 'build/main.css';
	$editor_css_file = DAISY_GUTENBERG_PATH . 'build/editor.css';

	$main_version = file_exists($main_css_file)
		? (string) filemtime($main_css_file)
		: DAISY_GUTENBERG_VERSION;

	$editor_version = file_exists($editor_css_file)
		? (string) filemtime($editor_css_file)
		: DAISY_GUTENBERG_VERSION;

	// Shared frontend & editor stylesheet (Tailwind v4 + DaisyUI v5).
	wp_register_style(
		'daisy-gutenberg-main',
		DAISY_GUTENBERG_URL . 'build/main.css',
		array(),
		$main_version
	);

	// Editor canvas stylesheet (scoped resets & UI z-index overrides).
	wp_register_style(
		'daisy-gutenberg-editor',
		DAISY_GUTENBERG_URL . 'build/editor.css',
		array('daisy-gutenberg-main'),
		$editor_version
	);
}
add_action('init', __NAMESPACE__ . '\register_assets', 9);

/**
 * Automatically discover and register all compiled blocks in /build/blocks/.
 */
function register_blocks(): void
{
	$blocks_directory = DAISY_GUTENBERG_PATH . 'build/blocks';

	if (! is_dir($blocks_directory)) {
		return;
	}

	$block_folders = glob($blocks_directory . '/*', GLOB_ONLYDIR);
	if (empty($block_folders)) {
		return;
	}

	foreach ($block_folders as $folder) {
		if (file_exists($folder . '/block.json')) {
			register_block_type_from_metadata($folder);
		}
	}
}
add_action('init', __NAMESPACE__ . '\register_blocks', 10);

/**
 * Enqueue editor-only canvas style overrides.
 */
function enqueue_editor_styles(): void
{
	wp_enqueue_style('daisy-gutenberg-editor');
}
add_action('enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_editor_styles');

/**
 * Register a dedicated category in the Gutenberg block inserter.
 */
function register_block_category(array $categories): array
{
	return array_merge(
		array(
			array(
				'slug' => 'daisy-gutenberg',
				'title' => __('DaisyUI Components', 'daisy-gutenberg'),
				'icon' => null,
			),
		),
		$categories
	);
}
add_filter('block_categories_all', __NAMESPACE__ . '\register_block_category', 10, 1);
