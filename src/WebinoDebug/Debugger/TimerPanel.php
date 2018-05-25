<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Debugger;

/**
 * Class TimerPanel
 */
class TimerPanel extends AbstractPanel implements PanelInterface
{
    /**
     * @var string
     */
    protected $title = 'Timer';

    /**
     * @var array
     */
    protected $timers = [];

    /**
     * Set timer value
     *
     * @param string $name Timer name
     * @param float $value value
     * @return $this
     */
    public function setTimer(string $name, $value)
    {
        $this->timers[$name] = (string) $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTab()
    {
        return $this->timers ? $this->createIcon('timer') : '';
    }

    /**
     * {@inheritdoc}
     */
    public function getPanel()
    {
        return $this->timers ? $this->renderTemplate('timer.panel') : '';
    }
}
