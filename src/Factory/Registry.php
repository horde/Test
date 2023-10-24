<?php
/**
 * Generates registry services for testing purposes.
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
use Horde\Test\Stub\Registry as RegistryStub;
/**
 * Generates registry services for testing purposes.
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
class Registry
{
    /**
     * Create a stub registry service for testing.
     *
     * @param array $params Additional options.
     * <pre>
     * 'app' - (string) The application name.
     * 'user' - (string) The current user.
     * </pre>
     *
     * @return RegistryStub The test registry.
     */
    public function create($params): RegistryStub
    {
        return new RegistryStub($params['user'], $params['app']);
    }
}
