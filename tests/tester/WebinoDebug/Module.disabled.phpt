<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2015 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

use Tester\Assert;
use Tracy\Debugger as Tracy;
use WebinoDebug\Factory\DebuggerFactory;
use WebinoDebug\Module;
use WebinoDebug\Options\ModuleOptions;
use WebinoDebug\Service\Debugger;
use Zend\EventManager\EventManager;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\ServiceManager;

require __DIR__ . '/../bootstrap.php';
$test = createTestCase();


$events  = $test->getMock(EventManager::class, [], [], '', false);
$modules = $test->getMock(ModuleManager::class, [], [], '', false);

$modules->expects($test->once())
    ->method('getEventManager')
    ->will($test->returnValue($events));

$events->expects($test->once())
    ->method('attach')
    ->will($test->returnCallback(function ($eventName, $callback) use ($test) {

        $test->assertSame(ModuleEvent::EVENT_LOAD_MODULES_POST, $eventName);
        $test->assertInstanceOf('closure', $callback);

        $event = new ModuleEvent;
        $services = $test->getMock(ServiceManager::class);
        $options = $test->getMock(ModuleOptions::class);
        $event->setParam('ServiceManager', $services);

        $options->expects($test->any())
            ->method('isDisabled')
            ->will($test->returnValue(true));

        foreach (['hasBar', 'getMode', 'getLog', 'getEmail', 'isStrict',
                     'getMaxDepth', 'getMaxLen', 'getTemplateMap'] as $method) {

            $options->expects($test->never())->method($method);
        }

        /** @var \WebinoDebug\Options\ModuleOptions $options */
        $debugger = new Debugger($options);

        $services->expects($test->any())
            ->method('get')
            ->with(DebuggerFactory::SERVICE)
            ->will($test->returnValue($debugger));

        $callback($event);
    }));


$module = new Module;
/** @var \Zend\ModuleManager\ModuleManagerInterface $modules */
$module->init($modules);


Assert::false(Tracy::isEnabled());
