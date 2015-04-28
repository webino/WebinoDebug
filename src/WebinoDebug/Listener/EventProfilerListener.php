<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2015 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Listener;

use WebinoDebug\Service\EventProfiler;
use Zend\EventManager\EventInterface;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;

/**
 * Class EventProfilerListener
 */
class EventProfilerListener implements SharedListenerAggregateInterface
{
    /**
     * Event highest priority
     */
    const HIGHEST_PRIORITY = 9999999999;

    /**
     * @var EventProfiler
     */
    protected $eventProfiler;

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = [];

    /**
     * @param object|EventProfiler $eventProfiler
     */
    public function __construct(EventProfiler $eventProfiler)
    {
        $this->eventProfiler = $eventProfiler;
    }

    /**
     * {@inheritdoc}
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('*', '*', [$this, 'onAnyEvent'], self::HIGHEST_PRIORITY);
    }

    /**
     * {@inheritdoc}
     */
    public function detachShared(SharedEventManagerInterface $events)
    {
        foreach ($this->listeners as $key => $listener) {
            if ($events->detach('*', '*', $listener)) {
                unset($this->listeners[$key]);
            }
        }
    }

    /**
     * @param EventInterface $event
     */
    public function onAnyEvent(EventInterface $event)
    {
        $this->eventProfiler->setEvent($event);
    }
}
