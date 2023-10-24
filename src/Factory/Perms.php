<?php
/**
 * Generates the test permission service.
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
use Horde_Perms_Null;
use Horde\Test\Exception;
/**
 * Generates the test permission service.
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
class Perms
{
    /**
     * Create a null permission service for testing.
     *
     * @return Horde_Perms_Null The test service.
     */
    public function create()
    {
        if (!class_exists('Horde_Perms_Null')) {
            throw new Exception('The "Horde_Perms_Null" class is unavailable!');
        }
        return new Horde_Perms_Null();
    }
}
