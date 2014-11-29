<?php
/**
 * @package Blade
 * @subpackage Profile
 */

namespace Drupal\blade\Configuration;

/**
 * Specific configurator for Blade profile
 */
class BladeConfiguration implements ConfigurationRunnerInterface
{
    private $runner;
    public function __construct()
    {
        $this->runner = new ConfigurationRunner();

        $this->runner
            ->pipe(new ThemesConfigurator())
            ->pipe(new FiltersConfigurator())
            ->pipe(new TypesConfigurator())
            ->pipe(new MenusConfigurator())
            ->pipe(new BlocksConfigurator())
            ->pipe(new RolesConfigurator())
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
        $output = $this->run();

        foreach ($output as $m) {
            list($msg, $level) = $m;
            watchdog('blade', $msg, WATCHDOG_INFO);
        }
    }
}
