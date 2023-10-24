<?php
/**
 * Copyright 2014-2021 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category  Horde
 * @copyright 2014-2021 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL
 * @link      http://www.horde.org/components/Horde_Test
 * @package   Test
 */
namespace Horde\Test\Factory;
use Horde_HashTable_Memory;
use Horde\Test\Exception;

/**
 * Generates test hashtable object.
 *
 * @author    Michael Slusarz <slusarz@horde.org>
 * @category  Horde
 * @copyright 2014-2021 Horde LLC
 * @ignore
 * @license   http://www.horde.org/licenses/lgpl21 LGPL
 * @link      http://www.horde.org/components/Horde_Test
 * @package   Test
 */
class Hashtable
{
    /**
     * Create a hashtable object for testing.
     *
     * @return Horde_HashTable_Memory  The hashtable object.
     * @throws Exception
     */
    public function create()
    {
        if (!class_exists('Horde_HashTable_Base')) {
            throw new Exception('The HashTable package is unavailable!');
        }

        return new Horde_HashTable_Memory();
    }
}
