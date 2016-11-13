<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2015 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Tracy\Workaround;

/**
 * Disabled tracy debug bar
 *
 * @todo issue https://github.com/nette/tracy/issues/73
 */
class DisabledBar
{
    /**
     * @var array
     */
    public $info = [];

    /**
     *
     */
    public function addPanel()
    {
    }

    /**
     *
     */
    public function getPanel()
    {
    }

    /**
     *
     */
    public function render()
    {
    }

    public function dispatchAssets()
    {
    }
}
