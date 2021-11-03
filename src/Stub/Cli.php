<?php
/**
 * A test helper for testing Horde_Cli based classes.
 *
 * PHP version 7
 *
 * @category Horde
 * @package  Test
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 */
namespace Horde\Test\Stub;
use Horde_Cli;
use Horde_Support_Backtrace;
/**
 * A test helper for testing Horde_Cli based classes.
 *
 * Copyright 2010-2021 Horde LLC (http://www.horde.org/)
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
class Cli extends Horde_Cli
{
    /**
     * Displays a fatal error message.
     *
     * @param string|Exception|object $error  The error text to display, an exception or an
     *                      object with a getMessage() method.
     */
    public function fatal($error)
    {
        if ($error instanceof \Exception) {
            $trace = $error;
        } else {
            $trace = debug_backtrace();
        }
        $backtrace = new Horde_Support_Backtrace($trace);
        if (is_object($error) && method_exists($error, 'getMessage')) {
            $error = $error->getMessage();
        }
        $this->writeln($this->color('red', '===================='));
        $this->writeln();
        $this->writeln($this->color('red', 'Fatal Error:'));
        $this->writeln($this->color('red', $error));
        $this->writeln();
        $this->writeln((string)$backtrace);
        $this->writeln($this->color('red', '===================='));
    }
}
