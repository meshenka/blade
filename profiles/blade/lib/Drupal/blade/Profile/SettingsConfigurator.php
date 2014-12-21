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
 * Configure text Fields input format filters
 * @since 1.0.0
 */
final class SettingsConfigurator extends AbstractConfigurator
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        variable_set('image_jpeg_quality', 84);

        return;
    }
}
