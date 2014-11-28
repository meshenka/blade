<?php
/**
 * @package Blade
 * @subpackage profile
 */

namespace Drupal\ac\Configuration;

abstract class AbstractConfigurator implements ConfiguratorInterface
{
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
