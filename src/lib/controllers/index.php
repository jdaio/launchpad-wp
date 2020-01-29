<?php
/**
 * The Main Template Controller
 *
 * Controls how data is retrieved and handled for the index page.
 *
 * @package launchpad
 */

// Establish timber context.
$context = Timber::get_context();

// Gather post data.
$context['posts'] = new Timber\PostQuery();

// Initialize array of templates with 'index.twig'.
$templates = array('archive.twig');

// Render the index page view.
Timber::render($templates, $context);
