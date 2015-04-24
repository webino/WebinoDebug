<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2015 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Factory;

use WebinoDebug\Debugger\Bar\ConfigPanel;
use WebinoDebug\Options\ModuleOptions;
use WebinoDebug\Service\DebuggerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for a debugger config panel
 */
class ConfigPanelFactory implements FactoryInterface
{
    /**
     * Config panel service name
     */
    const SERVICE = 'DebuggerConfigPanel';

    /**
     * @param ServiceLocatorInterface $services
     * @return DebuggerInterface
     */
    public function createService(ServiceLocatorInterface $services)
    {
        /* @var $modules ModuleOptions */
        $debugger = $services->get(DebuggerFactory::SERVICE);
        $config   = array_merge(['core' => $services->get('ApplicationConfig')], $services->get('Config'));
        return new ConfigPanel($config, $debugger);
    }
}
