<?php
/**
 * Class - Performance
 *
 * Default theme performance settings.
 *
 * @package launchpad
 * @since 1.0.0
 */

namespace LAUNCHPAD;

class Performance {
    private $scriptsToAsync = array('wp-embed.min.js');
    private $scriptsToDefer = array();

    public function __construct()
    {
        add_filter('script_loader_tag', array($this, 'asyncScript'));
        add_filter('script_loader_tag', array($this, 'deferScript'));
    }

    /**
     * Method to set scripts to load asynchronously.
     *
     * @param  string $tag Script Tag
     * @return string      Script Tag
     */
    public function asyncScript($tag)
    {
        if (is_admin()) {
            return $tag;
        }

        foreach ($this->scriptsToAsync as $script) {
            if (strpos($tag, $script) == true) {
                return str_replace(' src', ' async src', $tag);
            }
        }

        return $tag;
    }

    /**
     * Method to set scripts to deferred loading.
     *
     * @param  string $tag Script Tag
     * @return string      Script Tag
     */
    public function deferScript($tag)
    {
        if (is_admin()) {
            return $tag;
        }

        foreach ($this->scriptsToDefer as $script) {
            if (strpos($tag, $script) == true) {
                return str_replace(' src', ' defer src', $tag);
            }
        }

        return $tag;
    }
}
