<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Debugger;

use Tracy\Debugger as Tracy;
use WebinoDebug\Debugger\Bar\TimerPanel;

/**
 * Class DebuggerTimer
 */
class DebuggerTimer
{
    /**
     * @var TimerPanel
     */
    protected $panel;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $delta;

    /**
     * @param TimerPanel $panel Debugger timer imer panel
     * @param string|null $name Timer name
     */
    public function __construct(TimerPanel $panel, string $name = null)
    {
        $this->panel = $panel;
        $this->name  = $name ?: md5(uniqid(rand()));
    }

    /**
     * Return delta time
     *
     * @return float
     */
    public function getDelta() : float
    {
        return $this->delta;
    }

    /**
     * Set timer name
     *
     * Do not overrides.
     *
     * @param string|null $name
     * @return $this
     */
    public function setName(string $name = null)
    {
        $name and $this->name = $name;
        return $this;
    }

    /**
     * Start the timer
     *
     * @return $this
     */
    public function start()
    {
        $this->delta = Tracy::timer($this->name);
        return $this;
    }

    /**
     * Stop the timer
     *
     * @param string $title Debugger bar timer value title
     * @return float Delta time
     */
    public function stop(string $title = null) : float
    {
        $this->delta = Tracy::timer($this->name);
        $title and $this->panel->setTimer($title, $this->delta);
        return $this->delta;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->stop();
    }
}
