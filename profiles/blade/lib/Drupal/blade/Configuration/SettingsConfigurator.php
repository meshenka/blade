<?php
/**
 * @package Blade
 * @subpackage Profile
 */

namespace Drupal\blade\Configuration;

use Psr\Log\LoggerAwareTrait;

/**
 * Configure text Fields input format filters
 */
final class SettingsConfigurator extends AbstractConfigurator
{
    use LoggerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        variable_set('image_jpeg_quality', 84);

        return;
    }
}
