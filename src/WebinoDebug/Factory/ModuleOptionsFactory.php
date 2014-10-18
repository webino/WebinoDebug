<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014 Webino, s. r. o. (http://webino.sk/)
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
     * @return ModuleOptions
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Config');
        return new ModuleOptions(!empty($config['webino_debug']) ? $config['webino_debug'] : []);
    }
}
