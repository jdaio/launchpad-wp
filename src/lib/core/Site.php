<?php
/**
 * Class - Site
 *
 * Sets up Timber and handles dependencies.
 *
 * @package launchpad
 * @since 1.0.0
 */

namespace LAUNCHPAD;

// Use Timber
use Timber\Timber;

/**
 * Utilize Built in ACF Package
 */
define( 'THEME_ACF_PATH', get_stylesheet_directory() . '/lib/vendors/acf/' );
define( 'THEME_ACF_URL', get_stylesheet_directory_uri() . '/lib/vendors/acf/' );

if (!class_exists('acf')) {
    include_once( THEME_ACF_PATH . 'acf.php' );
}

class Site extends \Timber\Site {
    public function __construct()
    {
        Timber::$dirname = Settings::VIEWS_DIR;

        $this->siteInit();

        parent::__construct();
    }

    public function siteInit()
    {
        // Make the theme available for translation.
        load_theme_textdomain('launchpad', get_template_directory() . '/translations');

        // Register theme menus.
        add_action('init', array($this, 'registerThemeMenus'));

        // Register theme sidebars.
        add_action('widgets_init', array($this, 'registerThemeSidebars'));

        // Add data to the Twig context.
        add_filter('timber_context', array($this, 'addToContext'));

        // Customize the url setting to fix incorrect asset URLs.
        add_filter('acf/settings/url', array($this, 'themeAcfUrl'));

        // Load and Save ACF Fields via JSON
        add_filter('acf/settings/load_json', array($this, 'loadAcfFields'));
        add_filter('acf/settings/save_json', array($this, 'saveAcfFields'));

        // Register ACF Blocks
        add_action('acf/init', array($this, 'registerAcfBlocks'));

        // Register ACF Options Pages
        add_action('acf/init', array($this, 'registerAcfOptions'));

        // Disable Gutenberg
        // add_filter('use_block_editor_for_post', array($this, '__return_false'));
    }

    /**
     * Add global data to the Twig context.
     *
     * @param  array $context
     * @return array
     */
    public function addToContext($context)
    {
        // Add site data to the global context.
        $context['site'] = $this;

        // Add theme options to the global context.
        $context['option'] = get_fields('option');

        // Get post data and add it to the context.
        global $post;
        $post = Timber::get_post();
        $context['post'] = $post;

        // Set up menus.
        $context['nav_header'] = new \Timber\Menu('nav_header');
        $context['nav_footer'] = new \Timber\Menu('nav_footer');

        return $context;
    }

    /**
     * Register Theme Menus
     */
    public function registerThemeMenus()
    {
        register_nav_menus( array(
            'nav_header' => 'Header Navigation',
            'nav_footer' => 'Footer Navigation',
        ) );
    }

    /**
     * Register Theme Sidebars
     */
    public function registerThemeSidebars()
    {
        /* register_sidebar(array(
            'name'          => __('Page Sidebar', 'launchpad'),
            'id'            => 'sidebar_page',
            'description'   => __('Widgets in this area will be shown on all pages.', 'sef'),
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget'  => '</li>',
            'before_title'  => '<h2 class="widget__title">',
            'after_title'   => '</h2>',
        )); */
    }

    /**
     * Setup Built-in ACF
     */
    function themeAcfUrl( $url ) {
        return THEME_ACF_URL;
    }

    /**
     * Register ACF Blocks
     */
    public function registerAcfBlocks()
    {
        /* acf_register_block_type(array(
            'name'              => 'columns',
            'title'             => __('Columns'),
            'description'       => __('A custom column-based content block.'),
            'render_template'   => 'lib/acf-blocks/example-block.php',
            'category'          => 'layout',
            'icon'              => 'example-icon',
            'keywords'          => array('columns'),
            'align'             => 'center',
        )); */
    }

    /**
     * Set Options Pages via ACF
     */
    public function registerAcfOptions()
    {
        if (function_exists('acf_add_options_page')) {
            // Setup a main options menu item in a variable to create sub-menus.
            $main_options = acf_add_options_page(
                array(
                    'page_title' => 'Theme Settings',
                    'menu_title' => 'Theme Settings',
                    'menu_slug'  => 'theme-settings',
                    'capability' => 'edit_posts',
                    'redirect'   => false,
                )
            );

            // Creates "Theme Documentation" sub page.
            acf_add_options_sub_page(
                array(
                    'page_title'  => 'Theme Documentation',
                    'menu_title'  => 'Documentation',
                    'parent_slug' => $main_options['menu_slug'],
                )
            );
        }
    }

    /**
     * Load and save ACF Fields via JSON.
     */
    public function loadAcfFields($paths)
    {
        unset($paths[0]);

        $paths[] = get_template_directory() . '/lib/acf-json';

        return $paths;
    }

    public function saveAcfFields($path)
    {
        $path = get_template_directory() . '/lib/acf-json';

        return $path;
    }
}
