<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2017 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

use Tester\Assert;
use WebinoDebug\Options\DebuggerOptions;

require __DIR__ . '/../bootstrap.php';


$cfg = [
    'enabled'  => false,
    'mode'     => true,
    'bar'      => true,
    'strict'   => false,
    'log'      => 'tmp/log',
    'email'    => 'test@example.com',
    'maxDepth' => 7,
    'maxLen'   => 170,
];


$options = new DebuggerOptions($cfg);


Assert::false($options->isEnabled());
Assert::true($options->getMode());
Assert::true($options->hasBar());
Assert::false($options->isStrict());
Assert::same(realpath($cfg['log']), $options->getLog());
Assert::same($cfg['email'], $options->getEmail());
Assert::same($cfg['maxDepth'], $options->getMaxDepth());
Assert::same($cfg['maxLen'], $options->getMaxLen());
