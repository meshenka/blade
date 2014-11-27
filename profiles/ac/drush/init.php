<?php
/**
 * @package Blade
 * @subpackage Profile
 *
 * this is a drush script to manualy run initialisation
 */

include_once DRUPAL_ROOT.'/sites/all/libraries/autoload.php';
use Drupal\ac\Configuration as ACC;

function run(ACC\ConfiguratorInterface $conf)
{
    $output = $conf->configure();
    foreach ($output as $m) {
        list($msg, $level) = $m;
        drush_log($msg, $level);
    }
}

run(new ACC\TypesConfigurator());
drush_log('Types configuration done.', 'success');

run(new ACC\BlocksConfigurator());

drush_log('Blocks configuration done.', 'success');

run(new ACC\FiltersConfigurator());

drush_log('Filters configuration done.', 'success');

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
