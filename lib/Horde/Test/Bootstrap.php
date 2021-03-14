<?php
/**
 * Bootstrap code for PHPUnit tests.
 *
 * Copyright 2012-2017 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @author   Michael Slusarz <slusarz@horde.org>
 * @category Horde
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 * @package  Test
 */
class Horde_Test_Bootstrap
{
    /**
     * Only run bootstrap code once.
     *
     * @var boolean
     */
    private static $_runonce = false;

    /**
     * Bootstrap code for Horde packages.
     *
     * @param string $dir           Base directory of tests.
     * @param boolean $no_autoload  Don't run default Horde_Test autoload
     *                              tasks.
     */
    public static function bootstrap($dir, $no_autoload = false)
    {
        /**
         * Explanation:
         * If phpunit and Horde_Test is installed outside uut dir
         * there are scenarios where runonce is already true
         * but the composer autoloader has not yet run for uut dir
         *
         * We can safely move this before the runonce check
         * as it will not load the same autoload file twice
         */
        if (!$no_autoload) {
            // Find composer autoloader if possible
            $path = __DIR__;
            while ($path != '/') {
                if (file_exists($path . '/vendor/autoload.php')) {
                    require_once $path . '/vendor/autoload.php';
                    break;
                }
                $path = dirname($path);
            }
        }
        if (self::$_runonce) {
            return;
        }

        if (!$no_autoload) {
            // Catch strict standards
            error_reporting(E_ALL | E_STRICT);

            // Set up autoload
            $base = $dir;
            while ($base != '/' && basename($base) != 'Horde') {
                $base = dirname($base);
            }
            $base = dirname($base);
            if ($base) {
                set_include_path(
                    $base . PATH_SEPARATOR . $base . '/../lib' . PATH_SEPARATOR . get_include_path()
                );
            }
            if (!class_exists(\Horde_Test_Autoload::class)) {
                require_once 'Horde/Test/Autoload.php';
            }
            Horde_Test_Autoload::init();
        }

        if (file_exists($dir . '/Autoload.php')) {
            require_once $dir . '/Autoload.php';
        }

        self::$_runonce = true;
    }

}
