<?php
/*
 * @copyright (c) 2018 vebut
 */
namespace Vebut\IniSizeReader;

use PHPUnit\Framework\TestCase;
use Vebut\IniSizeReader\Exception\FormatException;

/**
 * ReaderTest
 */
class ReaderTest extends TestCase
{
    /**
     * Test converting various values by static call
     *
     * @throws FormatException
     */
    public function testStatic ()
    {
        $this->assertEquals(-1, Reader::toBytes("-1"));
        $this->assertEquals(1, Reader::toBytes("1B"));
        $this->assertEquals(50, Reader::toBytes("50"));
        $this->assertEquals(1048576, Reader::toBytes("1MB"));
        $this->assertEquals(1073741824, Reader::toBytes("1GB"));
        $this->assertEquals(1125899906842624, Reader::toBytes("1PB"));

        foreach (["not a number", "1-1GB"] as $value) {
            $exception = null;
            try {
                $this->assertEquals(1024, Reader::toBytes($value));
            }
            catch (FormatException $formatException) {
                $exception = $formatException;
            }
            $this->assertInstanceOf(FormatException::class, $exception);
        }
    }


    /**
     * Test reader to make sure the passed string is never changed
     *
     * @throws FormatException
     */
    public function testReader ()
    {
        $string = "432M";
        $reader = new Reader($string);
        $this->assertEquals(452984832, $reader->getBytes());
        $this->assertEquals($string, $reader->getString());
    }
}
