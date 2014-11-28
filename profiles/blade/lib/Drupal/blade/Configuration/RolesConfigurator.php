<?php
/**
 * @package Blade
 * @subpackage Profile
 */

namespace Drupal\blade\Configuration;

/**
 * Configure administrator and webmaster roles
 */
class RolesConfigurator extends AbstractConfigurator
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

            $this->log("Role {$admin_role->name} initialized", self::LEVEL_SUCCESS);
        } catch (\PDOException $ex) {
            $this->log("Role {$admin_role->name} already created", self::LEVEL_SUCCESS);
        }

        // Create a default role for site administrators, with all available permissions assigned.
        $webmaster_role = new \stdClass();
        $webmaster_role->name = 'webmaster';
        $webmaster_role->weight = 3;
        try {
            user_role_save($webmaster_role);

            //@TODO assign permissions for webmaster
            $this->log("Role {$webmaster_role->name} initialized", self::LEVEL_SUCCESS);
        } catch (\PDOException $ex) {
            $this->log("Role {$webmaster_role->name} already created", self::LEVEL_SUCCESS);
        }

        return $this->getMessages();
    }
}
