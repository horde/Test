<?php
/**
 * Generates test group services.
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
use Horde_Group_Mock;
use Horde\Test\Exception;
/**
 * Generates test group services.
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
class Group
{
    /**
     * Create a mock group handler for testing.
     *
     * @return Horde_Group_Mock The mock service.
     */
    public function create()
    {
        if (!class_exists('Horde_Group_Mock')) {
            throw new Exception('The "Horde_Group_Mock" class is unavailable!');
        }
        return new Horde_Group_Mock();
    }
}
