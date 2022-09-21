<?php

/**
 * Basic Horde test case helper.
 *
 * PHP version 7
 *
 * @category Horde
 * @package  Test
 * @author   Chuck Hagenbuch <chuck@horde.org>
 * @author   Jan Schneider <jan@horde.org>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 */

namespace Horde\Test;

use Horde_Support_Backtrace;
use ReflectionClass;

/**
 * Basic Horde test case helper.
 *
 * Copyright 2009-2021 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category Horde
 * @package  Test
 * @author   Chuck Hagenbuch <chuck@horde.org>
 * @author   Jan Schneider <jan@horde.org>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Useful shorthand if you are mocking a class with a private constructor
     */
    public function getMockSkipConstructor($className, array $methods = array(), array $arguments = array(), $mockClassName = '')
    {
        $builder = $this->getMockBuilder($className)->disableOriginalConstructor();
        if ($methods) {
            $builder = $builder->onlyMethods($methods);
        }
        if ($arguments) {
            $builder = $builder->setConstructorArgs($arguments);
        }
        if ($mockClassName) {
            $builder = $builder->setMockClassName($mockClassName);
        }
        return $builder->getMock();
    }


    /**
     * Helper method for loading test configuration from a file.
     *
     * The configuration can be specified by an environment variable. If the
     * variable content is a file name, the configuration is loaded from the
     * file. Otherwise it's assumed to be a json encoded configuration hash. If
     * the environment variable is not set, the method tries to load a conf.php
     * file from the same directory as the test case.
     *
     * @param string $env     An environment variable name.
     * @param string $path    The path to use.
     * @param array $default  Some default values that are merged into the
     *                        configuration if specified as a json hash.
     *
     * @return mixed  The value of the configuration file's $conf variable, or
     *                null.
     */
    public static function getConfig($env, $path = null, $default = array())
    {
        // Initialize for edge cases;
        $conf = [];
        $config = getenv($env);
        if ($config) {
            $json = json_decode($config, true);
            if ($json) {
                return array_replace_recursive($default, $json);
            }
        } else {
            if (!$path) {
                $backtrace = new Horde_Support_Backtrace();
                $caller = $backtrace->getCurrentContext();
                $path = dirname($caller['file']);
            }
            $config = $path . '/conf.php';
        }

        if (file_exists($config)) {
            require $config;
            return $conf;
        }

        return null;
    }

    /**
     * Create a MockDependencies instance from a class name to simplyfy creation of classes where all or most dependencies are mocked.
     *
     * @param string $class  The full name of the class
     * @param array $overrides  Optional. Hashmap were the keys are the names of the parameters of the class and values are the instance to use.
     *                               Every parameter not set here, will be automatically mocked instead
     *
     * @return MockDependencies  The MockDependencies instance that can be used to create instances of the class
     *
     * @throws Exception  If a parameter of the class does not have a type, no default value and is also not in the overrides array
     * */
    public function getMockDependencies(string $class, array $overrides = [])
    {
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        $parameters = $constructor->getParameters();

        $dependencies = [];
        foreach ($parameters as $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType();
            $override = $overrides[$name] ?? null;
            if ($override) {
                $dependency = $override;
            } elseif ($parameter->isDefaultValueAvailable()) {
                $dependency = $parameter->getDefaultValue();
            } else {
                if (is_null($type)) {
                    throw new Exception("dependency $name has no type defined and is not in overrides array");
                }
                $typeName = $type->getName();
                switch ($typeName) {
                    case 'int':
                        $dependency = 0;
                        break;
                    case 'string':
                        $dependency = '';
                        break;
                    case 'array':
                        $dependency = [];
                        break;
                    default:
                        $dependency = $this->createMock($typeName);
                        break;
                }
            }
            $dependencies[] = ['name' => $name, 'value' => $dependency];
        }
        return new MockDependencies($class, $dependencies);
    }
}
