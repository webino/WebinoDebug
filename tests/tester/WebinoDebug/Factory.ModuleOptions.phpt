<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2015 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

use Tester\Assert;
use WebinoDebug\Factory\ModuleOptionsFactory;
use WebinoDebug\Options\ModuleOptions;
use Zend\ServiceManager\ServiceManager;

require __DIR__ . '/../bootstrap.php';
$test = createTestCase();


$config = ['webino_debug' => []];
$services = $test->getMock(ServiceManager::class);

$services->expects($test->once())
    ->method('get')
    ->with('ApplicationConfig')
    ->will($test->returnValue($config));


$factory = new ModuleOptionsFactory;
/** @var ServiceManager $services */
$options = $factory->createService($services);


Assert::type(ModuleOptions::class, $options);
