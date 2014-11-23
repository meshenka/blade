<?php


function ac_configure_menus()
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
}
