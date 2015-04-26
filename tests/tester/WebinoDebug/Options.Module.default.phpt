<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2015 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

use Tester\Assert;
use WebinoDebug\Options\DebuggerOptions;
use WebinoDebug\Options\ModuleOptions;

require __DIR__ . '/../bootstrap.php';


$options = new ModuleOptions;


Assert::type(DebuggerOptions::class, $options);
Assert::true(is_file($options->getTemplateMap()['error/index']));
