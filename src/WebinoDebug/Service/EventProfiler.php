<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Service;

use ReflectionFunction;
use WebinoDebug\Debugger\DebuggerInterface;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventsCapableInterface;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\Stdlib\CallbackHandler;
use Zend\Stdlib\PriorityQueue;

/**
 * Class EventProfiler
 */
class EventProfiler
{
    /**
     * Debug backtrace limit
     */
    const BACKTRACE_LIMIT = 6;

    /**
     * @var DebuggerInterface
     */
    protected $debugger;

    /**
     * @var SharedEventManagerInterface
     */
    protected $sharedEvents;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    private $cwd;

    /**
     * @var EventInterface
     */
    private $lastEvent;

    /**
     * @var string
     */
    private $lastKey;

    /**
     * @param object|DebuggerInterface $debugger
     * @param object|SharedEventManagerInterface $sharedEvents
     */
    public function __construct(DebuggerInterface $debugger, SharedEventManagerInterface $sharedEvents)
    {
        $this->debugger     = $debugger;
        $this->sharedEvents = $sharedEvents;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $this->lastEvent and $this->setEvent($this->lastEvent);
        return $this->data;
    }

    /**
     * @param EventInterface $event
     */
    public function setEvent(EventInterface $event)
    {
        $key  = $this->createEventKey($event);
        $time = $this->debugger->timer(__CLASS__)->getDelta();

        $this->lastKey and $this->data[$this->lastKey]['time']+= $time;

        if (isset($this->data[$key])) {
            return;
        }

        $this->data[$key] = [
            'time'        => 0,
            'caller'      => $this->createCallerTrace(),
            'event'       => $this->createEventManagerCallbacks($event),
            'sharedEvent' => $this->createSharedEventManagerCallbacks($event),
        ];

        $this->lastEvent = $event;
        $this->lastKey   = $key;
    }

    /**
     * @param EventInterface $event
     * @return string
     */
    protected function createEventKey(EventInterface $event)
    {
        $id = get_class($event->getTarget());
        return sprintf('%s::%s', $id, $event->getName());
    }

    /**
     * @return array
     */
    protected function createCallerTrace()
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $this::BACKTRACE_LIMIT);
        $index = $this::BACKTRACE_LIMIT - 1;

        if (isset($backtrace[$index])
            && false !== strpos($backtrace[$index]['function'], 'trigger')
        ) {
            return [
                'file' => $backtrace[$index]['file'],
                'line' => $backtrace[$index]['line'],
            ];
        }

        return [
            'file' => null,
            'line' => null
        ];
    }

    /**
     * @param EventInterface $event
     * @return array
     */
    protected function createEventManagerCallbacks(EventInterface $event)
    {
        $target = $event->getTarget();
        $name   = $event->getName();

        $callbacks = [];
        if (is_object($target)
            && $target instanceof EventsCapableInterface
        ) {

            $events = $target->getEventManager();
            if ($events instanceof EventManager) {
                $listeners = $events->getListeners($name);
                $callbacks = $this->resolveCallbacks($listeners);
            }
        }

        return $callbacks;
    }

    /**
     * @param EventInterface $event
     * @return array
     */
    protected function createSharedEventManagerCallbacks(EventInterface $event)
    {
        $target = $event->getTarget();
        $id     = get_class($target);
        $name   = $event->getName();

        $callbacks = [];
        $sharedListeners = $this->sharedEvents->getListeners($id, $name);
        if ($sharedListeners !== false) {
            $callbacks = $this->resolveCallbacks($sharedListeners);
        }

        return $callbacks;
    }

    /**
     * @param PriorityQueue $listeners
     * @return array
     */
    protected function resolveCallbacks(PriorityQueue $listeners)
    {
        $callbacks = [];
        foreach ($listeners as $listener) {
            if ($listener instanceof CallbackHandler) {
                $callbacks[] = $this->resolveCallbackFromListener($listener);
            }
        }

        return $callbacks;
    }

    /**
     * @param CallbackHandler $listener
     * @return array
     */
    protected function resolveCallbackFromListener(CallbackHandler $listener)
    {
        $callback = $listener->getCallback();
        $priority = (int) $listener->getMetadatum('priority');

        if ($callback instanceof \Closure) {
            $id = $this->resolveCallbackIdFromClosure($callback);

        } elseif (is_array($callback) && count($callback) === 2 && is_object($callback[0])) {
            $id = $this->createMethodName($callback[0], $callback[1]);

        } elseif (is_string($callback)) {
            $id = $callback;

        } elseif (is_object($callback) && is_callable($callback)) {
            $id = $this->createMethodName((object) $callback, '__invoke');

        } else {
            $id = 'Unknown callback';
        }

        return [
            'callback' => $id,
            'priority' => $priority,
        ];
    }

    /**
     * @param \Closure $function
     * @return string
     */
    protected function resolveCallbackIdFromClosure(\Closure $function)
    {
        try {
            $ref   = new ReflectionFunction($function);
            $file  = $ref->getFileName();
            $start = $ref->getStartLine();
            $end   = $ref->getEndLine();

            return sprintf('Closure: %s:%d-%d', $file, $start, $end);
        } catch (\Throwable $exc) {
            error_log($exc);
        }

        return '';
    }

    /**
     * @param object $object
     * @param string $method
     * @return string
     */
    protected function createMethodName($object, $method)
    {
        return sprintf('%s::%s()', get_class($object), $method);
    }
}
