#!/usr/bin/env php
<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug;

use WebinoDev\Di\Definition\Generator;

// Autoloader
$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add(__NAMESPACE__, __DIR__ . '/../src');
$loader->add(__NAMESPACE__, __DIR__ . '/../tests/resources/src');
$loader->add('Application', __DIR__ . '/../tests/resources/src');

// Dump DI definition
(new Generator(__DIR__))->compile()->dump();
