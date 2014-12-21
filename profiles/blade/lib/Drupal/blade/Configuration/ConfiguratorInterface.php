<?php
/**
 * @author sylvain.gogel@gmail.com
 * @package Blade
 * @subpackage Configuration
 *
 */
namespace Drupal\blade\Configuration;

/**
 * Generic profile configurator interface
 * implement this interface to setup your own profiles
 * @since 1.0.0
 * @api
 */
interface ConfiguratorInterface
{
    /**
     * Configure some of drupal aspects
     *
     * @return none
     */
    public function configure();
}
