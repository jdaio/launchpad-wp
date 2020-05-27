<?php
/**
 * Class - Twig
 *
 * Extends Twig functionality.
 *
 * @package launchpad
 * @since 1.0.0
 */

namespace CORE\Extensions;

class Twig implements SiteExtension {
    public function extend()
    {
        // Add functions to Timber loader.
        add_filter('timber/loader/twig', array($this, 'extendTwig'));

        // Re-enable password protection for Timber pages.
        add_filter('timber/post/content/show_password_form_for_protected', 'isPasswordProtected');
    }

    /**
     * Extends Twig and registers filters/functions.
     *
     * @param \Twig_Environment $twig
     * @return \Twig_Environment $twig
     */
    public function extendTwig($twig)
    {
        $twig = $this->registerTwigFilters($twig);
        $twig = $this->registerTwigFunctions($twig);
        $twig = $this->registerTwigTests($twig);

        return $twig;
    }

    /**
     * Custom Twig Functions
     *
     * @param \Twig_Environment $twig
     * @return \Twig_Environment $twig
     */
    protected function registerTwigFunctions($twig)
    {
        // Example Function
        /*
            $this->registerFunction(
                $twig,
                'functionName',
                array(
                    '\CORE\Extensions\Twig',
                    'function_callback',
                )
            );
        */

        return $twig;
    }

    /**
     * Custom Twig Filters
     *
     * @param \Twig_Environment $twig
     * @return \Twig_Environment $twig
     */
    protected function registerTwigFilters($twig)
    {
        // Example Filter
        /*
            $this->registerFilter(
                $twig,
                'filterName',
                array(
                    '\CORE\Extensions\Twig',
                    'filter_callback',
                )
            );
        */

        return $twig;
    }

    /**
     * Custom Twig Tests
     *
     * @param \Twig_Environment $twig
     * @return \Twig_Environment $twig
     */
    protected function registerTwigTests($twig)
    {
        // Example Test
        /*
            $this->registerTest(
                $twig,
                'testName',
                array(
                    '\CORE\Extensions\Twig',
                    'test_callback',
                )
            );
        */

        return $twig;
    }

    /**
     * Method to register new Twig functions.
     * This method must not be changed.
     *
     * @param \Twig_Environment $twig
     * @param $name
     * @param $callback
     */
    protected function registerFunction($twig, $name, $callback = null)
    {
        if (!$callback) {
            $callback = array($this, $name);
        }

        $classNameFunction = new \Twig_SimpleFunction($name, $callback);

        $twig->addFunction($classNameFunction);
    }

    /**
     * Method to register new Twig filters.
     * This method must not be changed.
     *
     * @param \Twig_Environment $twig
     * @param $name
     * @param $callback
     */
    protected function registerFilter($twig, $name, $callback = null)
    {
        if (!$callback) {
            $callback = array($this, $name);
        }

        $classNameFilter = new \Twig_SimpleFilter($name, $callback);

        $twig->addFilter($classNameFilter);
    }

    /**
     * Method to register new Twig tests.
     * This method must not be changed.
     *
     * @param \Twig_Environment $twig
     * @param $name
     * @param $callback
     */
    protected function registerTest($twig, $name, $callback = null)
    {
        if (!$callback) {
            $callback = array($this, $name);
        }

        $classNameTest = new \Twig_SimpleTest($name, $callback);
        $twig->addTest($classNameTest);
    }

    /**
     * Re-enable password protection for Timber pages.
     *
     * @param boolean $maybe_show
     */
    public function isPasswordProtected($maybe_show)
    {
        return true;
    }
}
