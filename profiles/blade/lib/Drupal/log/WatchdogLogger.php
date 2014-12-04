<?php
/**
 * WatchdogLogger
 * @author meshee.knight@gmail.com
 *  A type of 'ok' or 'completed' can also be supplied to flag as a 'success'.
 */

namespace Drupal\log;

use Psr\Log\LoggerInterface;

/**
 * PSR-3 Logger implementation for watchdog()
 *
 */
final class WatchdogLogger implements LoggerInterface
{
    /**
     * @var string watchdog type message
     */
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function emergency($message, array $context = array())
    {
        $this->log(WATCHDOG_EMERGENCY, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function alert($message, array $context = array())
    {
        $this->log(WATCHDOG_ALERT, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function critical($message, array $context = array())
    {
        $this->log(WATCHDOG_CRITICAL, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function error($message, array $context = array())
    {
        $this->log(WATCHDOG_ERROR, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message, array $context = array())
    {
        $this->log(WATCHDOG_WARNING, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function notice($message, array $context = array())
    {
        $this->log(WATCHDOG_NOTICE, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, array $context = array())
    {
        $this->log(WATCHDOG_INFO, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function debug($message, array $context = array())
    {
        $this->log(WATCHDOG_DEBUG, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = array())
    {
        watchdog($this->type, $message, $context, $level);
    }
}
