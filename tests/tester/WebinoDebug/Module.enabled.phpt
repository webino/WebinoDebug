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
use WebinoDebug\Tracy\Workaround\DisabledBar;
use Zend\EventManager\EventManager;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Resolver\TemplateMapResolver;

require __DIR__ . '/../bootstrap.php';
$test = createTestCase();


$options = new ModuleOptions([
    'enabled'     => true,
    'mode'        => false,
    'bar'         => false,
    'log'         => 'data',
    'email'       => 'test@example.com',
    'strict'      => false,
    'maxDepth'    => 2,
    'maxLen'      => 9,
    'templateMap' => ['test' => 'example'],
]);

$events  = $test->getMock(EventManager::class, [], [], '', false);
$modules = $test->getMock(ModuleManager::class, [], [], '', false);

$modules->expects($test->once())
    ->method('getEventManager')
    ->will($test->returnValue($events));

$events->expects($test->once())
    ->method('attach')
    ->will($test->returnCallback(function ($eventName, $callback) use ($test, $options) {

        $test->assertSame(ModuleEvent::EVENT_LOAD_MODULES_POST, $eventName);
        $test->assertInstanceOf('closure', $callback);

        $event    = new ModuleEvent;
        $services = $test->getMock(ServiceManager::class);
        $event->setParam('ServiceManager', $services);

        $debugger = new Debugger($options);

        $templateMapResolver = $test->getMock(TemplateMapResolver::class);
        $services->expects($test->exactly(2))
            ->method('get')
            ->withConsecutive(
                [DebuggerFactory::SERVICE],
                ['ViewTemplateMapResolver']
            )
            ->will($test->onConsecutiveCalls(
                $test->returnValue($debugger),
                $test->returnValue($templateMapResolver)
            ));

        $templateMapResolver->expects($test->once())
            ->method('merge')
            ->with($options->getTemplateMap());

        $callback($event);
    }));


$module = new Module;
/** @var \Zend\ModuleManager\ModuleManagerInterface $modules */
$module->init($modules);


Assert::true(Tracy::isEnabled());
Assert::false(Tracy::$productionMode);
Assert::type(DisabledBar::class, Tracy::getBar());
Assert::same($options->getLog(), Tracy::$logDirectory);
Assert::same($options->getEmail(), Tracy::$email);
Assert::same($options->isStrict(), Tracy::$strictMode);
Assert::same($options->getMaxDepth(), Tracy::$maxDepth);
Assert::same($options->getMaxLen(), Tracy::$maxLen);
