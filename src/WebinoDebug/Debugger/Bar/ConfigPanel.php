<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2017 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Debugger\Bar;

use WebinoDebug\Exception;
use WebinoDebug\Factory\DebuggerFactory;
use WebinoDebug\Service\DebuggerInterface;
use Zend\Config\Config;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;

/**
 * Class ConfigPanel
 */
class ConfigPanel extends AbstractPanel implements
    PanelInterface,
    PanelInitInterface
{
    /**
     * @var array|Config
     */
    private $config;

    /**
     * @var DebuggerInterface
     */
    private $debugger;

    /**
     * @var string
     */
    protected $label = 'Config';

    /**
     * @var string
     */
    protected $title = 'Application config';

    /**
     * @var string
     */
    protected $content = '';

    /**
     * @param ServiceManager $services
     */
    public function init(ServiceManager $services)
    {
        $this->setConfig(array_merge(['core' => $services->get('ApplicationConfig')], $services->get('Config')));
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
     * @param array $config
     * @return self
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return DebuggerInterface
     * @throws Exception\LogicException
     */
    protected function getDebugger()
    {
        if (null === $this->debugger) {
            throw new Exception\LogicException('Expected `debugger`');
        }
        return $this->debugger;
    }

    /**
     * @param object|DebuggerInterface $debugger
     * @return self
     */
    public function setDebugger(DebuggerInterface $debugger)
    {
        $this->debugger = $debugger;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTab()
    {
        return $this->createIcon('config', 'top: -3px;') . parent::getTab();
    }

    /**
     * {@inheritdoc}
     */
    public function getPanel()
    {
        $this->content = $this->getDebugger()->dumpStr(ArrayUtils::iteratorToArray($this->getConfig()));
        return $this->renderTemplate('config');
    }
}
