<?php

namespace WebinoDebug\Debugger\Bar;

use WebinoDebug\Service\DebuggerInterface;
use Zend\Config\Config;
use Zend\Stdlib\ArrayUtils;

/**
 * Class ConfigPanel
 */
class ConfigPanel implements PanelInterface
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
    private $label = 'Config';

    /**
     * @var string
     */
    private $title = 'Application config';

    /**
     * @param array|Config $config
     * @param object|DebuggerInterface $debugger
     */
    public function __construct($config, DebuggerInterface $debugger)
    {
        $this->config   = $config;
        $this->debugger = $debugger;
    }

    /**
     * {@inheritdoc}
     */
    public function getTab()
    {
        $icon = base64_decode('PHN2ZyB2aWV3Qm94PSIwIDAgMjA0OCAyMDQ4Ij4NCjxwYXRoIGZpbGw9IiMxN
        TRBQkQiIGQ9Im0xMDg0IDU0MGMtMTEwLTEtMjI4LTItMzI1IDU4LTU0IDM1LTg3IDk0LTEyNiAxNDMtOTQgM
        TYyLTcxIDM4MyA1OSA1MTkgODMgOTQgMjA3IDE1MSAzMzMgMTQ5IDEzMiAzIDI2MS02MCAzNDQtMTYwIDEyM
        i0xMzggMTM5LTM1NSA0NC01MTEtNzMtNjYtMTMzLTE1OC0yMzQtMTgzLTMxLTktNjUtOS05NS0xNHptLTYwI
        DExNmM3MyAwIDUzIDExNS0xNiA5Ny0xMDUgNS0xOTUgMTAyLTE5MiAyMDctMiA3OC0xMjIgNDgtOTUtMjMgO
        C0xNTMgMTUxLTI4NSAzMDQtMjgwbC0xLTF6TTEwMjEgNTExIi8+DQo8cGF0aCBmaWxsPSIjNEI2MTkzIiBkP
        SJtMTAyMSA1MTFjLTI4NC0yLTU2MCAxMzEtNzQ2IDM0NC01MyA2NC0xMTggMTI1LTE0NSAyMDYtMTYgODYgN
        TkgMTUyIDEwMyAyMTcgMjE5IDI2NyA1NzUgNDI4IDkyMSAzNzcgMzEyLTQ0IDYwMC0yNDEgNzU1LTUxNSAzO
        S04MS0zMC0xNTYtNzQtMjE3LTE0NS0xODctMzU1LTMyNy01ODEtMzg0LTc3LTE5LTE1Ni0yOS0yMzQtMjh6b
        TAgMTI4YzI2My00IDUxMiAxMzIgNjc5IDMzMCAzMyA1MiAxMzIgMTEwIDU4IDE2OC0xNzAgMjM3LTQ0OSA0M
        DktNzQ3IDM5OS0zMDkgMC01OTAtMTkzLTc1Mi00NDcgMTIxLTE5MiAzMDUtMzQ2IDUyNi00MDcgNzUtMjUgM
        TcwLTM4IDIzNy00M3oiLz4NCjwvc3ZnPg==');

        $tab = sprintf('<span title="%s" class="tracy-label">%s</span>', $this->title, $this->label);
        return $icon . $tab;
    }

    /**
     * {@inheritdoc}
     */
    public function getPanel()
    {
        $content = $this->debugger->dumpStr(ArrayUtils::iteratorToArray($this->config));
        $style   = '<style> #tracy-debug pre.tracy-dump {overflow: visible; } </style>';

        return $style . sprintf(
            '<div class="tracy-inner" style="%s"><h1>%s</h1><div>%s</div></div>',
            'max-width: 100%%;',
            $this->title,
            $content
        );
    }
}
