<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Options;

/**
 * WebinoDebug module options
 */
class ModuleOptions extends DebuggerOptions
{
    /**
     * @var array|null
     */
    protected $templateMap;

    /**
     * @var string|null
     */
    protected $phpErrorLog;

    /**
     * Return view template map
     *
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
     * Configure view templates
     *
     * @param array|null $templateMap Empty array to disable, null for default
     * @return $this
     */
    public function setTemplateMap(array $templateMap = null)
    {
        $this->templateMap = $templateMap;
        return $this;
    }

    /**
     * Return PHP error log file path
     *
     * @return string
     */
    public function getPhpErrorLog()
    {
        $this->phpErrorLog or $this->phpErrorLog = parent::getLog() . '/php.log';
        return $this->phpErrorLog;
    }

    /**
     * Set PHP error log file path
     *
     * @param string|null $phpErrorLog
     * @return $this
     */
    public function setPhpErrorLog(string $phpErrorLog = null)
    {
        $this->phpErrorLog = $phpErrorLog;
        return $this;
    }
}
