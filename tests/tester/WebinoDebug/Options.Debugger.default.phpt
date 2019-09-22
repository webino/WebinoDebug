<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

use Tester\Assert;
use WebinoDebug\Options\DebuggerOptions;

require __DIR__ . '/../bootstrap.php';


$options = new DebuggerOptions;

Assert::true($options->isEnabled());
Assert::null($options->getMode());
Assert::false($options->hasBar());
Assert::same(7167, $options->getStrict());
Assert::same(realpath('data/log'), $options->getLog());
Assert::same('', $options->getEmail());
Assert::same(10, $options->getMaxDepth());
Assert::same(300, $options->getMaxLength());
Assert::false($options->hasFireLogger());
