<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2017 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Debugger\Bar;

use WebinoDebug\Exception;
use WebinoDebug\Factory\EventProfilerFactory;
use WebinoDebug\Service\EventProfiler;
use Zend\ModuleManager\ModuleManager;

/**
 * Class EventPanel
 */
class EventPanel extends AbstractPanel implements PanelInterface
{
    /**
     * @var EventProfiler
     */
    private $eventProfiler;

    /**
     * @var string
     */
    protected $label = 'Events';

    /**
     * @var string
     */
    protected $title = 'Application events';

    /**
     * @var string
     */
    protected $content;

    /**
     * @param ModuleManager $modules
     */
    public function __construct(ModuleManager $modules)
    {
        $this->setEventProfiler((new EventProfilerFactory)->create($modules));
    }

    /**
     * @return EventProfiler
     * @throws Exception\LogicException
     */
    protected function getEventProfiler()
    {
        if (null === $this->eventProfiler) {
            throw new Exception\LogicException('Expected `eventProfiler`');
        }
        return $this->eventProfiler;
    }

    /**
     * @param EventProfiler $eventProfiler
     * @return self
     */
    public function setEventProfiler(EventProfiler $eventProfiler)
    {
        $this->eventProfiler = $eventProfiler;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTab()
    {
        return $this->createIcon('events', 'left: -1px; top: -3px;') . parent::getTab();
    }

    /**
     * {@inheritdoc}
     */
    public function getPanel()
    {
        return $this->renderTemplate('events');
    }
}
