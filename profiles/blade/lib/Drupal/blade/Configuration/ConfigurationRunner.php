<?php
/**
 * A simple class to run a stack of ConfiguratorInterface
 *
 * @author sylvain.gogel@gmail.com
 * @package Blade
 * @subpackage Configuration
 *
 */

namespace Drupal\blade\Configuration;

/**
 * Concert class to run Configurations
 *
 * @since 1.0.0
 */
final class ConfigurationRunner implements ConfigurationRunnerInterface
{
    /**
     * @var array
     */
    private $configurators = [];

    /**
     * {@inheritdoc}
     */
    public function pipe(ConfiguratorInterface $conf)
    {
        $this->configurators[] = $conf;

        return $this;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function run()
    {
        foreach ($this->configurators as $conf) {
            $conf->configure();
        }
    }
}
