<?php
/**
 * this drush command load composer autoloader and
 * run profile initialisation
 *
 * @author sylvain.gogel@gmail.com
 * @package Blade
 * @subpackage Install
 * @example drush scr profiles/blade/drush/init.php
 * @since 1.0.0
 */
include_once DRUPAL_ROOT.'/sites/all/libraries/autoload.php';
use Drupal\blade\Profile as Blade;
use Drupal\log\DrushLogger;

blade_drush_init();

/**
 * run Blade profile configuration
 */
function blade_drush_init()
{
    $conf = new Blade\BladeConfiguration(new DrushLogger());
    $conf->run();
}
