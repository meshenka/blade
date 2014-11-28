<?php
/**
 * @package Blade
 * @author meshenka <meshee.knight@gmail.com>
 */

namespace Drupal\blade\Configuration;

/**
 * generic profile configurator interface
 */
interface ConfiguratorInterface
{
    const LEVEL_ERROR = 'error';
    const LEVEL_SUCCESS = 'success';
    const LEVEL_NOTICE = 'notice';

    /**
     * configure some of drupal aspects
     * @return array an array of array(message, level) as per drush_log spec
     */
    public function configure();
}
