<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Service;

use WebinoDebug\Debugger\Bar\PanelInterface;
use WebinoDebug\Debugger\DebuggerBarInterface;
use WebinoDebug\Debugger\DebuggerInterface;

/**
 * Class NullDebugger
 */
class NullDebugger implements
    DebuggerInterface,
    DebuggerBarInterface
{
    /**
     * @var object
     */
    private $dummy;

    /**
     * {@inheritdoc}
     */
    public function dump($subject)
    {
        $this->dummy or $this->initDummy();
        return $this->dummy;
    }

    /**
     * {@inheritdoc}
     */
    public function timer($name = null)
    {
        $this->dummy or $this->initDummy();
        return $this->dummy;
    }

    /**
     * {@inheritdoc}
     */
    public function setBarPanel(PanelInterface $panel = null, $id = null)
    {
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function setBarInfo(string $label, $value)
    {
        return;
    }

    /**
     * Initialize dummy object
     */
    private function initDummy()
    {
        $this->dummy = new class {
            public function __call($name, $arguments)
            {
                return null;
            }
        };
    }

    /**
     * {@inheritdoc}
     * @deprecated use dump() instead, now it returns stringable object
     */
    public function dumpStr($subject)
    {
        return '';
    }

    /**
     * {@inheritdoc}
     * @deprecated use dump() instead, now it returns object
     */
    public function barDump($subject, $title = null, array $options = null)
    {
        return;
    }
}
