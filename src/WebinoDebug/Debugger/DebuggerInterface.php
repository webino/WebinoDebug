<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2018 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Debugger;

/**
 * Interface DebuggerInterface
 */
interface DebuggerInterface
{
    /**
     * Dump a variable in readable format
     *
     * @param mixed $subject Subject to dump
     * @return DebuggerDump Debugger dump object
     */
    public function dump($subject);

    /**
     * Start/stop stopwatch
     *
     * @param string|name $name Timer name
     * @return \WebinoDebug\Debugger\DebuggerTimer Debugger timer
     */
    public function timer($name = null);

    /**
     * Return dump of a variable in readable format
     *
     * @param mixed $subject
     * @return string
     * @deprecated use dump() instead, now it returns stringable object
     */
    public function dumpStr($subject);

    /**
     * Dump information about a variable in Tracy Debug Bar
     *
     * @param mixed $subject Variable to dump
     * @param string $title Optional title
     * @param array $options Dumper options
     * @return mixed Variable itself
     * @deprecated use dump() instead, now it returns object
     */
    public function barDump($subject, $title = null, array $options = null);
}
