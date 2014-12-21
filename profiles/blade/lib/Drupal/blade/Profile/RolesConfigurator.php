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
 * Configure administrator and webmaster roles
 * @since 1.0.0
 */
final class RolesConfigurator extends AbstractConfigurator
{
    public function configure()
    {
        // Create a default role for site administrators, with all available permissions assigned.
        $admin_role = new \stdClass();
        $admin_role->name = 'administrator';
        $admin_role->weight = 2;

        try {
            user_role_save($admin_role);
            user_role_grant_permissions($admin_role->rid, array_keys(module_invoke_all('permission')));
            // Set this as the administrator role.
            variable_set('user_admin_role', $admin_role->rid);

            // Assign user 1 the "administrator" role.
            db_insert('users_roles')
                ->fields(array('uid' => 1, 'rid' => $admin_role->rid))
                ->execute();

            $this->logger->info("Role {$admin_role->name} initialized");
        } catch (\PDOException $ex) {
            $this->logger->warning("Role {$admin_role->name} already created");
        }

        // Create a default role for site administrators, with all available permissions assigned.
        $webmaster_role = new \stdClass();
        $webmaster_role->name = 'webmaster';
        $webmaster_role->weight = 3;
        try {
            user_role_save($webmaster_role);

            //@TODO assign permissions for webmaster
            $this->logger->info("Role {$webmaster_role->name} initialized");
        } catch (\PDOException $ex) {
            $this->logger->warning("Role {$webmaster_role->name} already created");
        }
    }
}
