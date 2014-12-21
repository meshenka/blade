<?php
/**
 * @author sylvain.gogel@gmail.com
 * @package Blade
 * @subpackage Configuration
 *
 */

namespace Drupal\blade\Configuration;

/**
 * A Configurator runner interface, in the Middleware style of Symfony2
 * @see http://stackphp.com/
 * @see https://twitter.com/beausimensen Beau D. Simensen aka
 * @api
 * @since 1.0.0
 */
interface ConfigurationRunnerInterface
{
    /**
     * Accumulate Configurators to run then all in one sweep
     * @since 1.0.0
     * @param Drupal\blade\Configuration\ConfiguratorInterface a configurator
     * @return Drupal\blade\Configuration\ConfigurationRunnerInterface this instance, for chainability
     */
    public function pipe(ConfiguratorInterface $conf);

    /**
     * Run all piped Configurators
     */
    public function run();
}
