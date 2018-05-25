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
 * Interface DebuggerBarInterface
 */
interface DebuggerBarInterface
{
    /**
     * Set new debugger bar panel
     *
     * @param object|PanelInterface|null $panel Panel object
     * @param string $id Panel id
     * @return $this
     */
    public function setBarPanel(PanelInterface $panel = null, $id = null);

    /**
     * Set debugger bar info
     *
     * @param string $label Info label
     * @param string|int $value Info value
     * @return $this
     */
    public function setBarInfo(string $label, $value);
}
