<?php
/**
 * DrushLogger
 * @author meshee.knight@gmail.com
 *  A type of 'ok' or 'completed' can also be supplied to flag as a 'success'.
 */

namespace Drupal\log;

use Psr\Log\LoggerInterface;

/**
 * PSR-3 Logger implementation for drush_log()
 *
 */
final class DrushLogger implements LoggerInterface
{
    const LEVEL_WARNING = 'warning';
    const LEVEL_ERROR = 'error';
    const LEVEL_SUCCESSS = 'success';
    const LEVEL_NOTICE = 'notice';
    const LEVEL_FAILED = 'failed';
    const LEVEL_OK = 'ok';
    const LEVEL_COMPLETED = 'completed';

    /**
     * {@inheritdoc}
     */
    public function emergency($message, array $context = array())
    {
        $this->log(self::LEVEL_FAILED, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function alert($message, array $context = array())
    {
        $this->log(self::LEVEL_ERROR, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function critical($message, array $context = array())
    {
        $this->log(self::LEVEL_FAILED, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function error($message, array $context = array())
    {
        $this->log(self::LEVEL_ERROR, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message, array $context = array())
    {
        $this->log(self::LEVEL_WARNING, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function notice($message, array $context = array())
    {
        $this->log(self::LEVEL_NOTICE, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, array $context = array())
    {
        $this->log(self::LEVEL_OK, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function debug($message, array $context = array())
    {
        $this->log(self::LEVEL_NOTICE, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = array())
    {
        drush_log(dt($message, $context), $level);
    }
}
