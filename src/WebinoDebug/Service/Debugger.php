<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2017 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Service;

use Tracy\Debugger as Tracy;
use WebinoDebug\Debugger\Bar\PanelInterface;
use WebinoDebug\Options\DebuggerOptions;

/**
 * Class Debugger
 */
class Debugger implements DebuggerInterface
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

        Tracy::enable(
            $_options->getMode(),
            $_options->getLog(),
            $_options->getEmail()
        );

        Tracy::$strictMode = $_options->isStrict();
        Tracy::$showBar    = $_options->showBar();
        Tracy::$maxDepth   = $_options->getMaxDepth();
        Tracy::$maxLength  = $_options->getMaxLength();
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
     * @param $id
     * @return PanelInterface|null
     */
    public function getBarPanel($id)
    {
        return Tracy::getBar()->getPanel($id);
    }

    /**
     * @param object|PanelInterface|null $panel
     * @param string $id
     * @return self
     */
    public function setBarPanel(PanelInterface $panel = null, $id = null)
    {
        $panel and Tracy::getBar()->addPanel($this->barPanels[$id] = $panel, $id);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function dump($subject)
    {
        return Tracy::dump($subject);
    }

    /**
     * {@inheritdoc}
     */
    public function dumpStr($subject)
    {
        return Tracy::dump($subject, true);
    }

    /**
     * {@inheritdoc}
     */
    public function barDump($subject, $title = null, array $options = null)
    {
        Tracy::barDump($subject, $title, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function timer($name = null)
    {
        return Tracy::timer($name);
    }
}
