<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Options;

use WebinoDebug\Debugger;
use Zend\Stdlib\AbstractOptions;
use Zend\Stdlib\ArrayUtils;

/**
 * Class DebuggerOptions
 */
class DebuggerOptions extends AbstractOptions
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
     * @var string
     */
    protected $barTitle;

    /**
     * @var array
     */
    protected $barInfo = [];

    /**
     * @var array
     */
    protected $barPanels = [
        'WebinoDebug:info'     => Debugger\InfoPanel::class,
        'WebinoDebug:timer'    => Debugger\TimerPanel::class,
        'WebinoDebug:config'   => Debugger\ConfigPanel::class,
        'WebinoDebug:services' => Debugger\ServicesPanel::class,
        'WebinoDebug:events'   => Debugger\EventPanel::class,
    ];

    /**
     * @var array
     */
    protected $cssFiles = [__DIR__ . '/../../../data/assets/Debugger/style.css'];

    /**
     * @var array
     */
    protected $jsFiles = [__DIR__ . '/../../../data/assets/Debugger/script.js'];

    /**
     * @var int
     */
    protected $strict = E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_USER_NOTICE;

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
    protected $maxDepth = 10;

    /**
     * @var int
     */
    protected $maxLength = 300;

    /**
     * @var bool
     */
    protected $barNoLogo = false;

    /**
     * @var bool
     */
    protected $barNoClose = false;

    /**
     * @var bool
     */
    protected $fireLogger = false;

    /**
     * Is debugger enabled?
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Enable debugger
     *
     * @param bool $enabled
     * @return $this
     */
    public function setEnabled($enabled = true)
    {
        $this->enabled = (bool) $enabled;
        return $this;
    }

    /**
     * Is debugger disabled?
     *
     * @return bool
     */
    public function isDisabled(): bool
    {
        return !$this->enabled;
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
    public function getMode(): ?bool
    {
        return $this->mode;
    }

    /**
     * Debugger mode, production or development.
     *
     * @param bool|null $mode
     * @return $this
     */
    public function setMode($mode)
    {
        $this->mode = (null === $mode ? null : (bool) $mode);
        return $this;
    }

    /**
     * Is debugger bar enabled?
     *
     * @return bool
     */
    public function hasBar(): bool
    {
        return $this->bar;
    }

    /**
     * Toggle debugger bar
     *
     * @param bool $bar
     * @return $this
     */
    public function setBar($bar)
    {
        $this->bar = (bool) $bar;
        return $this;
    }

    /**
     * Debugger bar panels
     *
     * @return array
     */
    public function getBarPanels(): array
    {
        return $this->barPanels;
    }

    /**
     * Set custom debugger bar panels
     *
     * @param array $barPanels
     * @return $this
     */
    public function setBarPanels(array $barPanels)
    {
        $this->barPanels = ArrayUtils::merge($this->barPanels, $barPanels);
        return $this;
    }

    /**
     * @return array
     */
    public function getCssFiles(): array
    {
        return $this->cssFiles;
    }

    /**
     * Set custom CSS files
     *
     * @param array $cssFiles
     * @return $this
     */
    public function setCssFiles(array $cssFiles)
    {
        $this->cssFiles = ArrayUtils::merge($this->cssFiles, $cssFiles);
        return $this;
    }

    /**
     * @return array
     */
    public function getJsFiles(): array
    {
        return $this->jsFiles;
    }

    /**
     * Set custom Javascript files
     *
     * @param array $jsFiles
     * @return $this
     */
    public function setJsFiles(array $jsFiles)
    {
        $this->jsFiles = ArrayUtils::merge($this->jsFiles, $jsFiles);
        return $this;
    }

    /**
     * Return custom debugger bar info
     *
     * @return array
     */
    public function getBarInfo(): array
    {
        return $this->barInfo;
    }

    /**
     * Set custom debugger bar info
     *
     * @param array $barInfo
     * @return $this
     */
    public function setBarInfo(array $barInfo)
    {
        $this->barInfo = ArrayUtils::merge($this->barInfo, $barInfo);
        return $this;
    }

    /**
     * Error reporting level
     *
     * @return int
     */
    public function getStrict(): int
    {
        return $this->strict;
    }

    /**
     * Set error reporting level
     *
     * @param int $strict
     * @return $this
     */
    public function setStrict($strict)
    {
        $this->strict = (int) $strict;
        return $this;
    }

    /**
     * @return string Empty string to disable, null for default
     */
    public function getLog(): string
    {
        if (null === $this->log) {
            $this->setLog('data/log');
        }
        return $this->log;
    }

    /**
     * Path to log directory
     *
     * @param string $log
     * @return $this
     */
    public function setLog($log)
    {
        $this->log = realpath($log);
        return $this;
    }

    /**
     * Administrator address
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Configure debugger administrator email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = (string) $email;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxDepth(): int
    {
        return $this->maxDepth;
    }

    /**
     * Variable dump max depth
     *
     * @param int $maxDepth
     * @return $this
     */
    public function setMaxDepth($maxDepth)
    {
        $this->maxDepth = (int) $maxDepth;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxLength(): int
    {
        return $this->maxLength;
    }

    /**
     * Maximum length of a variable
     *
     * @param int $maxLength
     * @return $this
     */
    public function setMaxLength($maxLength)
    {
        $this->maxLength = (int) $maxLength;
        return $this;
    }

    /**
     * Return debugger bar title
     *
     * @return string
     */
    public function getBarTitle(): string
    {
        return $this->barTitle;
    }

    /**
     * Set debugger bar custom title
     *
     * @param string $barTitle
     * @return $this
     */
    public function setBarTitle($barTitle)
    {
        $this->barTitle = (string) $barTitle;
        return $this;
    }

    /**
     * Has debugger bar a disabled logo?
     *
     * @return bool
     */
    public function hasBarNoLogo(): bool
    {
        return $this->barNoLogo;
    }

    /**
     * Set debugger bar logo disabled
     *
     * @param bool $barNoLogo
     * @return $this
     */
    public function setBarNoLogo($barNoLogo = true)
    {
        $this->barNoLogo = (bool) $barNoLogo;
        return $this;
    }

    /**
     * Has debugger bar close button disabled?
     *
     * @return bool
     */
    public function hasBarNoClose(): bool
    {
        return $this->barNoClose;
    }

    /**
     * Disable debugger bar close button
     *
     * @param bool $barNoClose
     * @return $this
     */
    public function setBarNoClose($barNoClose = true)
    {
        $this->barNoClose = (bool) $barNoClose;
        return $this;
    }

    /**
     * Is fire logger enabled?
     *
     * @return bool
     */
    public function hasFireLogger(): bool
    {
        return $this->fireLogger;
    }

    /**
     * Use fire logger
     *
     * @param bool $fireLogger
     * @return $this
     */
    public function setFireLogger($fireLogger = true)
    {
        $this->fireLogger = (bool) $fireLogger;
        return $this;
    }
}
