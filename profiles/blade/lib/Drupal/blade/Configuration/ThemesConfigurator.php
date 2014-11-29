<?php
/**
 * @package Blade
 * @subpackage Profile
 */

namespace Drupal\blade\Configuration;

/**
 * Configure admin and front office theme
 */
final class ThemesConfigurator extends AbstractConfigurator
{
    public function configure()
    {
        // Enable the admin theme.
        db_update('system')
            ->fields(array('status' => 1))
            ->condition('type', 'theme')
            ->condition('name', 'seven')
            ->execute();
        variable_set('admin_theme', 'seven');
        variable_set('node_admin_theme', '1');

        // Enable the admin theme.
        db_update('system')
            ->fields(array('status' => 1))
            ->condition('type', 'theme')
            ->condition('name', 'flatground')
            ->execute();

        variable_set('theme_default', 'flatground');

        variable_set('theme_flatground_settings', array(
            'toggle_logo' => 1,
            'toggle_name' => 1,
            'toggle_slogan' => 1,
            'toggle_favicon' => 1,
            'toggle_main_menu' => 0,
            'toggle_secondary_menu' => 0,
            'default_logo' => 0,
            'logo_path' => '/profiles/blade/themes/custom/flatground/images/knuckles-small.png',
            //'logo_upload' =>,
            'default_favicon' => 1,
            'favicon_path' => '/profiles/blade/themes/custom/flatground/favicon.ico',
            'zen_breadcrumb' => 'yes',
            'zen_breadcrumb_separator' => ' › ',
            'zen_breadcrumb_home' => 1,
            'zen_breadcrumb_trailing' => 0,
            'zen_breadcrumb_title' => 1,
            'zen_skip_link_anchor' => 'main-menu',
            'zen_skip_link_text' => t('Jump to navigation'),
            'zen_html5_respond_meta' => array(
                'respond' => 'respond',
                'html5' => 'html5',
                'meta' => 'meta',
                ),
            'zen_rebuild_registry' => 0,
            'zen_wireframes' => 0,
            )
        );

        $this->log('Themes configured', self::LEVEL_SUCCESS);

        return $this->getMessages();
    }
}
