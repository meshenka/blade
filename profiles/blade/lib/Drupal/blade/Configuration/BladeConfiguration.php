<?php
/**
 * @package Blade
 * @subpackage Profile
 */

namespace Drupal\blade\Configuration;

/**
 * Specific configurator for Blade profile
 */
class BladeConfiguration extends ConfigurationRunner
{
    public function __construct()
    {
        $this
            ->pipe(new ThemesConfigurator())
            ->pipe(new FiltersConfigurator())
            ->pipe(new TypesConfigurator())
            ->pipe(new MenusConfigurator())
            ->pipe(new BlocksConfigurator())
            ->pipe(new RolesConfigurator())
        ;
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
