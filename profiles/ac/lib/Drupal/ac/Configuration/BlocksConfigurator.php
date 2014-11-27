<?php
/**
 * @package Blade
 * @subpackage Profile
 */

namespace Drupal\ac\Configuration;

class BlocksConfigurator extends AbstractConfigurator
{
    public function configure()
    {    // Enable some standard blocks.
        $default_theme = variable_get('theme_default', 'flatac');
        $admin_theme = 'seven';

        $blocks = array(
            array(
                'module' => 'system',
                'delta' => 'main',
                'theme' => $default_theme,
                'status' => 1,
                'weight' => 0,
                'region' => 'content',
                'pages' => '',
                'cache' => -1,
                ),
            array(
                'module' => 'search',
                'delta' => 'form',
                'theme' => $default_theme,
                'status' => 1,
                'weight' => -1,
                'region' => 'sidebar_first',
                'pages' => '',
                'cache' => -1,
                ),
            array(
                'module' => 'system',
                'delta' => 'navigation',
                'theme' => $default_theme,
                'status' => 1,
                'weight' => 0,
                'region' => 'sidebar_first',
                'pages' => '',
                'cache' => -1,
                ),
            array(
                'module' => 'system',
                'delta' => 'help',
                'theme' => $default_theme,
                'status' => 1,
                'weight' => 0,
                'region' => 'help',
                'pages' => '',
                'cache' => -1,
                ),
            array(
                'module' => 'system',
                'delta' => 'main',
                'theme' => $admin_theme,
                'status' => 1,
                'weight' => 0,
                'region' => 'content',
                'pages' => '',
                'cache' => -1,
                ),
            array(
                'module' => 'system',
                'delta' => 'help',
                'theme' => $admin_theme,
                'status' => 1,
                'weight' => 0,
                'region' => 'help',
                'pages' => '',
                'cache' => -1,
                ),
            array(
                'module' => 'search',
                'delta' => 'form',
                'theme' => $admin_theme,
                'status' => 1,
                'weight' => -10,
                'region' => 'dashboard_sidebar',
                'pages' => '',
                'cache' => -1,
                ),
            );
        $query = db_insert('block')->fields(array('module', 'delta', 'theme', 'status', 'weight', 'region', 'pages', 'cache'));
        foreach ($blocks as $block) {
            try {
                $query->values($block);
                $query->execute();
                $this->log("Init block {$block['module']}-{$block['delta']} for theme {$block['theme']}", self::LEVEL_SUCCESS);
            } catch (\PDOException $ex) {
                $this->log("Block {$block['module']}-{$block['delta']} for theme {$block['theme']} already initialized");
            }
        }

        return $this->getMessages();
    }
}
