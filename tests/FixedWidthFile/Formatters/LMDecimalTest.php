<?php
namespace FixedWidthFile\Formatters;

use PHPUnit_Framework_TestCase,
    FixedWidthFile\Formatters\LMDecimal;

class LMDecimalTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->helper = new LMDecimal;
        parent::setUp();
    }

    public function testEmptyValue()
    {
        $value = $this->helper->format(0, 6);
        $this->assertEquals('000000', $value);
    }

    public function testInteger()
    {
        $value = $this->helper->format(1234, 6);
        $this->assertEquals('001234', $value);
    }

    public function testInvalidValue()
    {
        $value = $this->helper->format('d1234', 6);
        $this->assertEquals('0', $value);
    }

    public function testDecimalValue()
    {
        $value = $this->helper->format('1234.1', '7,2');
        $this->assertEquals('000123410', $value);
    }
}
