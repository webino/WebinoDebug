<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

use Tester\Assert;
use Tracy\Debugger as Tracy;
use WebinoDebug\Module;
use WebinoDebug\Options\ModuleOptions;
use Zend\EventManager\EventManager;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\ServiceManager;

require __DIR__ . '/../bootstrap.php';
$test = createTestCase();


$event    = new ModuleEvent;
$events   = $test->getMock(EventManager::class, [], [], '', false);
$modules  = $test->getMock(ModuleManager::class, [], [], '', false);
$services = $test->getMock(ServiceManager::class);

$event->setParam('ServiceManager', $services);

$modules->expects($test->once())
    ->method('getEvent')
    ->will($test->returnValue($event));

$modules->expects($test->once())
    ->method('getEventManager')
    ->will($test->returnValue($events));

$options = new ModuleOptions;
$options->setEnabled(false);

$services->expects($test->once())
    ->method('get')
    ->with(ModuleOptions::class)
    ->will($test->returnValue($options));

$events->expects($test->once())
    ->method('attach')
    ->will($test->returnCallback(function ($eventName, $callback) use ($event, $test) {

        $test->assertSame(ModuleEvent::EVENT_LOAD_MODULES_POST, $eventName);
        $test->assertInstanceOf('closure', $callback);
        $callback($event);
    }));


$module = new Module;
/** @var \Zend\ModuleManager\ModuleManagerInterface $modules */
$module->init($modules);


Assert::false(Tracy::isEnabled());
