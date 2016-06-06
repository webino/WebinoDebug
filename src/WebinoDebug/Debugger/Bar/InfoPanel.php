<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2016 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Debugger\Bar;

use WebinoDebug\Exception;
use WebinoDebug\Factory\DebuggerFactory;
use Zend\ServiceManager\ServiceManager;
use Zend\Version\Version;

/**
 * Class InfoPanel
 */
class InfoPanel extends AbstractPanel implements
    PanelInterface,
    PanelInitInterface
{
    /**
     * {@inheritdoc}
     */
    public function init(ServiceManager $services)
    {
        $info = [];

        class_exists(Version::class)
            and $info['Zend Framework'] = Version::VERSION;

        /** @var \WebinoDebug\Service\Debugger $debugger */
        $debugger = $services->get(DebuggerFactory::SERVICE);
        /** @var \Tracy\DefaultBarPanel $panel */
        $panel = $debugger->getBarPanel('Tracy:info');
        $panel->data = $info;
    }

    /**
     * {@inheritdoc}
     */
    public function getTab()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getPanel()
    {
        return '';
    }
}
