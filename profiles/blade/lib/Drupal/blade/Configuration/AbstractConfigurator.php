<?php
/**
 * @package Blade
 * @subpackage Profile
 */

namespace Drupal\blade\Configuration;

/**
 * provide a helper to manage log message
 * @abstract
 */
abstract class AbstractConfigurator implements ConfiguratorInterface
{
    /**
     * @var array
     */
    private $messages = [];

    protected function log($message, $level = self::LEVEL_NOTICE)
    {
        $this->messages[] = [$message, $level];
    }

    public function getMessages()
    {
        return $this->messages;
    }

    abstract public function configure();
}
