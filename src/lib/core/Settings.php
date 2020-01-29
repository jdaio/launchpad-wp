<?php
/**
 * Class - Settings
 *
 * Use this class to store configuration constants.
 *
 * @package launchpad
 * @since 1.0.0
 */

namespace LAUNCHPAD;

class Settings {
    const VIEWS_DIR = 'views';

    private $extensions = [
        'Twig',
        'Theme',
        'Assets',
        'ContentTypes',
        'Shortcodes',
    ];

    public function __construct()
    {
        $this->loadExtensions();
    }

    /**
     * Call all extensions in self::EXTENSIONS.
     *
     * @param array
     * @throws \Exception
     */
    private function loadExtensions()
    {
        foreach ($this->extensions as $extension) {
            $class = '\LAUNCHPAD\Extensions\\' . $extension;
            $extension = new $class();

            if (!$extension instanceof Extensions\SiteExtension) {
                throw new \Exception('Extension must implement SiteExtension interface.');
            }

            $extension->extend();
        }
    }
}
