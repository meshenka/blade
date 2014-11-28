<?php

/**
 * @package Blade
 * @subpackage Profile
 *
 * A simple class to run a stack of ConfiguratorInterface
 */

namespace Drupal\blade\Configuration;

/**
 * A class to run a stack of ConfiguratorInterface
 */
class ConfigurationRunner
{
    /**
     * @var array
     */
    private $configurators = [];

    /**
     * chainable
     * add a configurator to the stack
     * @param  ConfiguratorInterface $conf
     * @return ConfigurationRunner   this instance
     */
    public function pipe(ConfiguratorInterface $conf)
    {
        $this->configurators[] = $conf;

        return $this;
    }

    /**
     *
     * Run the configurator stack
     * @return array array of log messages
     */
    public function run()
    {
        $output = [];
        foreach ($this->configurators as $conf) {
            $output = array_merge($output, $conf->configure());
        }

        return $output;
    }
}
