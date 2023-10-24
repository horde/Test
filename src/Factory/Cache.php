<?php
/**
 * Generates test cache.
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
use Horde_Cache;
use Horde_Cache_Storage_Memory;
use Horde\Test\Exception;
/**
 * Generates test cache.
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
class Cache
{
    /**
     * Create a mock cache for testing.
     *
     * @return Horde_Cache The mock cache.
     */
    public function create()
    {
        if (!class_exists('Horde_Cache')) {
            throw new Exception('The "Horde_Cache" class is unavailable!');
        }
        return new Horde_Cache(new Horde_Cache_Storage_Memory());
    }
}
