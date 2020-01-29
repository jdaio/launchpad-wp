<?php
/**
 * Class - ContentType
 *
 * This class registers custom post types and taxonomies.
 *
 * @package launchpad
 * @since 1.0.0
 */

namespace LAUNCHPAD\Extensions;

class ContentTypes implements SiteExtension {
    public function extend()
    {
        add_action('init', array($this, 'registerPostTypes'));
        add_action('init', array($this, 'registerTaxonomies'));
    }

    /**
     * Register Theme Post Types
     */
    public function registerPostTypes()
    {

    }

    /**
     * Register Custom Taxonomies
     */
    public function registerTaxonomies()
    {

    }
}
