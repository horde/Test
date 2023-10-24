<?php
/**
 * Provides utilities to test for log output.
 *
 * PHP version 7
 *
 * @category Horde
 * @package  Test
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 */
namespace Horde\Test;
use Horde_Log_Handler_Base;
use Horde_Log_Handler_Mock;
use Horde_Log_Logger;
/**
 * Provides utilities to test for log output.
 *
 * Copyright 2011-2021 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category Horde
 * @package  Test
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 */
class Log extends TestCase
{
    /**
     * The log handler.
     *
     * @var Horde_Log_Handler_Mock
     */
    private $logHandler;

    /**
     * Returns a log handler.
     *
     * @return Horde_Log_Logger
     */
    public function getLogger()
    {
        if (!class_exists('Horde_Log_Logger')) {
            $this->markTestSkipped('The "Horde_Log" package is missing!');
        }
        $this->logHandler = new Horde_Log_Handler_Mock();
        return new Horde_Log_Logger($this->logHandler);
    }

    /**
     * Asserts that the log contains the given number of messages.
     *
     * You *MUST* fetch the logger via $this->getLogger() before using this
     * method. This will store a reference to an internal mock log handler that
     * will later be used to analyze the log events.
     *
     * @param int $count The expected number of messages.
     */
    public function assertLogCount(int $count)
    {
        $this->assertEquals(count($this->logHandler->events), $count);
    }

    /**
     * Asserts that the log contains at least one message matching the provided string.
     *
     * You *MUST* fetch the logger via $this->getLogger() before using this
     * method. This will store a reference to an internal mock log handler that
     * will later be used to analyze the log events.
     *
     * @param string $message The expected log message.
     *
     */
    public function assertLogContains($message)
    {
        $messages = [];
        $found = false;
        foreach ($this->logHandler->events as $event) {
            if (strstr($event['message'], $message) !== false) {
                $found = true;
                break;
            }
            $messages[] = $event['message'];
        }
        $this->assertTrue($found, sprintf("Did not find \"%s\" in [\n%s\n]", $message, join("\n", $messages)));
    }

    /**
     * Asserts that the log contains at least one message matching the provided regular_expression.
     *
     * You *MUST* fetch the logger via $this->getLogger() before using this
     * method. This will store a reference to an internal mock log handler that
     * will later be used to analyze the log events.
     *
     * @param string $regular_expression The expected regular expression.
     *
     */
    public function assertLogRegExp($regular_expression)
    {
        $messages = [];
        $found = false;
        foreach ($this->logHandler->events as $event) {
            if (preg_match($regular_expression, $event['message'], $matches) !== false) {
                $found = true;
                break;
            }
            $messages[] = $event['message'];
        }
        $this->assertTrue($found, sprintf("Did not find \"%s\" in [\n%s\n]", $$regular_expression, join("\n", $messages)));
    }

    /**
     * Utility function to return the array of logged events.
     *
     * @return array
     */
    public function getLogOutput()
    {
        return $this->logHandler->events;
    }

}
