<?php
/**
 * @package Blade
 * @subpackage Profile
 */

namespace Drupal\blade\Configuration;

/**
 * A configurator Stack runner interface
 */
interface ConfigurationRunnerInterface
{
    public function pipe(ConfiguratorInterface $conf);
    public function run();
}
