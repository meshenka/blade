<?php
/**
 * @author sylvain.gogel@gmail.com
 * @package Blade
 * @subpackage Profile
 *
 */

namespace Drupal\blade\Profile;

use Drupal\blade\Configuration\AbstractConfigurator;

/**
 * Configure Main menu
 * @since 1.0.0
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

        $this->logger->info('Menus configured');
    }
}
