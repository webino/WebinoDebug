<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2015 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

use Tester\Assert;
use Zend\Mvc\Application;
use Zend\ServiceManager\ServiceManager;

require __DIR__ . '/../bootstrap.php';


$app = createApp();


Assert::type(Application::class, $app);
Assert::type(ServiceManager::class, $app->getServiceManager());
