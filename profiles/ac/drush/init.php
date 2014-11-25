<?php

/**
 * this is a drush script to manualy run initialisation
 */

//include_once DRUPAL_ROOT.'/profiles/ac/ac.install';

include_once DRUPAL_ROOT.'/profiles/ac/includes/filters.inc';
ac_configure_filters();

include_once DRUPAL_ROOT.'/profiles/ac/includes/blocks.inc';
drush_log('init blocks '.ac_configure_blocks(), 'success');

include_once DRUPAL_ROOT.'/profiles/ac/includes/types.inc';
ac_configure_types();

include_once DRUPAL_ROOT.'/profiles/ac/includes/roles.inc';
ac_configure_roles();

include_once DRUPAL_ROOT.'/profiles/ac/includes/menus.inc';
ac_configure_menus();

include_once DRUPAL_ROOT.'/profiles/ac/includes/themes.inc';
ac_configure_themes();
