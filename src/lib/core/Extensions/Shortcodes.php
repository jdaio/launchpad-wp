<?php
/**
 * Class - Shortcodes
 *
 * This class registers custom post types and taxonomies.
 *
 * @package launchpad
 * @since 1.0.0
 */

namespace CORE\Extensions;

class Shortcodes implements SiteExtension {
    public function extend()
    {
        // add_shortcode('button', array($this, 'buttonShortcode'));
    }

    public function buttonShortcode($atts, $content = null)
    {
        extract(shortcode_atts(array(
            "align" => '',
            "class" => '',
            "id" => '',
            "link" => '#',
            "link_title" => '',
            "new_tab" => '',
            "style" => 'primary',
        ), $atts));

        if (!empty($align)) {
            $align = ' style="text-align: '.$align.';"';
        }

        if (!empty($class)) {
            $class = ' ' . $class;
        }

        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }

        if (!empty($link_title)) {
            $link_title = ' title="' . $link_title . '"';
        } else {
            $link_title = ' title="' . $content . '"';
        }

        if ($new_tab == 'true') {
            $new_tab = ' target="_blank" rel="noopener"';
        }

        return '<p'.$align.'><a href="'.$link.'"'.$link_title.' class="btn btn-'.$style.''.$class.'"'.$id.''.$new_tab.'>'.$content.'</a></p>';
    }
}
