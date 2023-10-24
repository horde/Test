<?php
/**
 * Generates a dummy session.
 *
 * PHP Version 7
 *
 * @category Horde
 * @package  Test
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 */
namespace Horde\Test\Factory;
use Horde_Session;
use Horde_SessionHandler;
use Horde_SessionHandler_Storage_Builtin;
use Horde\Test\Exception;
/**
 * Generates a dummy session.
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
class Session
{
    /**
     * Create a mock session for testing.
     *
     * @return Horde_Session The mock session.
     */
    public function create()
    {
        if (!class_exists('Horde_Session')) {
            throw new Exception('The "Horde_Session" class is unavailable!');
        }
        $session = new Horde_Session();
        $session->sessionHandler = new Horde_SessionHandler(
            new Horde_SessionHandler_Storage_Builtin()
        );
        return $session;
    }
}
