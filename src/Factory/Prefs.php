<?php
/**
 * Generates preferences services for testing purposes.
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

use Horde;
use Horde_Prefs;
use Horde_Prefs_Storage_Null;
use Horde\Test\Exception;

/**
 * Generates preferences services for testing purposes.
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
class Prefs
{
    /**
     * Create a null preferences service for testing.
     *
     * @param array $params Additional options.
     * <pre>
     * 'app' - (string) The application name.
     * 'user' - (string) The current user.
     * </pre>
     *
     * @return Horde_Prefs The test service.
     */
    public function create($params): Horde_Prefs
    {
        if (!class_exists('Horde_Prefs')) {
            throw new Exception('The "Horde_Prefs" class is unavailable!');
        }
        return new Horde_Prefs($params['app'], new Horde_Prefs_Storage_Null($params['user']));
    }
}
