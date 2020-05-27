<?php
/**
 * Class - Security
 *
 * Cleans up potential vulnerabilities and removes unnecessary garbage.
 *
 * @package launchpad
 * @since 1.0.0
 */

namespace CORE;

class Security {
    public function __construct()
    {
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');

        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');

        remove_action('rest_api_init', 'wp_oembed_register_route');

        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

        add_filter('the_generator', '__return_null');
        add_filter('xmlrpc_enabled', '__return_false');

        // Remove version number from CSS and JS files.
        add_filter('script_loader_src', array($this, 'removeSourceVersion'));
        add_filter('style_loader_src', array($this, 'removeSourceVersion'));

        // Disable backend theme/plugin editor.
        add_action('init', array($this, 'disableFileEditor'));
    }

    public function removeSourceVersion($src)
    {
        global $wp_version;

        $version_str = '?ver=' . $wp_version;
        $offset = strlen($src) - strlen($version_str);

        if ($offset >= 0 && strpos($src, $version_str, $offset) !== false) {
            return substr($src, 0, $offset);
        }

        return $src;
    }

    public function disableFileEditor() {
        define('DISALLOW_FILE_EDIT', true);
    }
}
