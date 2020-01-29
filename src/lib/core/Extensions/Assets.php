<?php
/**
 * Class - Assets
 *
 * Asset management for the theme.
 *
 * @package launchpad
 * @since 1.0.0
 */

namespace LAUNCHPAD\Extensions;

class Assets implements SiteExtension {
    public function extend()
    {
        // Register theme assets.
        add_action('wp_enqueue_scripts', array($this, 'registerThemeAssets'));
    }

    public function registerThemeAssets()
    {
        // Enqueue main CSS stylesheet.
        wp_enqueue_style('css_main',
            get_template_directory_uri() . '/dist/css/style.min.css',
            false,
            filemtime(get_stylesheet_directory() . '/dist/css/style.min.css')
        );

        // Remove default WordPress jQuery and replace with an updated one.
        wp_deregister_script('jquery');
        wp_register_script('jquery', 'https://code.jquery.com/jquery-3.4.1.min.js', false, '3.4.1', false);

        // Register and enqueue theme JS.
        wp_register_script('theme_js',
            get_template_directory_uri() . '/dist/js/app.min.js',
            false,
            filemtime(get_stylesheet_directory() . '/dist/js/app.min.js'),
            true
        );

        // Hide jQuery inclusion behind ACF field option.
        if (get_field('jquery_enabled', 'option')) {
            wp_enqueue_script('jquery');
        }

        wp_enqueue_script('theme_js');
    }
}
