<?php
namespace FixedWidthFile\Specification;

use PHPUnit_Framework_TestCase,
    FixedWidthFile\Specification\Record;

class RecordTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->helper = new Record;
        parent::setUp();
    }

    public function testFieldName()
    {
        $testVal = 'SomeName';

        $this->helper->setName($testVal);
        $value = $this->helper->getName();

        $this->assertEquals($value, $testVal);
    }

    public function testFieldDescrption()
    {
        $testVal = 'TestDescription';

        $this->helper->setDescription($testVal);
        $value = $this->helper->getDescription();

        $this->assertEquals($value, $testVal);
    }

    public function testFieldPriority()
    {
        $testVal = 3;

        $this->helper->setPriority($testVal);
        $value = $this->helper->getPriority();

        $this->assertEquals($value, $testVal);
    }

    public function testFieldKeyField()
    {
        $testVal = 'RecordIdentifier';

        $this->helper->setKeyField($testVal);
        $value = $this->helper->getKeyField();

        $this->assertEquals($value, $testVal);
    }

    public function testFromArray()
    {
        $recordData = array(
            'name'       => 'RecordName',
            'description' => 'SomeDescription',
            'priority'     => 3,
            'keyField'     => 'RecordIdentifier'
        );

        $this->helper->fromArray($recordData);

        $this->assertEquals($this->helper->getName(), $recordData['name']);
        $this->assertEquals($this->helper->getDescription(), $recordData['description']);
        $this->assertEquals($this->helper->getPriority(), $recordData['priority']);
        $this->assertEquals($this->helper->getKeyField(), $recordData['keyField']);
    }

    public function testToArray()
    {
        $recordData = array(
            'name'       => 'RecordName',
            'description' => 'SomeDescription',
            'priority'     => 3,
            'keyField'     => 'RecordIdentifier'
        );

        $this->helper->fromArray($recordData);
        $recordDataNew = $this->helper->toArray();

        $this->assertTrue((string)$recordData === (string)$recordDataNew);
    }
}
