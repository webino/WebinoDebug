<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * WebinoDebug module options
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * @var bool
     */
    protected $enabled = true;

    /**
     * @var bool|null
     */
    protected $mode = null;

    /**
     * @var bool
     */
    protected $bar = false;

    /**
     * @var bool
     */
    protected $strict = true;

    /**
     * @var string|null
     */
    protected $log;

    /**
     * @var string
     */
    protected $email = '';

    /**
     * @var int
     */
    protected $maxDepth = 3;

    /**
     * @var int
     */
    protected $maxLen = 150;

    /**
     * @var array|null
     */
    protected $templateMap;

    /**
     * Is debugger enabled?
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Debugger mode
     *
     * true  = production|false
     * false = development|null
     * null  = autodetect|IP address(es) csv/array
     *
     * @return bool|null
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Is debugger bar enabled?
     *
     * @return bool
     */
    public function hasBar()
    {
        return $this->bar;
    }

    /**
     * @return bool
     */
    public function isStrict()
    {
        return $this->strict;
    }

    /**
     * @return string Empty string to disable, null for default
     */
    public function getLog()
    {
        if (null === $this->log) {
            $this->setLog('data/log');
        }
        return $this->log;
    }

    /**
     * Administrator address
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getMaxDepth()
    {
        return $this->maxDepth;
    }

    /**
     * @return int
     */
    public function getMaxLen()
    {
        return $this->maxLen;
    }

    /**
     * @return array
     */
    public function getTemplateMap()
    {
        if (null === $this->templateMap) {
            $this->setTemplateMap(['error/index' => __DIR__ . '/../../../view/error/index.phtml']);
        }
        return $this->templateMap;
    }

    /**
     * Enable debugger
     *
     * @param bool $enabled
     * @return self
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (bool) $enabled;
        return $this;
    }

    /**
     * Debugger mode, production or development.
     *
     * @param bool|null $mode
     * @return self
     */
    public function setMode($mode)
    {
        $this->mode = (null === $mode ? null : (bool) $mode);
        return $this;
    }

    /**
     * @param bool $bar
     * @return self
     */
    public function setBar($bar)
    {
        $this->bar = (bool) $bar;
        return $this;
    }

    /**
     * Strict errors?
     *
     * @param bool $strict
     * @return self
     */
    public function setStrict($strict)
    {
        $this->strict = (bool) $strict;
        return $this;
    }

    /**
     * Path to log directory
     *
     * @param string $log
     * @return self
     */
    public function setLog($log)
    {
        $this->log = realpath($log);
        return $this;
    }

    /**
     * Configure debugger administrator email
     *
     * @param string $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = (string) $email;
        return $this;
    }

    /**
     * Variable dump max depth
     *
     * @param int $maxDepth
     * @return self
     */
    public function setMaxDepth($maxDepth)
    {
        $this->maxDepth = (int) $maxDepth;
        return $this;
    }

    /**
     * Maximum length of a variable
     *
     * @param int $maxLen
     * @return self
     */
    public function setMaxLen($maxLen)
    {
        $this->maxLen = (int) $maxLen;
        return $this;
    }

    /**
     * Configure view templates
     *
     * @param array|null $templateMap Empty array to disable, null for default
     * @return self
     */
    public function setTemplateMap(array $templateMap = null)
    {
        $this->templateMap = $templateMap;
        return $this;
    }
}
