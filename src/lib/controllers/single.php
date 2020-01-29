<?php
/**
 * Single Post Template Controller
 *
 * Controls how data is handled for single posts.
 *
 * @package launchpad
 * @since 1.0.0
 */

// Get context (page data) from Timber.
$context = Timber::get_context();

// Pass the data to the front-end templates.
Timber::render(
    array(
        // Load template by 'single-postId'.
        'single-' . $post->ID . '.twig',
        // Load template by 'single-postType' if above not available.
        'single-' . $post->post_type . '.twig',
        // Load standard single post view last.
        'single.twig',
    ),
    $context
);
