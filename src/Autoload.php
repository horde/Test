<?php
namespace Horde\Test;
/**
 * Reduced Horde Autoloader for test suites.
 *
 * PHP version 7
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
class Autoload
{
    /**
     * Prefix mappings.
     *
     * @var array
     */
    private static $mappings = [];

    /**
     * Only run init code once.
     *
     * @var boolean
     */
    private static $runonce = false;

    /**
     * Base autoloader code for Horde PEAR packages.
     */
    public static function init()
    {
        if (self::$runonce) {
            return;
        }

        // Find composer autoloader if possible
        $path = __DIR__;
        while ($path != '/') {
            if (file_exists($path . '/vendor/autoload.php')) {
                require_once $path . '/vendor/autoload.php';
                break;
            }
            $path = dirname($path);
        }

        spl_autoload_register(
            function($class) {
                $filename = Autoload::resolve($class);
                $err_mask = error_reporting() & ~E_WARNING;
                $old_err = error_reporting($err_mask);
                include "$filename.php";
                error_reporting($old_err);
            },
            true,
            true
        );

        self::$runonce = true;
    }

    /**
     * Add a prefix to the autoloader.
     *
     * @param string $prefix  Prefix to add.
     * @param string $path    Path to the prefix.
     */
    public static function addPrefix($prefix, $path)
    {
        self::$mappings[$prefix] = $path;
    }

    /**
     * Resolve classname to a filename.
     *
     * @param string $class  Class name.
     *
     * @return string  Resolved filename.
     */
    public static function resolve($class)
    {
        $filename = str_replace(array('::', '_', '\\'), '/', $class);

        foreach (self::$mappings as $prefix => $path) {
            if ((strpos($filename, "/") === false) && ($filename == $prefix)) {
                $filename = $path . '/' . $filename;
            }
            if (substr($filename, 0, strlen($prefix)) == $prefix) {
                $filename = $path . substr($filename, strlen($prefix));
            }
        }

        return $filename;
    }

}
