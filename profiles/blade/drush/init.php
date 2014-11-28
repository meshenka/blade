<?php
/**
 * @package Blade
 * @subpackage Profile
 *
 * this is a drush script to manualy run initialisation
 */

include_once DRUPAL_ROOT.'/sites/all/libraries/autoload.php';
use Drupal\blade\Configuration as Blade;

blade_drush_init();

/**
 * run Blade profile configuration
 */
function blade_drush_init()
{
    $conf = new Blade\BladeConfiguration();

    $output = $conf->run();

    foreach ($output as $m) {
        list($msg, $level) = $m;
        drush_log($msg, $level);
    }
}
