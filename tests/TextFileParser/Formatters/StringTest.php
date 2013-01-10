<?php
namespace FixedWidthFile\Formatters;

use PHPUnit_Framework_TestCase,
    FixedWidthFile\Formatters\String;

class StringTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->helper = new String;
        parent::setUp();
    }

    public function testEmptyValue()
    {
        $value = $this->helper->format('', 6);
        $this->assertEquals('      ', $value);
    }

    public function testLength()
    {
        $value = $this->helper->format('Hello', 7);
        $this->assertEquals('Hello  ', $value);
    }

    public function testMaxLength()
    {
        $value = $this->helper->format('SomeTestString', 6);
        $this->assertEquals('SomeTe', $value);
    }
}
