<?php
/**
 * Theme dictionary and runtime injection hooks.
 */

namespace DaisyGutenberg;

defined( 'ABSPATH' ) || exit;

/**
 * Return all 35 official DaisyUI built-in themes.
 *
 * @return array<string, string> Theme slug to human-readable label.
 */
function get_daisy_themes(): array {
	return array(
		'light',
		'dark',
		'cupcake',
		'bumblebee',
		'emerald',
		'corporate',
		'synthwave',
		'retro',
		'cyberpunk',
		'valentine',
		'halloween',
		'garden',
		'forest',
		'aqua',
		'lofi',
		'pastel',
		'fantasy',
		'wireframe',
		'black',
		'luxury',
		'dracula',
		'cmyk',
		'autumn',
		'business',
		'acid',
		'lemonade',
		'night',
		'coffee',
		'winter',
		'dim',
		'nord',
		'sunset',
		'caramellatte',
		'abyss',
		'silk',
	);
}

/**
 * Get the currently active theme slug stored in WordPress options.
 */
function get_active_theme(): string {
	$saved_theme = get_option( DAISY_GUTENBERG_OPTION_THEME, 'light' );
	$all_themes  = get_daisy_themes();

	return array_key_exists( $saved_theme, $all_themes ) ? $saved_theme : 'light';
}

/**
 * Inject data-theme="<theme>" into the frontend <html> tag via language_attributes.
 */
function inject_frontend_theme_attribute( string $output ): string {
	$theme = get_active_theme();
	return $output . ' data-theme="' . esc_attr( $theme ) . '"';
}
add_filter( 'language_attributes', __NAMESPACE__ . '\inject_frontend_theme_attribute' );

/**
 * Inject dynamic theme observer script into the Gutenberg Block Editor.
 */
function inject_editor_theme_script(): void {
	$active_theme = get_active_theme();

	$inline_script = sprintf(
		'(function() {
			var theme = %s;
			function applyDaisyTheme() {
				// 1. Classic non-iframed editor wrapper
				var wrapper = document.querySelector(".editor-styles-wrapper");
				if (wrapper && wrapper.getAttribute("data-theme") !== theme) {
					wrapper.setAttribute("data-theme", theme);
				}

				// 2. Modern iframed editor canvas (WordPress 6.3+)
				var iframe = document.querySelector("iframe[name=\"editor-canvas\"]");
				if (iframe && iframe.contentDocument && iframe.contentDocument.documentElement) {
					if (iframe.contentDocument.documentElement.getAttribute("data-theme") !== theme) {
						iframe.contentDocument.documentElement.setAttribute("data-theme", theme);
					}
				}
			}

			if (document.readyState === "loading") {
				document.addEventListener("DOMContentLoaded", applyDaisyTheme);
			} else {
				applyDaisyTheme();
			}

			var observer = new MutationObserver(applyDaisyTheme);
			observer.observe(document.body, { childList: true, subtree: true });
		})();',
		wp_json_encode( $active_theme )
	);

	wp_add_inline_script( 'wp-block-editor', $inline_script );
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\inject_editor_theme_script' );
