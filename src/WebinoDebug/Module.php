<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug;

use WebinoDebug\Factory\DebuggerFactory;
use WebinoDebug\Factory\ModuleOptionsFactory;
use WebinoDebug\Options\ModuleOptions;
use WebinoDebug\Service\NullDebugger;
use Zend\Http\PhpEnvironment\Request;
use Zend\ModuleManager\Feature;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\ServiceManager\ServiceManager;

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
        /** @var \Zend\ModuleManager\ModuleManager $modules */
        /** @var ServiceManager $services */
        $services = $modules->getEvent()->getParam('ServiceManager');
        $services->setFactory(ModuleOptions::class, ModuleOptionsFactory::class);
        $services->setFactory(DebuggerFactory::SERVICE, DebuggerFactory::class);

        /** @var ModuleOptions $options */
        $options = $services->get(ModuleOptions::class);

        // set error log path
        ini_set('error_log', $options->getPhpErrorLog());

        // return early when disabled
        if ($options->isDisabled()) {
            return;
        }

        // init debugger
        $this->sessionStart();
        /** @var Service\Debugger $debugger */
        $debugger = $services->get(DebuggerFactory::SERVICE);

        // add a service initializer
        // TODO something better
        $modules->getEventManager()->attach(
            ModuleEvent::EVENT_LOAD_MODULES_POST,
            function () use ($services, $debugger) {

                $initializer = function ($obj) use ($debugger) {
                    if ($obj instanceof Service\DebuggerAwareInterface) {
                        /** @var Service\Debugger $debugger */
                        $obj->setDebugger($debugger);
                    }
                };

                $services->addInitializer($initializer);
                foreach ($services->getRegisteredServices()['instances'] as $name) {
                    $instance = $services->get($name);
                    ($instance instanceof ServiceManager) and $instance->addInitializer($initializer);
                }
            }
        );

        // return early on null debugger
        if ($debugger instanceof NullDebugger) {
            return;
        }

        // create bar panels
        $showBar   = $options->hasBar();
        $barPanels = $options->getBarPanels();

        if ($showBar) {
            // set core bar panels
            foreach ($barPanels as $id => $barPanel) {
                $debugger->setBarPanel(new $barPanel($modules), $id);
            }
        }

        // finish debugger init
        $modules->getEventManager()->attach(
            ModuleEvent::EVENT_LOAD_MODULES_POST,
            function () use ($services, $debugger, $options, $showBar, $barPanels) {

                // update module options
                /** @var ModuleOptions $newOptions */
                $newOptions = $services->create(ModuleOptions::class);
                $options->setFromArray($newOptions->toArray());

                if ($showBar) {
                    // set additional bar panels
                    $newBarPanels = array_diff($options->getBarPanels(), $barPanels);
                    foreach ($newBarPanels as $id => $barPanel) {
                        $debugger->setBarPanel($services->get($barPanel), $id);
                    }

                    // init bar panels
                    foreach ($debugger->getBarPanels() as $barPanel) {
                        ($barPanel instanceof Debugger\PanelInitInterface) and $barPanel->init($services);
                    }
                }

                // debugger templates
                $templateMap = $options->getTemplateMap();
                empty($templateMap) or $services->get('ViewTemplateMapResolver')->merge($templateMap);
            }
        );
    }

    /**
     * Start session for Ajax debug support
     *
     * Simplified session start with basic cookie params.
     *
     * @return void
     */
    private function sessionStart()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            $request = new Request;
            session_set_cookie_params(
                0,
                $request->getBasePath(),
                null,
                $request->getUri()->getScheme() === 'https',
                true
            );
            session_start();
        }
    }
}
