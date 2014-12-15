<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace WebinoDebug;

use WebinoDev\Test\Selenium\AbstractTestCase;

/**
 * Test an application that it can handle errors properly.
 */
class HomeTest extends AbstractTestCase
{
    /**
     * Test that home page is working
     */
    public function testHome()
    {
        $this->openOk();
    }

    /**
     * Public error snippet for assertions
     *
     * @return string
     */
    public function getPublicError()
    {
        return 'was unable to complete your request. Please try again later.';
    }

    /**
     * Special function to get contents of error pages
     *
     * We can't use selenium, nor simple file_get_contents(),
     * because both of them fails on tracy death screens.
     *
     * @param string $uri
     * @return string
     */
    private function getContents($uri)
    {
        return file_get_contents($uri, false, stream_context_create(['http' => ['ignore_errors' => true]]));
    }

    /**
     * Assert that we are seeing the Tracy debug screen
     *
     * @param string $src
     */
    private function assertTracyDebug($src)
    {
        $this->assertContains('class="tracy-debug"', $src);
    }

    /**
     * Assert that we are not seeing the Tracy debug screen
     *
     * @param string $src
     */
    private function assertNotTracyDebug($src)
    {
        $this->assertNotContains('class="tracy-debug"', $src);
    }

    /**
     * Assert that we are seeing production error screen
     *
     * @param string $src
     */
    private function assertPublicError($src)
    {
        $this->assertContains('Server Error', $src);
        $this->assertContains($this->getPublicError(), $src);
    }

    /**
     * Assert that we not are seeing production error screen
     *
     * @param string $src
     */
    private function assertNotPublicError($src)
    {
        $this->assertNotContains('Server Error', $src);
        $this->assertNotContains($this->getPublicError(), $src);
    }

    /**
     * Fatal Error test
     */
    public function testFatalError()
    {
        $src = $this->getContents($this->uri . 'application/index/fatal-error');
        $this->assertTracyDebug($src);
        $this->assertContains('Fatal Error', $src);
        $this->assertContains('Application\Controller\undefinedFunction', $src);
    }

    /**
     * Production Fatal Error test
     */
    public function testPublicFatalError()
    {
        $src = $this->getContents($this->uri . 'application/index/public-fatal-error');
        $this->assertNotTracyDebug($src);
        $this->assertNotContains('Fatal Error', $src);
        $this->assertNotContains('Application\Controller\undefinedFunction', $src);
        $this->assertPublicError($src);
    }

    /**
     * Warning test
     */
    public function testWarning()
    {
        $src = $this->getContents($this->uri . 'application/index/warning');
        $this->assertTracyDebug($src);
        $this->assertContains('Warning', $src);
        $this->assertContains('Invalid argument supplied for foreach()', $src);
    }

    /**
     * Production Warning test
     */
    public function testPublicWarning()
    {
        $src = $this->getContents($this->uri . 'application/index/public-warning');
        $this->assertNotTracyDebug($src);
        $this->assertNotContains('Warning', $src);
        $this->assertNotContains('Invalid argument supplied for foreach()', $src);
        $this->assertNotPublicError($src);
    }

    /**
     * Parse Error test
     */
    public function testParseError()
    {
        $src = $this->getContents($this->uri . 'application/index/parse-error');
        $this->assertTracyDebug($src);
        $this->assertContains('Parse Error', $src);
        $this->assertContains('syntax error, unexpected \'.\'', $src);
    }

    /**
     * Production Parse Error test
     */
    public function testPublicParseError()
    {
        $src = $this->getContents($this->uri . 'application/index/public-parse-error');
        $this->assertNotTracyDebug($src);
        $this->assertNotContains('Parse Error', $src);
        $this->assertNotContains('syntax error', $src);
        $this->assertPublicError($src);
    }

    /**
     * Notice test
     */
    public function testNotice()
    {
        $src = $this->getContents($this->uri . 'application/index/notice');
        $this->assertTracyDebug($src);
        $this->assertContains('Notice', $src);
        $this->assertContains('Use of undefined constant UNDEFINED_CONSTANT - assumed \'UNDEFINED_CONSTANT\'', $src);
    }

    /**
     * Production Notice test
     */
    public function testPublicNotice()
    {
        $src = $this->getContents($this->uri . 'application/index/public-notice');
        $this->assertNotTracyDebug($src);
        $this->assertNotContains('Notice', $src);
        $this->assertNotContains('Use of undefined constant UNDEFINED_CONSTANT', $src);
        $this->assertNotPublicError($src);
    }

    /**
     * Strict test
     */
    public function testStrict()
    {
        $src = $this->getContents($this->uri . 'application/index/strict');
        $this->assertTracyDebug($src);
        $this->assertContains('Warning', $src);
        $this->assertContains('Creating default object from empty value', $src);
    }

    /**
     * Production Strict test
     */
    public function testPublicStrict()
    {
        $src = $this->getContents($this->uri . 'application/index/public-strict');
        $this->assertNotTracyDebug($src);
        $this->assertNotContains('Warning', $src);
        $this->assertNotContains('Creating default object from empty value', $src);
        $this->assertNotPublicError($src);
    }

    /**
     * Exception test
     */
    public function testException()
    {
        $src = $this->getContents($this->uri . 'application/index/exception');
        $this->assertTracyDebug($src);
        $this->assertContains('Exception', $src);
    }

    /**
     * Production Exception test
     */
    public function testPublicException()
    {
        $src = $this->getContents($this->uri . 'application/index/public-exception');
        $this->assertNotTracyDebug($src);
        $this->assertNotContains('Exception', $src);
        $this->assertPublicError($src);
    }
}
