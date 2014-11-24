<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug;

use Tracy\Debugger;
use Zend\ModuleManager\Feature;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManagerInterface;

/**
 * WebinoDebug module
 */
class Module implements
    Feature\InitProviderInterface,
    Feature\ConfigProviderInterface
{
    /**
     * @param ModuleManagerInterface $modules
     */
    public function init(ModuleManagerInterface $modules)
    {
        $modules->getEventManager()->attach(
            ModuleEvent::EVENT_LOAD_MODULES_POST,
            function (ModuleEvent $event) {

                /* @var $services Zend\ServiceManager\ServiceManager */
                $services = $event->getParam('ServiceManager');
                /* @var $modules WebinoDebug\Options\ModuleOptions */
                $options  = $services->get('WebinoDebug\Options\ModuleOptions');

                if (!$options->isEnabled()) {
                    return;
                }

                // TODO issue https://github.com/nette/tracy/issues/73
                if (!$options->hasBar() && !class_exists('Tracy\Bar', false)) {
                    class_alias('WebinoDebug\Tracy\Workaround\DisabledBar', 'Tracy\Bar');
                }

                Debugger::enable(
                    $options->getMode(),
                    $options->getLog(),
                    $options->getEmail()
                );

                Debugger::$strictMode = $options->isStrict();
                Debugger::$maxDepth = $options->getMaxDepth();
                Debugger::$maxLen = $options->getMaxLen();

                $templateMap = $options->getTemplateMap();
                empty($templateMap) or $services->get('ViewTemplateMapResolver')->merge($templateMap);
            }
        );
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return require __DIR__ . '/../../config/module.config.php';
    }
}
