<?php
/**
 * Generates the history service for testing purposes.
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
use Horde_History;
use Horde_History_Mock;
/**
 * Generates the history service for testing purposes.
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
class History
{
    /**
     * Create a mock history service for testing.
     *
     * @param array $params Additional options.
     * <pre>
     * 'user' - (string) The current user.
     * </pre>
     *
     * @return Horde_History The test service.
     */
    public function create(array $params = [])
    {
        if (!class_exists('Horde_History')) {
            throw new \Horde\Test\Exception('The "Horde_History" class is unavailable!');
        }
        return new Horde_History_Mock($params['user']);
    }
}
