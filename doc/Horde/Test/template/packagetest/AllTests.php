<?php
$rootDir = dirname(__FILE__);

// composer case: search for root dir recursively
// Load composer autoloader if found
while ($rootDir != '/')
{
    if (file_exists("$rootDir/vendor/autoload.php")) {
        require_once "$rootDir/vendor/autoload.php";
        break;
    }
    $rootDir = dirname($rootDir);
}
// otherwise try classic PEAR/include path loading
if ($rootDir == '/') {
    require_once 'Horde/Test/AllTests.php';
}
Horde_Test_AllTests::init(__FILE__)->run();
