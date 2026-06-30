<?php

/**
 * Reduced Horde Autoloader for test suites.
 *
 * PHP version 5
 *
 * Copyright 2009-2026 Horde LLC (http://www.horde.org/)
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
class Horde_Test_Autoload
{
    /**
     * Prefix mappings.
     *
     * @var array
     */
    private static $_mappings = [];

    /**
     * Only run init code once.
     *
     * @var boolean
     */
    private static $_runonce = false;

    /**
     * Base autoloader code for Horde PEAR packages.
     */
    public static function init()
    {
        if (self::$_runonce) {
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

        self::$_runonce = true;
    }

    /**
     * Add a prefix to the autoloader.
     *
     * @param string $prefix  Prefix to add.
     * @param string $path    Path to the prefix.
     */
    public static function addPrefix($prefix, $path)
    {
        self::$_mappings[$prefix] = $path;
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
        $filename = str_replace(['::', '_', '\\'], '/', $class);

        foreach (self::$_mappings as $prefix => $path) {
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
