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

        $this->helper->setFieldPosition($testVal);
        $value = $this->helper->getFieldPosition();

        $this->assertEquals($value, $testVal);
    }

    public function testFieldLength()
    {
        $testVal = 10;

        $this->helper->setFieldLength($testVal);
        $value = $this->helper->getFieldLength();

        $this->assertEquals($value, $testVal);
    }

    public function testFieldFormat()
    {
        $testVal = 'String';

        $this->helper->setFieldFormat($testVal);
        $value = $this->helper->getFieldFormat();

        $this->assertEquals($value, $testVal);
    }

    public function testFieldDefaultValue()
    {
        $testVal = 'SomeDefaultValue';

        $this->helper->setFieldDefaultValue($testVal);
        $value = $this->helper->getFieldDefaultValue();

        $this->assertEquals($value, $testVal);
    }

    public function testFieldValidation()
    {
        $testVal = '[[:alnum:]]';

        $this->helper->setFieldValidation($testVal);
        $value = $this->helper->getFieldValidation();

        $this->assertEquals($value, $testVal);
    }

    public function testFieldMandatory()
    {
        $testVal = 1;

        $this->helper->setMandatoryField($testVal);
        $value = $this->helper->getMandatoryField();

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
            'defaultValue' => 'DefVal',
            'mandatory'  => false,
        );

        $this->helper->fromArray($fieldData);

        $this->assertEquals($this->helper->getName(), $fieldData['name']);
        $this->assertEquals($this->helper->getFieldPosition(), $fieldData['position']);
        $this->assertEquals($this->helper->getFieldLength(), $fieldData['length']);
        $this->assertEquals($this->helper->getFieldFormat(), $fieldData['format']);
        $this->assertEquals($this->helper->getFieldValidation(), $fieldData['validation']);
        $this->assertEquals($this->helper->getFieldDefaultValue(), $fieldData['defaultValue']);
        $this->assertEquals($this->helper->getMandatoryField(), $fieldData['mandatory']);
    }

    public function testToArray()
    {
        $fieldData = array(
            'name'       => 'RecordIdentifier',
            'position'   => 0,
            'length'     => 5,
            'format'     => 'String',
            'validation' => '[[:alnum:]]',
            'defaultValue' => 'DefVal',
            'mandatory'  => false,
        );

        $this->helper->fromArray($fieldData);
        $fieldDataNew = $this->helper->toArray();

        $this->assertTrue($fieldData == $fieldDataNew);
    }
}
