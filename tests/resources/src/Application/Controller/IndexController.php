<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoDebug/ for the canonical source repository
 * @copyright   Copyright (c) 2014 Webino, s. r. o. (http://webino.sk/)
 * @license     BSD-3-Clause
 */

namespace Application\Controller;

use Tracy\Debugger;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Test application controller
 *
 * Actions of possible errors.
 */
class IndexController extends AbstractActionController
{
    /**
     * Tracy death screen test
     */
    public function fatalErrorAction()
    {
        undefinedFunction();
    }

    /**
     * Production error page test
     */
    public function publicFatalErrorAction()
    {
        Debugger::enable(true);
        $this->fatalErrorAction();
    }

    /**
     * Tracy death screen test
     */
    public function warningAction()
    {
        foreach (null as $item) {

        }
    }

    /**
     * Production error page test
     */
    public function publicWarningAction()
    {
        Debugger::enable(true);
        $this->warningAction();

        $view = clone $this->getEvent()->getViewModel();
        return $view->setTemplate('application/index/index');
    }

    /**
     * Tracy death screen test
     */
    public function parseErrorAction()
    {
        // include file with parse error
        require __DIR__ . '/../../../extra/parse-error.phpx';
    }

    /**
     * Production error page test
     */
    public function publicParseErrorAction()
    {
        Debugger::enable(true);
        // include file with parse error
        require __DIR__ . '/../../../extra/parse-error.phpx';
    }

    /**
     * Tracy death screen test
     */
    public function noticeAction()
    {
        UNDEFINED_CONSTANT;
    }

    /**
     * Production error page test
     */
    public function publicNoticeAction()
    {
        Debugger::enable(true);
        $this->noticeAction();

        $view = clone $this->getEvent()->getViewModel();
        return $view->setTemplate('application/index/index');
    }

    /**
     * Tracy death screen test
     */
    public function strictAction()
    {
        $this->undefined->var = null;
    }

    /**
     * Production Tracy death screen test
     */
    public function publicStrictAction()
    {
        Debugger::enable(true);
        $this->strictAction();

        $view = clone $this->getEvent()->getViewModel();
        return $view->setTemplate('application/index/index');
    }

    /**
     * Tracy death screen test
     */
    public function exceptionAction()
    {
        $this->undefinedMethod();
    }

    /**
     * Tracy death screen test
     */
    public function publicExceptionAction()
    {
        Debugger::enable(true);
        $this->undefinedMethod();
    }
}
