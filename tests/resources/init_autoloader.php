<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Test;

use RuntimeException;

/**
 * Initialize vendor autoloader
 */
$loader = @include __DIR__ . '/../../vendor/autoload.php';
if (empty($loader)) {
    throw new RuntimeException('Unable to load. Run `php composer.phar install`.');
}

$loader->add('Application', __DIR__ . '/src');
$loader->add('WebinoDebug', __DIR__ . '/src');
$loader->add('WebinoDebug', __DIR__ . '/../../src');
$loader->add('WebinoDebug', __DIR__ . '/..');
