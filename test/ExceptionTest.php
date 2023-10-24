<?php
namespace Horde\Test\Test;
use \PHPUnit\Framework\TestCase;
use \Horde\Test\Exception;
use \Horde\Exception\Wrapped as WrappedException;
use \Horde\Exception\HordeException;
/**
 * @author     Ralf Lang <lang@b1-systems.de>
 * @license    http://www.horde.org/licenses/lgpl LGPL
 * @category   Horde
 * @package    Otp
 * @subpackage UnitTests
 */
class ExceptionTest extends TestCase
{
    public function testException()
    {
        $e = new Exception('Test');
        $this->assertInstanceOf(WrappedException::class, $e);
        $this->assertInstanceOf(HordeException::class, $e);
        $this->assertInstanceOf(\Exception::class, $e);
    }
}