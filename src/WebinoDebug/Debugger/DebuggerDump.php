<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Debugger;

use Tracy\Debugger as Tracy;
use Tracy\Dumper as Dumper;

/**
 * Class DebuggerDump
 */
class DebuggerDump
{
    /**
     * @var mixed Variable to dump
     */
    protected $var;

    /**
     * Dump variable to debugger bar
     *
     * @var bool
     */
    protected $toBar = false;

    /**
     * Return dump as string
     *
     * @var bool
     */
    protected $return = false;

    /**
     * Collapse structure with length above defined
     *
     * @var int
     */
    protected $collapse = 1;

    /**
     * Maximum structure depth
     *
     * @var int
     */
    protected $maxDepth;

    /**
     * Maximum data length
     *
     * @var int
     */
    protected $maxLength;

    /**
     * @param mixed $var Variable to dump
     */
    public function __construct($var)
    {
        $this->var = $var;
    }

    /**
     * Return as string
     *
     * @param bool $return
     * @return $this
     */
    public function setReturn($return = true)
    {
        $this->return = (bool) $return;
        return $this;
    }

    /**
     * @param int $collapse
     * @return $this
     */
    public function setCollapse(int $collapse = 1)
    {
        $this->collapse = $collapse;
        return $this;
    }

    /**
     * @param int $maxDepth
     * @return $this
     */
    public function setMaxDepth(int $maxDepth)
    {
        $this->maxDepth = $maxDepth;
        return $this;
    }

    /**
     * @param int $maxLength
     * @return $this
     */
    public function setMaxLength(int $maxLength)
    {
        $this->maxLength = $maxLength;
        return $this;
    }

    protected function getOptions()
    {
        return [
            Dumper::DEPTH    => $this->maxDepth ?: Tracy::$maxDepth,
            Dumper::TRUNCATE => $this->maxLength ?: Tracy::$maxLength,
            Dumper::COLLAPSE => $this->collapse,
        ];
    }

    /**
     * Return or output a variable dump
     *
     * @return string|null
     */
    public function dump() : ?string
    {
        if ($this->return) {
            return $this->dumpReturn();

        } elseif (!Dumper::$productionMode) {
            Dumper::dump($this->var, $this->getOptions() + [
                Dumper::LOCATION => Tracy::$showLocation,
            ]);
        }

        return null;
    }

    /**
     * Dump to debugger bar
     *
     * @param string|null $title Dump title
     * @return $this
     */
    public function bar(string $title = null)
    {
        Tracy::barDump($this->var, $title, $this->getOptions());
        return $this;
    }

    /**
     * Dump to PHP error log
     *
     * @return $this
     */
    public function log()
    {
        error_log(print_r($this->var, true));
        return $this;
    }

    /**
     * @return string
     */
    protected function dumpReturn()
    {
        ob_start();
        Dumper::dump($this->var, $this->getOptions());
        return ob_get_clean();
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return (string) $this->dumpReturn();
    }
}
