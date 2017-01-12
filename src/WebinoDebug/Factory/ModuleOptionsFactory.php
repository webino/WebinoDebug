<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2017 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Factory;

use WebinoDebug\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for module options
 */
class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * Module options service name
     */
    const SERVICE = 'DebuggerOptions';

    /**
     * Configuration service section key
     */
    const CONFIG_KEY = 'webino_debug';

    /**
     * @param ServiceLocatorInterface $services
     * @return ModuleOptions
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('ApplicationConfig');
        return new ModuleOptions(empty($config[$this::CONFIG_KEY]) ? [] : $config[$this::CONFIG_KEY]);
    }
}
