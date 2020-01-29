<?php
/**
 * Class - Media
 *
 * Establish default theme media settings.
 *
 * @package launchpad
 * @since 1.0.0
 */

namespace LAUNCHPAD;

class Media {
    public function __construct()
    {
        // Register default and custom images sizes as well as JPG quality.
        $this->addImageSizes();
        add_action('after_setup_theme', array($this, 'defaultMediaSettings'));
        add_action('after_setup_theme', array($this, 'addImageSizes'));
        add_filter('image_size_names_choose', array($this, 'customImageSizes'));
        add_action('jpeg_quality', array($this, 'customJpegQuality'));

        // Add Custom Fonts
        add_filter('tiny_mce_before_init', array($this, 'editorCustomFonts'));

        // Add editor stylesheet to the backend.
        add_action('wp_head', array($this, 'editorCustomFontsInit'));
        add_action('admin_head', array($this, 'editorCustomFontsInit'));

        // Add font size selector to the editor.
        add_filter('mce_buttons_2', array($this, 'editorFontButtons'));

        // Add additional font size options to the editor.
        add_filter('tiny_mce_before_init', array($this, 'editorExtendFontSizes'));

        // Add filter for responsive embedded objects (i.e. videos).
        add_filter('the_content', array($this, 'contentResponsiveEmbeds'));
    }

    /**
     * Method to register custom image sizes.
     *
     * @return void
     */
    public function addImageSizes()
    {
        // add_image_size('example_size', 1300, 600, true);
    }

    /**
     * Method to add custom image sizes to the WordPress Admin.
     *
     * @param  array $sizes Default Sizes
     * @return array        Updated Sizes
     */
    public function customImageSizes($sizes)
    {
        return array_merge($sizes, array(
            // 'example_size' => __('Example Size'),
        ));
    }

    /**
     * Set default settings when adding/editing post images.
     */
    public function defaultMediaSettings()
    {
        update_option('image_default_align', 'center');
        update_option('image_default_link_type', 'none');
        update_option('image_default_size', 'large');
    }

    /**
     * Sets custom JPG quality when resizing images.
     *
     * @return number JPG Quality
     */
    public function customJpegQuality()
    {
        return 80;
    }

    /**
     * Add editor stylesheet to the backend.
     */
    public function editorCustomFontsInit()
    {
        echo '<link type="text/css" rel="stylesheet" href="' . get_template_directory_uri() . '/lib/editor/editor-fonts.css">';
    }

    /**
     * Add custom fonts to the WordPress editor.
     */
    public function editorCustomFonts($init)
    {
        $stylesheet_url = get_template_directory() . '/lib/editor/editor-fonts.css';

        if (empty($init['content_css'])) {
            $init['content_css'] = $stylesheet_url;
        } else {
            $init['content_css'] = $init['content_css'] . ',' . $stylesheet_url;
        }

        $font_formats = isset($init['font_formats']) ? $init['font_formats'] : 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';

        $custom_fonts = '';

        /*

        Here is an example of how to register custom fonts in the editor:

        $custom_fonts = ';' . 'IBM Plex Sans=ibm plex sans,helvetica,arial,sans-serif;IBM Plex Serif=ibm plex serif,georgia,arial,sans-serif';

        */

        $init['font_formats'] = $font_formats . $custom_fonts;

        return $init;
    }

    /**
     * Extend font options for the WordPress editor.
     */
    public function editorFontButtons($buttons)
    {
        array_unshift( $buttons, 'fontselect' );
        array_unshift( $buttons, 'fontsizeselect' );

        return $buttons;
    }

    /**
     * Add more font sizes to the WordPress editor.
     */
    public function editorExtendFontSizes($initArray)
    {
        $initArray['fontsize_formats'] = '9px 10px 11px 12px 14px 16px 18px 20px 24px 28px 32px 36px 40px 44px 48px 52px 56px 60px 64px 68px 72px 78px 82px 86px 90px 94px 98px 102px 106px 110px 114px 118px 122px 126px 130px 134px 138px 142px 146px 150px';

        return $initArray;
    }

    /**
     * Filter for adding responsive CSS wrappers around embedded objects.
     */
    public function contentResponsiveEmbeds($content)
    {
        // Object Filtering
        $content = preg_replace("/<object/Si", '<div class="launchpad-embed-responsive"><object', $content);
        $content = preg_replace("/<\/object>/Si", '</object></div>', $content);

        // Iframe Filtering
        $content = preg_replace("/<iframe.+?src=\"(.+?)\"/Si", '<div class="launchpad-embed-responsive"><iframe src="\1" frameborder="0" allow="\1" allowfullscreen>', $content);
        $content = preg_replace("/<\/iframe>/Si", '</iframe></div>', $content);

        return $content;
    }
}
