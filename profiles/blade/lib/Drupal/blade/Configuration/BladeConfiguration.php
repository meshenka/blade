<?php
/**
 * @package Blade
 * @subpackage Profile
 */

namespace Drupal\blade\Configuration;

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
}
