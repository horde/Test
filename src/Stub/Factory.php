<?php
/**
 * A test helper replacing real factories.
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
/**
 * A test helper replacing real factories.
 *
 * The Horde_Injector is often queried for factories that allow to generate more
 * complex objects. The factories usually implement the create() method as
 * primary variant for generating the instance. This test replacement is meant
 * to be used as a prepared stub that can be provided to the injector and will
 * return the instance required for testing.
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
class Factory
{
    /**
     * The instance to be returned.
     *
     * @var mixed
     */
    private $instance;

    /**
     * Constructor.
     *
     * @param mixed $instance The instance that the factory should return.
     */
    public function __construct($instance)
    {
        $this->instance = $instance;
    }

    /**
     * Create an instance.
     *
     * @return mixed The predefined instance.
     */
    public function create()
    {
        return $this->instance;
    }
}
