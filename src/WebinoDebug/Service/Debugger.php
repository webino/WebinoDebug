<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Service;

use Tracy\Debugger as Tracy;
use WebinoDebug\Debugger\Bar\PanelInterface;
use WebinoDebug\Debugger\DebuggerBarInterface;
use WebinoDebug\Debugger\DebuggerDump;
use WebinoDebug\Debugger\DebuggerInterface;
use WebinoDebug\Debugger\DebuggerTimer;
use WebinoDebug\Options\DebuggerOptions;
use Zend\Stdlib\ArrayUtils;

/**
 * Class Debugger
 */
class Debugger implements
    DebuggerInterface,
    DebuggerBarInterface
{
    /**
     * @var DebuggerOptions
     */
    private $options;

    /**
     * @var array
     */
    protected $barPanels = [];

    /**
     * @var \WebinoDebug\Debugger\DebuggerTimer
     */
    protected $timerPrototype;

    /**
     * @param array|DebuggerOptions $options
     */
    public function __construct($options = null)
    {
        $_options = ($options instanceof DebuggerOptions)
            ? $options
            : new DebuggerOptions((array) $options);

        $this->options = $_options;
        if ($_options->isDisabled() || Tracy::isEnabled()) {
            return;
        }

        Tracy::$customCssFiles = $options->getCssFiles();
        Tracy::$customJsFiles  = $options->getJsFiles();

        $showBar = $_options->showBar();
        if ($showBar) {

            $options->hasBarNoLogo()
                and Tracy::$customCssFiles[] = __DIR__ . '/../../../data/assets/Bar/no-logo.css';

            $options->hasBarNoClose()
                and Tracy::$customCssFiles[] = __DIR__ . '/../../../data/assets/Bar/no-close.css';
        }

        Tracy::$showBar    = $showBar;
        Tracy::$strictMode = $_options->isStrict();
        Tracy::$maxDepth   = $_options->getMaxDepth();
        Tracy::$maxLength  = $_options->getMaxLength();

        Tracy::enable(
            $_options->getMode(),
            $_options->getLog(),
            $_options->getEmail()
        );
    }

    /**
     * @return DebuggerOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return PanelInterface[]
     */
    public function getBarPanels()
    {
        return $this->barPanels;
    }

    /**
     * @param string $id
     * @return PanelInterface|null
     */
    public function getBarPanel($id)
    {
        /** @var PanelInterface $panel */
        $panel = Tracy::getBar()->getPanel($id);
        return $panel;
    }

    /**
     * Set debugger bar panel
     *
     * @param object|PanelInterface|null $panel Panel object
     * @param string $id Panel id
     * @return $this
     */
    public function setBarPanel(PanelInterface $panel = null, $id = null)
    {
        $panel and Tracy::getBar()->addPanel($this->barPanels[$id] = $panel, $id);
        return $this;
    }

    /**
     * Set debugger bar info
     *
     * @param string $label Info label
     * @param string|int $value Info value
     * @return $this
     */
    public function setBarInfo(string $label, $value)
    {
        /** @var \Tracy\DefaultBarPanel $panel */
        $panel = $this->getBarPanel('Tracy:info');
        $panel and $panel->data = ArrayUtils::merge((array) $panel->data, [$label => (string) $value]);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function dump($subject)
    {
        return (new DebuggerDump($subject));
    }

    /**
     * {@inheritdoc}
     */
    public function timer($name = null)
    {
        return $this->createDebuggerTimer()->setName($name)->start();
    }

    /**
     * @return DebuggerTimer
     */
    private function createDebuggerTimer()
    {
        if (!$this->timerPrototype) {
            /** @var \WebinoDebug\Debugger\Bar\TimerPanel $timerPanel */
            $timerPanel = $this->getBarPanel('WebinoDebug:timer');
            $this->timerPrototype = new DebuggerTimer($timerPanel);
        }
        return clone $this->timerPrototype;
    }

    /**
     * {@inheritdoc}
     * @deprecated use dump() instead, now it returns stringable object
     */
    public function dumpStr($subject)
    {
        return $this->dump($subject);
    }

    /**
     * {@inheritdoc}
     * @deprecated use dump() instead, now it returns object
     */
    public function barDump($subject, $title = null, array $options = null)
    {
        return $this->dump($subject)->toBar($title);
    }
}
