<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

use Tester\Assert;
use Tracy\Bar;
use Tracy\Debugger as Tracy;
use WebinoDebug\Debugger\Bar\ConfigPanel;
use WebinoDebug\Factory\DebuggerFactory;
use WebinoDebug\Module;
use WebinoDebug\Options\ModuleOptions;
use Zend\EventManager\EventManager;
use Zend\EventManager\SharedEventManager;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Resolver\TemplateMapResolver;

require __DIR__ . '/../bootstrap.php';
$test = createTestCase();


$options = new ModuleOptions([
    'enabled'      => true,
    'mode'         => false,
    'bar'          => true,
    'log'          => 'data',
    'email'        => 'test@example.com',
    'strict'       => false,
    'max_depth'    => 2,
    'max_length'   => 9,
    'template_map' => ['test' => 'example'],
]);

$event        = new ModuleEvent;
$events       = $test->getMock(EventManager::class, [], [], '', false);
$sharedEvents = $test->getMock(SharedEventManager::class, [], [], '', false);
$modules      = $test->getMock(ModuleManager::class, [], [], '', false);
$services     = $test->getMock(ServiceManager::class);

$event->setParam('ServiceManager', $services);

$modules->expects($test->atLeastOnce())
    ->method('getEvent')
    ->will($test->returnValue($event));

$modules->expects($test->atLeastOnce())
    ->method('getEventManager')
    ->will($test->returnValue($events));

$events->expects($test->once())
    ->method('getSharedManager')
    ->will($test->returnValue($sharedEvents));

$configPanel = $test->getMock(ConfigPanel::class, [], [], '', false);

$debugger = null;
$returnDebugger = $test->returnCallback(
    function () use ($services, &$debugger) {
        if (null === $debugger) {
            $debugger = (new DebuggerFactory)->createService($services);
        }
        return $debugger;
    }
);

$templateMapResolver = $test->getMock(TemplateMapResolver::class);
$services->expects($test->exactly(10))
    ->method('get')
    ->withConsecutive(
        [ModuleOptions::class],
        [DebuggerFactory::SERVICE],
        [ModuleOptions::class],
        [DebuggerFactory::SERVICE],
        [ModuleOptions::class],
        [DebuggerFactory::SERVICE],
        ['ApplicationConfig'],
        ['Config'],
        [DebuggerFactory::SERVICE],
        ['ViewTemplateMapResolver']
    )
    ->will($test->onConsecutiveCalls(
        $test->returnValue($options),
        $returnDebugger,
        $test->returnValue($options),
        $returnDebugger,
        $test->returnValue($options),
        $returnDebugger,
        [],
        [],
        $returnDebugger,
        $test->returnValue($templateMapResolver)
    ));

$services->expects($test->once())
    ->method('create')
    ->with(ModuleOptions::class)
    ->will($test->returnValue($options));

$templateMapResolver->expects($test->once())
    ->method('merge')
    ->with($options->getTemplateMap());

$events->expects($test->any())
    ->method('attach')
    ->will($test->returnCallback(function ($eventName, $callback) use ($event, $test) {

        $test->assertSame(ModuleEvent::EVENT_LOAD_MODULES_POST, $eventName);
        $test->assertInstanceOf('closure', $callback);

        $callback($event);
    }));


$module = new Module;
/** @var \Zend\ModuleManager\ModuleManagerInterface $modules */
$module->init($modules);


Assert::true(Tracy::isEnabled());
Assert::false(Tracy::$productionMode);
Assert::type(Bar::class, Tracy::getBar());
Assert::same($options->getLog(), Tracy::$logDirectory);
Assert::same($options->getEmail(), Tracy::$email);
Assert::same($options->isStrict(), Tracy::$strictMode);
Assert::same($options->getMaxDepth(), Tracy::$maxDepth);
Assert::same($options->getMaxLength(), Tracy::$maxLength);
