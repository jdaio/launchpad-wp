<?php
/**
 * 404 Template Controller
 *
 * Controls how data is handled for the 404 page.
 *
 * @package launchpad
 * @since 1.0.0
 */

// Get context (page data) from Timber.
$context = Timber::get_context();

$context['page_title'] = 'Page Not Found';

// Pass data to front-end template.
Timber::render('404.twig', $context);
