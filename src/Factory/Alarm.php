<?php
/**
 * Generates an alarm setup for the test situation.
 *
 * PHP version 7
 *
 * @category Horde
 * @package  Test
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 */
namespace Horde\Test\Factory;
use Horde\Test\Exception;
use Horde_Alarm_Null;
/**
 * Generates an alarm setup for the test situation.
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
class Alarm
{
    /**
     * Create a mock alarm system for testing.
     *
     * @return Horde_Alarm_Null The mock alarm system.
     *
     * @throws Exception
     */
    public function create()
    {
        if (!class_exists('Horde_Alarm')) {
            throw new Exception('The "Horde_Alarm" class is unavailable!');
        }
        return new Horde_Alarm_Null();
    }
}
