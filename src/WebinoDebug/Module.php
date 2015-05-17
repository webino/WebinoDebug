<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2015 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug;

use WebinoDebug\Debugger\Bar\PanelInitInterface;
use WebinoDebug\Factory\DebuggerFactory;
use WebinoDebug\Factory\ModuleOptionsFactory;
use WebinoDebug\Options\ModuleOptions;
use Zend\ModuleManager\Feature;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManagerInterface;

/**
 * WebinoDebug module
 */
class Module implements Feature\InitProviderInterface
{
    /**
     * @param ModuleManagerInterface $modules
     */
    public function init(ModuleManagerInterface $modules)
    {
        // create debugger
        /** @var \Zend\ModuleManager\ModuleManager $modules */
        /** @var \Zend\ServiceManager\ServiceManager $services */
        $services = $modules->getEvent()->getParam('ServiceManager');
        $services->setFactory(ModuleOptionsFactory::SERVICE, ModuleOptionsFactory::class);
        $services->setFactory(DebuggerFactory::SERVICE, DebuggerFactory::class);
        $debugger = $services->get(DebuggerFactory::SERVICE);

        /** @var ModuleOptions $options */
        $options = $debugger->getOptions();
        if ($options->isDisabled()) {
            return;
        }

        // create bar panels
        $hasBar = $options->hasBar();
        if ($hasBar) {
            foreach ($options->getBarPanels() as $id => $barPanel) {
                $debugger->setBarPanel(new $barPanel($modules), $id);
            }
        }

        // finish debugger init
        $modules->getEventManager()->attach(
            ModuleEvent::EVENT_LOAD_MODULES_POST,
            function () use ($services, $debugger, $options, $hasBar) {

                // init bar panels
                if ($hasBar) {
                    foreach ($debugger->getBarPanels() as $barPanel) {
                        ($barPanel instanceof PanelInitInterface) and $barPanel->init($services);
                    }
                }

                // debugger templates
                $templateMap = $options->getTemplateMap();
                empty($templateMap) or $services->get('ViewTemplateMapResolver')->merge($templateMap);
            }
        );
    }
}
