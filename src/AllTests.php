<?php
/**
 * Horde base test suite
 *
 * PHP version 7
 *
 * @category Horde
 * @package  Test
 * @author   Jan Schneider <jan@horde.org>
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 */
namespace Horde\Test;
use Horde\Test\AllTests\TestRunner;
/**
 * Horde base test suite
 *
 * Copyright 2009-2021 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category Horde
 * @package  Test
 * @author   Jan Schneider <jan@horde.org>
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 */
class AllTests
{
    private $dir;
    private $package;

    /**
     * Create a Horde\Test\AllTests object.
     *
     * @param string $file  Filename of the AllTests.php script.
     *
     * @return AllTests  Test object.
     */
    public static function init(string $file)
    {
        $dirAllTests = dirname($file);

        $parts = [];
        foreach (array_reverse(explode(DIRECTORY_SEPARATOR, $dirAllTests)) as $val) {
            if ($val == 'test' ||
                $val == implode('_', array_reverse($parts))) {
                break;
            }
            $parts[] = $val;
        }

        return new self(
            implode('_', array_reverse($parts)),
            $dirAllTests
        );
    }

    /**
     * Constructor.
     *
     * @param string $package  The name of the package tested by this suite.
     * @param string $dir      The path of the AllTests class.
     */
    public function __construct(string $package, string $dir)
    {
        $this->package = $package;
        $this->dir = $dir;
    }

    /**
     * Main entry point for running the suite.
     *
     * @return boolean
     */
    public function run()
    {
        $old_dir = getcwd();
        chdir($this->dir);
        $old_error = error_reporting();
        $suite = $this->suite();
        $runner = new \PHPUnit\TextUI\TestRunner();
        $result = $runner->run($suite, [
            'colors' => 'auto',
            'extensions' => []
        ], [] , false);
        error_reporting($old_error);
        chdir($old_dir);
        return $result;
    }

    /**
     * Collect the unit tests of this directory into a new suite.
     *
     * @return \PHPUnit\Framework\TestSuite The test suite.
     */
    public function suite()
    {
        $this->setup();

        $runner = new TestRunner();
        return $runner->getSuite($this->package, $this->dir);
    }

    /**
     * Basic test suite setup. This includes error checking and autoloading.
     *
     * In the default situation this will set the error reporting to E_ALL |
     * E_STRICT and pull in Horde/Test/Autoload.php as autoloading
     * definition. If there is an Autoload.php in $_dir, then only this file
     * will be used.
     *
     * In addition the setup() call will attempt to detect the "lib" directory
     * of the component currently under test and add it to the
     * include_path. This ensures that the component code from the checkout is
     * preferred over whatever else might be available in the default
     * include_path.
     */
    public function setup()
    {
        // Detect component root and add "lib" and "test" to the include path.
        $base = $this->dir;
        while ($base != '/' && basename($base) != 'test') {
            $base = dirname($base);
        }
        if ($base) {
            set_include_path(
                $base . PATH_SEPARATOR . $base . '/../lib' . PATH_SEPARATOR . get_include_path()
            );
        }

        if (!class_exists(Bootstrap::class)) {
            require_once 'Horde/Test/Bootstrap.php';
        }
        Bootstrap::bootstrap($this->dir);

        if (file_exists($this->dir . '/Autoload.php')) {
            require_once $this->dir . '/Autoload.php';
        }
    }

}
