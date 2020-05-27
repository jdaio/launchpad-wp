<?php
/**
 * Class - ContentType
 *
 * This class registers custom post types and taxonomies.
 *
 * @package launchpad
 * @since 1.0.0
 */

namespace CORE\Extensions;

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
        /*
        $event_labels = array(
            'name' => _x('Events', 'post type general name', 'launchpad'),
            'singular_name' => _x('Event', 'post type singular name', 'launchpad'),
            'menu_name' => _x('Events', 'admin menu', 'launchpad'),
            'name_admin_bar' => _x('Event', 'add new on admin bar', 'launchpad'),
            'add_new' => _x('Add New', 'Event', 'launchpad'),
            'add_new_item' => __('Add New Event', 'launchpad'),
            'new_item' => __('New Event', 'launchpad'),
            'edit_item' => __('Edit Event', 'launchpad'),
            'view_item' => __('View Event', 'launchpad'),
            'all_items' => __('All Events', 'launchpad'),
            'search_items' => __('Search Events', 'launchpad'),
            'parent_item_colon' => __('Parent Events:', 'launchpad'),
            'not_found' => __('No Events found.', 'launchpad'),
            'not_found_in_trash' => __('No Events found in Trash.', 'launchpad'),
        );

        $event_supports = array(
            'title',
            'editor',
            'revisions',
            'thumbnail',
            'custom-fields',
        );

        register_post_type('event', array(
            'labels' => $event_labels,
            'description' => __('Events', 'launchpad'),
            'public' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-calendar-alt',
            'supports' => $event_supports,
            'has_archive' => true,
            'rewrite' => array(
                'slug' => 'events',
                'feeds' => true,
            ),
        ));
        */
    }

    /**
     * Register Custom Taxonomies
     */
    public function registerTaxonomies()
    {
        /*
        $event_category_labels = array(
            'name' => _x('Event Categories', 'post type general name', 'launchpad'),
            'singular_name' => _x('Event Category', 'post type singular name', 'launchpad'),
            'menu_name' => _x('Event Categories', 'admin menu', 'launchpad'),
            'add_new'  => _x('Add New', 'event_category', 'launchpad'),
            'add_new_item' => __('Add New Event Category', 'launchpad'),
            'new_item' => __('New Event Category', 'launchpad'),
            'edit_item' => __('Edit Event Category', 'launchpad'),
            'view_item' => __('View Event Categories', 'launchpad'),
            'all_items' => __('All Event Categories', 'launchpad'),
            'search_items' => __('Search Event Categories', 'launchpad'),
            'parent_item_colon' => __('Parent Event Categories:', 'launchpad'),
            'not_found' => __('No event categories found.', 'launchpad'),
            'not_found_in_trash' => __('No event categories found in Trash.', 'launchpad'),
        );

        register_taxonomy('event_category', 'event', array(
            'labels' => $event_category_labels,
            'description' => __('Categories for events.', 'launchpad'),
            'public' => true,
            'hierarchical' => true,
            'rewrite' => array(
                'slug' => 'event-category',
                'hierarchical' => true,
            )
        ));
        */
    }
}
