<?php
/**
 * A test helper for generating complex test setups.
 *
 * PHP version 7
 *
 * @category Horde
 * @package  Test
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 */
namespace Horde\Test;
use Horde\Injector\Injector;
use Horde\Injector\TopLevel;
/**
 * A test helper for generating complex test setups.
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
class Setup
{
    /**
     * The Injector instance which serves as our service container.
     *
     * @var Injector
     */
    private $injector;

    /**
     * In case the setup turns out to be unfullfillable this should contain an
     * appropriate message indicating the problem.
     *
     * @var string
     */
    private $error;

    /**
     * Global parameters that apply to several factories.
     *
     * @var string
     */
    private $params = [];

    /**
     * Constructor.
     */
    public function __construct()
    {
        if (class_exists('Injector')) {
            $this->injector = new Injector(new TopLevel());
            $this->injector->setInstance('Injector', $this->injector);
        } else {
            $this->error = 'The Injector class is unavailable!';
        }
    }

    /**
     * Add a new set of elements to the service container.
     *
     * @param array $params All parameters necessary for creating the services.
     *                      The keys of the array elements define the name that
     *                      will be used for registering the test service with
     *                      the injector. The element values are a
     *                      configuration array with the following elements:
     * <pre>
     * 'factory' - (string) Name of the factory. Can be a full class name or an
     *             abbreviated name that will get prepended with
     *             'Horde_Test_Factory_'
     * 'method' - (string) Method name that will be invoked on the above factory
     *            to generate the test service.
     * 'params' - (array) Any parameters the factory method might require for
     *            generating the test service. See the various factories/methods
     *            for details.
     * </pre>
     *
     * @return void
     */
    public function setup(array $params): void
    {
        if (isset($params['params'])) {
            $this->params = $params['params'];
            unset($params['params']);
        }
        foreach ($params as $interface => $setup) {
            if (is_array($setup)) {
                $factory = $setup['factory'];
                $method = isset($setup['method']) ? $setup['method'] : 'create';
                $params = isset($setup['params']) ? $setup['params'] : [];
            } else {
                $factory = $setup;
                $method = 'create';
                $params = [];
            }
            if (!empty($this->error)) {
                break;
            }
            $this->add($interface, $factory, $method, $params);
        }
    }

    /**
     * Add a new element to the service container.
     *
     * @oaram string $interface The interface name to register the service with.
     * @param string $factory   The (abbreviated) name of the factory.
     * @param string $method    The factory method that will generate the
     *                          service.
     * @param array  $params    All parameters necessary for creating the
     *                          service.
     *
     * @return void
     */
    public function add(string $interface, string $factory, string $method, array $params): void
    {
        if (!empty($this->error)) {
            return;
        }
        if (!class_exists('Horde_Test_Factory_' . $factory) &&
            !class_exists('Horde\Test\Factory\\' . $factory) &&
            !class_exists($factory)) {
            $this->error = "Neither the class \"Horde_Test_Factory_$factory\" nor \"$factory\" exist. \"$interface\" cannot be created!";
            return;
        }
        if (class_exists('Horde_Test_Factory_' . $factory)) {
            $f = $this->injector->getInstance('Horde_Test_Factory_' . $factory);
        } else {
            $f = $this->injector->getInstance($factory);
        }
        if (!method_exists($f, $method) &&
            !method_exists($f, 'create' . $method)) {
            $this->error = "The factory lacks the specified method \"$method\"!";
            return;
        }
        if (method_exists($f, 'create' . $method)) {
            $method = 'create' . $method;
        }
        $params = array_merge($this->params, $params);
        try {
            $this->injector->setInstance($interface, $f->{$method}($params));
        } catch (Exception $e) {
            $this->error = $e->getMessage() . "\n\n" . $e->getFile() . ':' . $e->getLine();
        }
    }

    /**
     * Export elements from the injector into global scope.
     *
     * @param array $elements The elements to export.
     *
     * @return void
     */
    public function makeGlobal(array $elements): void
    {
        if (!empty($this->error)) {
            return;
        }
        foreach ($elements as $key => $interface) {
            $GLOBALS[$key] = $this->injector->getInstance($interface);
        }
    }

    /**
     * Return any potential setup error.
     *
     * @return string The error.
     */
    public function getError(): string
    {
        return (string)$this->error;
    }

    /**
     * Return the service container.
     *
     * @return Injector The injector.
     */
    public function getInjector(): Injector
    {
        return $this->injector;
    }
}
