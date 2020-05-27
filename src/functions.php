<?php
/**
 * Theme Functions - Overview
 *
 * @package launchpad
 * @since 1.0.0
 */

// Define the theme's function namespace in a constant.
define('CORE_NAMESPACE', 'CORE\\');

/**
 * Function to automatically load and utilize classes as they're instantiated.
 */
spl_autoload_register('theme_autoloader');

function theme_autoloader($className)
{
    $baseDirectory = __DIR__ . '/lib/core/';

    $namespacePrefixLength = strlen(CORE_NAMESPACE);

    if (strncmp(CORE_NAMESPACE, $className, $namespacePrefixLength) !== 0) {
        return;
    }

    $relativeClassName = substr($className, $namespacePrefixLength);
    $classFilename = $baseDirectory . str_replace('\\', '/', $relativeClassName) . '.php';

    if (file_exists($classFilename)) {
        require $classFilename;
    }
}

if (\CORE\Helpers::isTimberActivated()) {
    new \CORE\Settings();
    new \CORE\Security();
    new \CORE\Performance();
    new \CORE\Media();
    new \CORE\Site();
} else {
    \CORE\Helpers::addTimberErrorNotice();
}
