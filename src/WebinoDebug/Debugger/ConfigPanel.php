<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Debugger;

use WebinoDebug\Exception;
use WebinoDebug\Factory\DebuggerFactory;
use WebinoDebug\Service\DebuggerAwareInterface;
use WebinoDebug\Service\DebuggerAwareTrait;
use Zend\Config\Config;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ConfigPanel
 */
class ConfigPanel extends AbstractPanel implements
    PanelInterface,
    PanelInitInterface,
    DebuggerAwareInterface
{
    use DebuggerAwareTrait;

    /**
     * @var array|Config
     */
    private $config;

    /**
     * @var string
     */
    protected $title = 'Application config';

    /**
     * @param ServiceManager $services
     */
    public function init(ServiceManager $services)
    {
        $this->config = array_merge(['core' => $services->get('ApplicationConfig')], $services->get('Config'));
        $this->setDebugger($services->get(DebuggerFactory::SERVICE));
    }

    /**
     * @return array
     * @throws Exception\LogicException
     */
    protected function getConfig()
    {
        if (null === $this->config) {
            throw new Exception\LogicException('Expected `config`');
        }
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function getTab()
    {
        return $this->createIcon('config', 'top: -3px;');
    }

    /**
     * {@inheritdoc}
     */
    public function getPanel()
    {
        return $this->renderTemplate('config.panel');
    }
}
