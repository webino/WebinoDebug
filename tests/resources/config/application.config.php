<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug;

/**
 * Testing application config
 */
return [
    'modules' => [
        'WebinoDev',
        'Application',
        'WebinoDebug',
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php',
        ],
        'config_static_paths' => [
            __DIR__ . '/module.config.php',
        ],
        'module_paths' => [
            'module',
            'vendor',
        ],
    ],
];
