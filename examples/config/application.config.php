<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2017 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug;

/**
 * Copy following settings into your configuration file
 */
return [
    'webino_debug' => [
        'enabled'      => true,
        'mode'         => null,     // true = production|false = development|null = autodetect|IP address(es) csv/array
        'bar'          => false,    // bool = enabled|Toggle nette diagnostics bar
        'bar_panels'   => [],       // \WebinoDebug\Debugger\Bar\PanelInterface[]|Debugger bar panels
        'strict'       => true,     // bool = cause immediate death|int = matched against error severity
        'log'          => '',       // bool = enabled|Path to directory eg. data/logs
        'email'        => '',       // in production mode notifies the recipient
        'max_depth'    => 3,        // nested levels of array/object
        'max_len'      => 150,      // max string display length
        'template_map' => [],       // merge templates if enabled
    ],
];
