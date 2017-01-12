<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2017 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Factory;

use WebinoDebug\Listener\EventProfilerListener;
use WebinoDebug\Service\EventProfiler;
use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for an event profiler
 */
class EventProfilerFactory
{
    /**
     * Event profiler service name
     */
    const SERVICE = 'EventProfiler';

    /**
     * @param object|ModuleManager $modules
     * @return EventProfiler
     */
    public function create(ModuleManager $modules)
    {
        $services = $modules->getEvent()->getParam('ServiceManager');
        if ($services->has($this::SERVICE)) {
            return $services->get($this::SERVICE);
        }

        $sharedEvents = $modules->getEventManager()->getSharedManager();
        $eventProfiler = new EventProfiler($services->get(DebuggerFactory::SERVICE), $sharedEvents);
        $sharedEvents->attachAggregate(new EventProfilerListener($eventProfiler));
        $services->setService($this::SERVICE, $eventProfiler);
        return $eventProfiler;
    }
}
