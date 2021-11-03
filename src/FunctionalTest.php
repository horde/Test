<?php
/**
 * Horde test case helper.
 *
 * PHP version 7
 *
 * @category Horde
 * @package  Test
 * @author   Chuck Hagenbuch <chuck@horde.org>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 */
namespace Horde\Test;
use DOMDocument;
/**
 * Horde test case helper.
 *
 * Copyright 2009-2021 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category Horde
 * @package  Test
 * @author   Chuck Hagenbuch <chuck@horde.org>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 */
class FunctionalTest extends TestCase
{
    /**
     * Test two XML strings for equivalency (e.g., identical up to reordering of
     * attributes).
     */
    public function assertDomEquals($expected, $actual, $message = '')
    {
        $expectedDom = new DOMDocument();
        $expectedDom->loadXML($expected);

        $actualDom = new DOMDocument();
        $actualDom->loadXML($actual);

        $this->assertEquals($expectedDom->saveXML(), $actualDom->saveXML(), $message);
    }

    /**
     * Test two HTML strings for equivalency (e.g., identical up to reordering
     * of attributes).
     */
    public function assertHtmlDomEquals(string $expected, string $actual, $message = '')
    {
        $expectedDom = new DOMDocument();
        $expectedDom->loadHTML($expected);

        $actualDom = new DOMDocument();
        $actualDom->loadHTML($actual);

        $this->assertEquals($expectedDom->saveHTML(), $actualDom->saveHTML(), $message);
    }
}
