<?php
namespace FixedWidthFile\Specification;

use PHPUnit_Framework_TestCase,
    FixedWidthFile\Specification\Field;

class FieldTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->helper = new Field;
        parent::setUp();
    }

    public function testFieldName()
    {
        $testVal = 'SomeName';

        $this->helper->setName($testVal);
        $value = $this->helper->getName();

        $this->assertEquals($value, $testVal);
    }

    public function testFieldPosition()
    {
        $testVal = 10;

        $this->helper->setPosition($testVal);
        $value = $this->helper->getPosition();

        $this->assertEquals($value, $testVal);
    }

    public function testFieldLength()
    {
        $testVal = 10;

        $this->helper->setLength($testVal);
        $value = $this->helper->getLength();

        $this->assertEquals($value, $testVal);
    }

    public function testFieldFormat()
    {
        $testVal = 'String';

        $this->helper->setFormat($testVal);
        $value = $this->helper->getFormat();

        $this->assertEquals($value, $testVal);
    }

    public function testFieldDefaultValue()
    {
        $testVal = 'SomeDefaultValue';

        $this->helper->setDefaultValue($testVal);
        $value = $this->helper->getDefaultValue();

        $this->assertEquals($value, $testVal);
    }

    public function testFieldValidation()
    {
        $testVal = '[[:alnum:]]';

        $this->helper->setValidation($testVal);
        $value = $this->helper->getValidation();

        $this->assertEquals($value, $testVal);
    }

    public function testFieldMandatory()
    {
        $testVal = 1;

        $this->helper->setMandatory($testVal);
        $value = $this->helper->getMandatory();

        $this->assertEquals($value, true);
    }

    public function testFromArray()
    {
        $fieldData = array(
            'name'       => 'RecordIdentifier',
            'position'   => 0,
            'length'     => 5,
            'format'     => 'String',
            'validation' => '[[:alnum:]]',
            'defaultValue' => 'DefVal'
        );

        $this->helper->fromArray($fieldData);

        $this->assertEquals($this->helper->getName(), $fieldData['name']);
        $this->assertEquals($this->helper->getPosition(), $fieldData['position']);
        $this->assertEquals($this->helper->getLength(), $fieldData['length']);
        $this->assertEquals($this->helper->getFormat(), $fieldData['format']);
        $this->assertEquals($this->helper->getValidation(), $fieldData['validation']);
        $this->assertEquals($this->helper->getDefaultValue(), $fieldData['defaultValue']);
    }

    public function testToArray()
    {
        $fieldData = array(
            'name'       => 'RecordIdentifier',
            'position'   => 0,
            'length'     => 5,
            'format'     => 'String',
            'validation' => '[[:alnum:]]',
            'defaultValue' => 'DefVal'
        );

        $this->helper->fromArray($fieldData);
        $fieldDataNew = $this->helper->toArray();

        $this->assertTrue((string)$fieldData === (string)$fieldDataNew);
    }
}
