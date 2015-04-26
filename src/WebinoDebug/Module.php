<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2015 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug;

use WebinoDebug\Options\ModuleOptions;
use Zend\ModuleManager\Feature;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManagerInterface;

/**
 * WebinoDebug module
 */
class Module implements
    Feature\InitProviderInterface,
    Feature\ConfigProviderInterface
{
    /**
     * @param ModuleManagerInterface $modules
     */
    public function init(ModuleManagerInterface $modules)
    {
        $modules->getEventManager()->attach(
            ModuleEvent::EVENT_LOAD_MODULES_POST,
            function (ModuleEvent $event) {

                /* @var \Zend\ServiceManager\ServiceManager $services */
                $services = $event->getParam('ServiceManager');
                /** @var \WebinoDebug\Service\Debugger $debugger */
                $debugger = $services->get('Debugger');
                $options  = $debugger->getOptions();

                if ($options->isDisabled()) {
                    return;
                }

                // set debugger bar panels
                if ($options->hasBar()) {
                    foreach ($options->getBarPanels() as $barPanel) {
                        $debugger->setBarPanel(is_string($barPanel) ? $services->get($barPanel) : $barPanel);
                    }
                }

                // set debugger template map
                if ($options instanceof ModuleOptions) {
                    $templateMap = $options->getTemplateMap();
                    empty($templateMap) or $services->get('ViewTemplateMapResolver')->merge($templateMap);
                }
            }
        );
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return require __DIR__ . '/../../config/module.config.php';
    }
}
