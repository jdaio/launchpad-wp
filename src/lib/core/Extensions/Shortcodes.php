<?php
/**
 * Class - Shortcodes
 *
 * This class registers custom post types and taxonomies.
 *
 * @package launchpad
 * @since 1.0.0
 */

namespace LAUNCHPAD\Extensions;

class Shortcodes implements SiteExtension {
    public function extend()
    {
        // add_shortcode('example_tag', array($this, 'exampleShortcode'));
    }

    /* public function exampleShortcode($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "class" => '',
            "id" => '',
        ), $atts));

        return '<p class="' . $class . '" id="' . $id . '">' . $content . '</p>';
    } */
}
