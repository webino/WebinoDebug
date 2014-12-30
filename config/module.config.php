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
 * Do not write your custom settings into this file
 */
return [
    'service_manager' => [
        'factories' => [
            'WebinoDebug\Options\ModuleOptions' => 'WebinoDebug\Factory\ModuleOptionsFactory',
        ],
    ],
];