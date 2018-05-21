<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Debugger\Bar;

use WebinoDebug\Factory\DebuggerFactory;
use WebinoDebug\Options\ModuleOptions;
use Zend\ServiceManager\ServiceManager;

/**
 * Class InfoPanel
 */
class InfoPanel extends AbstractPanel implements
    PanelInterface,
    PanelInitInterface
{
    /**
     * @var string|null
     */
    protected $barTitle;

    /**
     * {@inheritdoc}
     */
    public function init(ServiceManager $services)
    {
        /** @var \WebinoDebug\Options\ModuleOptions $options */
        $options = $services->get(ModuleOptions::class);
        /** @var \WebinoDebug\Service\Debugger $debugger */
        $debugger = $services->get(DebuggerFactory::SERVICE);

        // set bar title
        $this->barTitle = $options->getBarTitle();

        // set bar info
        foreach ($options->getBarInfo() as $name => $value) {
            $debugger->setBarInfo($name, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTab()
    {
        return '<span id="webino-debug-bar-meta" data-bar-title="' . $this->barTitle . '"></span>';
    }

    /**
     * {@inheritdoc}
     */
    public function getPanel()
    {
        return ' ';
    }
}
