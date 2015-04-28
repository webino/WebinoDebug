<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2015 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Service;

use Tracy\Bar;
use Tracy\Debugger as Tracy;
use WebinoDebug\Debugger\Bar\PanelInterface;
use WebinoDebug\Options\DebuggerOptions;
use WebinoDebug\Tracy\Workaround\DisabledBar;

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

        // TODO issue https://github.com/nette/tracy/issues/73
        if (!$options->hasBar() && !class_exists(Bar::class, false)) {
            class_alias(DisabledBar::class, Bar::class);
        }

        Tracy::enable(
            $_options->getMode(),
            $_options->getLog(),
            $_options->getEmail()
        );

        Tracy::$strictMode = $_options->isStrict();
        Tracy::$maxDepth   = $_options->getMaxDepth();
        Tracy::$maxLen     = $_options->getMaxLen();
    }

    /**
     * @return DebuggerOptions
     */
    public function getOptions()
    {
        return $this->options;
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
        $panel and Tracy::getBar()->addPanel($panel, $id);
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
