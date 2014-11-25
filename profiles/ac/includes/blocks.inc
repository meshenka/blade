<?php


function ac_configure_blocks()
{
    // Enable some standard blocks.
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
    try {
        $query = db_insert('block')->fields(array('module', 'delta', 'theme', 'status', 'weight', 'region', 'pages', 'cache'));
        foreach ($blocks as $block) {
            $query->values($block);
        }
        $query->execute();

        return 'Done';
    } catch (\PDOException $ex) {
        return 'Already done';
    }
}
