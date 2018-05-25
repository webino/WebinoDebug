<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Debugger;

use Zend\ServiceManager\ServiceManager;

/**
 * Interface PanelInterface
 */
interface PanelInitInterface
{
    /**
     * Initialize debugger panel dependencies
     *
     * @param ServiceManager $services
     * @return void
     */
    public function init(ServiceManager $services);
}
