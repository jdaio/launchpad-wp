<?php
/**
 * Search Template Controller
 *
 * @package launchpad
 */

// Get context (page data) from Timber.
$context = Timber::get_context();

// Get the search query keyword.
$searchKeyword = $_GET['s'];

// Pass current page data into post context.
$context['search_title'] = 'Search Results for "' . $searchKeyword . '"';
$context['search_query_keyword'] = $searchKeyword;
$context['posts'] = new Timber\PostQuery();

// Pass data to the front-end templates.
$templates = array('archive.twig', 'index.twig');

Timber::render(
    array(
        // Use archive template first for search results.
        'archive.twig',
        'index.twig',
    ),
    $context
);
