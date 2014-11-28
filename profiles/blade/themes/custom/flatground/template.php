<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */

include_once dirname(__FILE__).'/bootstrap/menu.inc';

function flatground_preprocess_page(&$variables)
{
    //kpr($variables);
    //no page title in home node
    if (isset($variables['node']) && ($variables['node']->type === 'home')) {
        $variables['title'] = false;
    }
}
