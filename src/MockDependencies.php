<?php

declare(strict_types=1);

namespace Horde\Test;

/**
 * Class that hold a number of dependencies and a class name
 * Can be used to create instances of that class or modify dependencies
 */
class MockDependencies
{
    protected array $dependencies;
    protected array $dependenciesMap;
    protected string $class;


    public function __construct(string $class, array $dependencies)
    {
        $this->class = $class;
        $this->dependencies = $dependencies;
        $depMap = [];
        foreach ($dependencies as $dep) {
            $depMap[$dep['name']] = $dep['value'];
        }
        $this->dependenciesMap = $depMap;
    }



    public function get(string $name)
    {
        return $this->dependenciesMap[$name] ?? null;
    }

    public function getValues()
    {
        $depValues = [];
        foreach ($this->dependencies as $dep) {
            $depValues[] = $dep['value'];
        }
        return $depValues;
    }

    public function instantiate()
    {
        return new $this->class(...$this->getValues());
    }
}
