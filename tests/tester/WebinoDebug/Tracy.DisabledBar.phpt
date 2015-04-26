<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2015 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

use Tester\Assert;
use WebinoDebug\Tracy\Workaround\DisabledBar;

require __DIR__ . '/../bootstrap.php';


$bar = new DisabledBar;


Assert::true(method_exists($bar, 'addPanel'));
Assert::true(method_exists($bar, 'getPanel'));
Assert::true(method_exists($bar, 'render'));
