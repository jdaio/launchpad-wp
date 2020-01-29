<?php
/**
 * Archive Template Controller
 *
 * Controls how data is handled for archive pages.
 * Also routes to different front-end templates based on archive type.
 *
 * @package launchpad
 * @since 1.0.0
 */

// Set up template array to utilize archive view first if available.
$templates = array('archive.twig', 'index.twig');

// Get context (page data) from Timber.
$context = Timber::get_context();

// Set up text variables for archive pages.
$context['term_page'] = new Timber\Term();

// Get all of the posts for the queried archive and pass into Timber context.
$context['posts'] = new Timber\PostQuery();

// Pass data to the front-end templates.
Timber::render($templates, $context);
