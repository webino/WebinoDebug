<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2015 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug;

use Tracy\Debugger as Tracy;
use WebinoDebug\Debugger\Bar\ConfigPanel;
use WebinoDebug\Factory\ConfigPanelFactory;
use WebinoDebug\Factory\DebuggerFactory;
use WebinoDebug\Options\ModuleOptions;
use WebinoDebug\Service\Debugger;
use WebinoDebug\Tracy\Workaround\DisabledBar;
use Zend\EventManager\EventManager;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Resolver\TemplateMapResolver;

/**
 * Debugger module tests
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers WebinoDebug\Module::getConfig
     */
    public function testGetConfig()
    {
        $module = new Module;
        $config = $module->getConfig();
        $this->assertTrue(is_array($config));
    }

    /**
     * @covers WebinoDebug\Module::init
     */
    public function testInitDisabled()
    {
        $events  = $this->getMock(EventManager::class, [], [], '', false);
        $modules = $this->getMock(ModuleManager::class, [], [], '', false);

        $modules->expects($this->once())
            ->method('getEventManager')
            ->will($this->returnValue($events));

        $events->expects($this->once())
            ->method('attach')
            ->will($this->returnCallback(function ($eventName, $callback) {
                $this->assertSame(ModuleEvent::EVENT_LOAD_MODULES_POST, $eventName);
                $this->assertInstanceOf('closure', $callback);

                $event = new ModuleEvent;
                $services = $this->getMock(ServiceManager::class);
                $options = $this->getMock(ModuleOptions::class);
                $event->setParam('ServiceManager', $services);

                $options->expects($this->any())
                    ->method('isDisabled')
                    ->will($this->returnValue(true));

                foreach (['hasBar', 'getMode', 'getLog', 'getEmail', 'isStrict',
                             'getMaxDepth', 'getMaxLen', 'getTemplateMap'] as $method) {

                    $options->expects($this->never())->method($method);
                }

                /** @var \WebinoDebug\Options\ModuleOptions $options */
                $debugger = new Debugger($options);

                $services->expects($this->any())
                    ->method('get')
                    ->with(DebuggerFactory::SERVICE)
                    ->will($this->returnValue($debugger));

                $callback($event);
            }));

        $module = new Module;
        /** @var \Zend\ModuleManager\ModuleManagerInterface $modules */
        $module->init($modules);
        $this->assertFalse(Tracy::isEnabled());
    }

    /**
     * @covers WebinoDebug\Module::init
     */
    public function testInitEnabled()
    {
        $options = new Options\ModuleOptions([
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

        $events  = $this->getMock(EventManager::class, [], [], '', false);
        $modules = $this->getMock(ModuleManager::class, [], [], '', false);

        $modules->expects($this->once())
            ->method('getEventManager')
            ->will($this->returnValue($events));

        $events->expects($this->once())
            ->method('attach')
            ->will($this->returnCallback(function ($eventName, $callback) use ($options) {

                $this->assertSame(ModuleEvent::EVENT_LOAD_MODULES_POST, $eventName);
                $this->assertInstanceOf('closure', $callback);

                $event    = new ModuleEvent;
                $services = $this->getMock(ServiceManager::class);
                $event->setParam('ServiceManager', $services);

                $debugger = new Debugger($options);
                $configPanel = $this->getMock(ConfigPanel::class, [], [], '', false);

                $templateMapResolver = $this->getMock(TemplateMapResolver::class);
                $services->expects($this->exactly(3))
                    ->method('get')
                    ->withConsecutive(
                        [DebuggerFactory::SERVICE],
                        [ConfigPanelFactory::SERVICE]
                        ['ViewTemplateMapResolver']
                    )
                    ->will($this->onConsecutiveCalls(
                        $this->returnValue($debugger),
                        $this->returnValue($configPanel),
                        $this->returnValue($templateMapResolver)
                    ));

                $templateMapResolver->expects($this->once())
                    ->method('merge')
                    ->with($options->getTemplateMap());

                $callback($event);
            }));

        $module = new Module;
        /** @var \Zend\ModuleManager\ModuleManagerInterface $modules */
        $module->init($modules);
        $this->assertTrue(Tracy::isEnabled());
        $this->assertFalse(Tracy::$productionMode);
        $this->assertSame(DisabledBar::class, get_class(Tracy::getBar()));
        $this->assertSame($options->getLog(), Tracy::$logDirectory);
        $this->assertSame($options->getEmail(), Tracy::$email);
        $this->assertSame($options->isStrict(), Tracy::$strictMode);
        $this->assertSame($options->getMaxDepth(), Tracy::$maxDepth);
        $this->assertSame($options->getMaxLen(), Tracy::$maxLen);
    }
}
