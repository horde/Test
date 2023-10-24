<?php
/**
 * Copyright 2014-2021 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category  Horde
 * @copyright 2014-2021 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL
 * @link      http://www.horde.org/components/Horde_Test
 * @package   Test
 */
namespace Horde\Test\AllTests;
use PHPUnit\Runner\BaseTestRunner;
/**
 * TestRunner for Horde AllTests.php scripts.
 *
 * @author    Michael Slusarz <slusarz@horde.org>
 * @category  Horde
 * @copyright 2014-2021 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL
 * @link      http://www.horde.org/components/Horde_Test
 * @package   Test
 */
class TestRunner extends BaseTestRunner
{
    /**
     * Get the test suite.
     *
     * @param string $package  The name of the package tested by this suite.
     * @param string $dir      The path of the AllTests class.
     */
    public function getSuite($package, $dir)
    {
        $suite = $this->getTest(
            $dir,
            'Test.php'
        );
        $suite->setName('Horde Framework - ' . $package);

        return $suite;
    }

    /**
     */
    protected function runFailed(string $message): void
    {
    }

}
