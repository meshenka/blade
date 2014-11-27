<?php

include_once DRUPAL_ROOT.'/sites/all/libraries/autoload.php';

/**
 * this is a drush script to manualy run initialisation
 */
use Drupal\ac\Configuration\TypeConfigurator;

//include_once DRUPAL_ROOT.'/profiles/ac/ac.install';
$typeConf = new TypeConfigurator();
$output = $typeConf->configure();
foreach ($output as $m) {
    list($msg, $level) = $m;
    drush_log($msg, $level);
}

drush_log('Done', 'success');
/*
include_once DRUPAL_ROOT.'/profiles/ac/includes/filters.inc';
ac_configure_filters();

include_once DRUPAL_ROOT.'/profiles/ac/includes/blocks.inc';
drush_log('init blocks', 'success');
drush_log(ac_configure_blocks(), 'success');

drush_log('init types', 'success');
drush_log(ac_configure_types(), 'success');

include_once DRUPAL_ROOT.'/profiles/ac/includes/roles.inc';
ac_configure_roles();

include_once DRUPAL_ROOT.'/profiles/ac/includes/menus.inc';
ac_configure_menus();

include_once DRUPAL_ROOT.'/profiles/ac/includes/themes.inc';
ac_configure_themes();
*/
