<?php
/**
 * Single Page Template Controller
 *
 * Controls how data is handled for single pages.
 *
 * @package launchpad
 * @since 1.0.0
 */

// Get context (page data) from Timber.
$context = Timber::get_context();

// Get data from the current page.
$page_content = new TimberPost();

// Pass current page data into post context.
$context['post'] = $page_content;

// Pass data to the front-end templates.
Timber::render(
    array(
        // Select front-end template based on 'page-postname' first.
        'page-' . $page_content->post_name . '.twig',
        'page.twig',
    ),
    $context
);
