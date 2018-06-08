<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Debugger;

use Zend\ServiceManager\ServiceManager;

/**
 * Class ServicesPanel
 */
class ServicesPanel extends AbstractPanel implements
    PanelInterface,
    PanelInitInterface
{
    /**
     * @var ServiceManager
     */
    private $services;

    /**
     * @var string
     */
    protected $title = 'Service container';

    /**
     * @param ServiceManager $services
     */
    public function init(ServiceManager $services)
    {
        $this->services = $services;
    }

    /**
     * @return ServiceManager
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * {@inheritdoc}
     */
    public function getTab()
    {
        return $this->createIcon('services');
    }

    /**
     * {@inheritdoc}
     */
    public function getPanel()
    {
        return $this->renderTemplate('services.panel');
    }
}
