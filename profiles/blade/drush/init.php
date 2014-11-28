<?php
/**
 * @package Blade
 * @subpackage Profile
 *
 * this is a drush script to manualy run initialisation
 */

include_once DRUPAL_ROOT.'/sites/all/libraries/autoload.php';
use Drupal\blade\Configuration as Blade;

$conf = new Blade\ConfigurationRunner();
$conf
    ->pipe(new Blade\TypesConfigurator())
    ->pipe(new Blade\BlocksConfigurator())
    ->pipe(new Blade\FiltersConfigurator())
;

$output = $conf->run();

foreach ($output as $m) {
    list($msg, $level) = $m;
    drush_log($msg, $level);
}

/*

include_once DRUPAL_ROOT.'/profiles/ac/includes/roles.inc';
ac_configure_roles();

include_once DRUPAL_ROOT.'/profiles/ac/includes/menus.inc';
ac_configure_menus();

include_once DRUPAL_ROOT.'/profiles/ac/includes/themes.inc';
ac_configure_themes();
*/
