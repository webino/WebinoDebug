<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Factory;

use WebinoDebug\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;

/**
 * Factory for module options
 */
class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * Module options service name
     * @deprecated use \WebinoDebug\Options\ModuleOptions::class instead
     */
    const SERVICE = ModuleOptions::class;

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
        $appConfig = $services->get('ApplicationConfig');
        $config = $services->has('Config') ? $services->get('Config') : [];
        $options = ArrayUtils::merge(
            !empty($appConfig[$this::CONFIG_KEY]) ? $appConfig[$this::CONFIG_KEY] : [],
            !empty($config[$this::CONFIG_KEY]) ? $config[$this::CONFIG_KEY] : []
        );
        return new ModuleOptions($options);
    }
}
