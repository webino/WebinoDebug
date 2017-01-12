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
 * Testing application config
 */
return [
    'modules' => [
        'WebinoDev',
        __NAMESPACE__,
        'Application',
    ],
    'webino_debug' => [
        // Development mode
        'mode' => false,
        'bar'  => true,
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php',
        ],
        'module_paths' => [
            'module',
            'vendor',
        ],
    ],
];
