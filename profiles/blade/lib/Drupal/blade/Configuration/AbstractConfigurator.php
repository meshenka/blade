<?php
/**
 * @author sylvain.gogel@gmail.com
 * @package Blade
 * @subpackage Configuration
 *
 */

namespace Drupal\blade\Configuration;

use Psr\Log\LoggerInterface;

/**
 * Abstract configurator Interface that provide helper for logger
 * @abstract
 * @since 1.0.0
 */
abstract class AbstractConfigurator implements ConfiguratorInterface
{
    /**
     * @var Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    abstract public function configure();
}
