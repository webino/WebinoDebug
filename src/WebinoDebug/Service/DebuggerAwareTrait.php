<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Service;

use WebinoDebug\Debugger\DebuggerInterface;

/**
 * Trait DebuggerAwareTrait
 */
trait DebuggerAwareTrait
{
    /**
     * @var DebuggerInterface
     */
    protected $debugger;

    /**
     * Return debugger
     *
     * @return DebuggerInterface
     */
    public function getDebugger() : DebuggerInterface
    {
        return $this->debugger;
    }

    /**
     * Set debugger
     *
     * @param DebuggerInterface $debugger
     * @return void
     */
    public function setDebugger(DebuggerInterface $debugger)
    {
        $this->debugger = $debugger;
    }
}
