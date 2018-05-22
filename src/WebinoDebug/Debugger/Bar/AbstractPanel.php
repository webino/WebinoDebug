<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Debugger\Bar;

use Zend\Escaper\EscaperAwareTrait;

/**
 * Class AbstractPanel
 */
abstract class AbstractPanel
{
    use EscaperAwareTrait;

    /**
     * @var string
     */
    protected $label = '';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $dir = __DIR__;

    /**
     * {@inheritdoc}
     */
    public function getTab()
    {
        if (!$this->label) {
            return '';
        }
        return sprintf('<span title="%s" class="tracy-label">%s</span>', $this->title, $this->label);
    }

    /**
     * {@inheritdoc}
     */
    public function createIcon($name, $style = '')
    {
        $data = file_get_contents($this->dir . '/../../../../data/assets/Debugger/' . $name . '.png');
        $base64 = 'data:image/png;base64,' . base64_encode($data);
        return '<img src="' . $base64 . '" style="' . $style . '" title="'. $this->title .'"/>';
    }

    /**
     * @param $name
     * @return string
     */
    public function renderTemplate($name)
    {
        ob_start();
        /** @noinspection PhpIncludeInspection */
        require $this->dir . '/../../../../data/assets/Debugger/' . $name . '.phtml';
        return ob_get_clean();
    }
}
