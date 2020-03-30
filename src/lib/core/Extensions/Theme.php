<?php
/**
 * Class - Theme
 *
 * Extends theme functionality.
 *
 * @package launchpad
 * @since 1.0.0
 */

namespace CORE\Extensions;

class Theme implements SiteExtension {
    public function extend()
    {
        $this->addThemeSupports();
    }

    private function addThemeSupports()
    {
        // Enable post format support.
        add_theme_support( 'post-formats' );

        // Enable post thumbnail support.
        add_theme_support('post-thumbnails');

        // Enable automatic feed links for post and comments.
        add_theme_support( 'automatic-feed-links' );

        /**
         * Use valid HTML5 markup for the search forms, comment forms, comment
         * lists, galleries, and captions.
         */
        add_theme_support(
            'html5',
            array(
                'comment-list',
                'comment-form',
                'search-form',
                'gallery',
                'caption',
            )
        );

        // Let WordPress handle the contents of the <title> tag.
        add_theme_support( 'title-tag' );

        // Add theme support for menus.
        add_theme_support( 'menus' );

        // Add theme support for custom editor CSS styles.
        add_theme_support( 'editor-style' );
    }
}
