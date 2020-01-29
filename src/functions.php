<?php
/**
 * Theme Functions - Overview
 *
 * @package launchpad
 * @since 1.0.0
 */

// Define the theme's function namespace in a constant.
define('THEME_NAMESPACE', 'LAUNCHPAD\\');

/**
 * Function to automatically load and utilize classes as they're instantiated.
 */
spl_autoload_register('theme_autoloader');

function theme_autoloader($className)
{
    $baseDirectory = __DIR__ . '/lib/core/';

    $namespacePrefixLength = strlen(THEME_NAMESPACE);

    if (strncmp(THEME_NAMESPACE, $className, $namespacePrefixLength) !== 0) {
        return;
    }

    $relativeClassName = substr($className, $namespacePrefixLength);
    $classFilename = $baseDirectory . str_replace('\\', '/', $relativeClassName) . '.php';

    if (file_exists($classFilename)) {
        require $classFilename;
    }
}

if (\LAUNCHPAD\Helpers::isTimberActivated()) {
    new \LAUNCHPAD\Settings();
    new \LAUNCHPAD\Security();
    new \LAUNCHPAD\Performance();
    new \LAUNCHPAD\Media();
    new \LAUNCHPAD\Site();
} else {
    \LAUNCHPAD\Helpers::addTimberErrorNotice();
}
