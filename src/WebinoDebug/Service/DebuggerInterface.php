<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014-2015 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug\Service;

/**
 * Interface DebuggerInterface
 */
interface DebuggerInterface
{
    /**
     * Dump a variable in readable format
     *
     * @param mixed $subject
     * @return mixed Variable itself
     */
    public function dump($subject);

    /**
     * Return dump of a variable in readable format
     *
     * @param mixed $subject
     * @return string
     */
    public function dumpStr($subject);

    /**
     * Dump information about a variable in Tracy Debug Bar
     *
     * @param mixed $subject Variable to dump
     * @param string $title Optional title
     * @param array $options Dumper options
     * @return mixed Variable itself
     */
    public function barDump($subject, $title = null, array $options = null);

    /**
     * Start/stop stopwatch
     *
     * @param string $name
     * @return float Elapsed seconds
     */
    public function timer($name);
}
