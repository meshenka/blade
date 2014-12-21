<?php
/**
 * @author sylvain.gogel@gmail.com
 * @package Blade
 * @subpackage Profile
 *
 */

namespace Drupal\blade\Profile;

use Psr\Log\LoggerInterface;
use Drupal\blade\Configuration\ConfigurationRunner;
use Drupal\blade\Configuration\ConfiguratorInterface;
use Drupal\blade\Configuration\ConfigurationRunnerInterface;

/**
 * Specific configurator for Blade profile
 * @since 1.0.0
 */
final class BladeConfiguration implements ConfigurationRunnerInterface
{
    /**
     * @var Drupal\blade\Configuration\ConfigurationRunner
     */
    private $runner;

    public function __construct(LoggerInterface $logger)
    {
        $this->runner = new ConfigurationRunner();

        $this->runner
            ->pipe(new ThemesConfigurator($logger))
            ->pipe(new FiltersConfigurator($logger))
            ->pipe(new TypesConfigurator($logger))
            ->pipe(new MenusConfigurator($logger))
            ->pipe(new BlocksConfigurator($logger))
            ->pipe(new RolesConfigurator($logger))
        ;
    }

    public function pipe(ConfiguratorInterface $conf)
    {
        return $this->runner->pipe($conf);
    }

    public function run()
    {
        return $this->runner->run();
    }

    /**
     * to match HOOK_install
     */
    public function install()
    {
        $this->run();
    }
}
