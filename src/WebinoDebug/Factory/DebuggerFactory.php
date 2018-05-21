<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Factory;

use WebinoDebug\Debugger\DebuggerInterface;
use WebinoDebug\Options\ModuleOptions;
use WebinoDebug\Service\Debugger;
use WebinoDebug\Service\NullDebugger;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for a debugger
 */
class DebuggerFactory implements FactoryInterface
{
    /**
     * Debugger service name
     */
    const SERVICE = 'Debugger';

    /**
     * @param ServiceLocatorInterface $services
     * @return DebuggerInterface
     */
    public function createService(ServiceLocatorInterface $services)
    {
        /* @var $modules ModuleOptions */
        $options = $services->get(ModuleOptions::class);
        return $options->isEnabled() ? new Debugger($options) : new NullDebugger;
    }
}
