<?php
/**
 * @package Blade
 * @subpackage Profile
 */

namespace Drupal\blade\Configuration;

/**
 * Configure Main menu
 */
final class MenusConfigurator extends AbstractConfigurator
{
    public function configure()
    {
        // Create a Home link in the main menu.
        $item = array(
            'link_title' => st('Home'),
            'link_path' => '<front>',
            'menu_name' => 'main-menu',
        );
        menu_link_save($item);

        // Update the menu router information.
        menu_rebuild();

        $this->log('Menus configured', self::LEVEL_SUCCESS);

        return $this->getMessages();
    }
}
