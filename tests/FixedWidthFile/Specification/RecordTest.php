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

    public function testRecordName()
    {
        $testVal = 'SomeName';

        $this->helper->setName($testVal);
        $value = $this->helper->getName();

        $this->assertEquals($value, $testVal);
    }

    public function testRecordDescrption()
    {
        $testVal = 'TestDescription';

        $this->helper->setRecordDescription($testVal);
        $value = $this->helper->getRecordDescription();

        $this->assertEquals($value, $testVal);
    }

    public function testRecordPriority()
    {
        $testVal = 3;

        $this->helper->setRecordPriority($testVal);
        $value = $this->helper->getRecordPriority();

        $this->assertEquals($value, $testVal);
    }

    public function testRecordKeyField()
    {
        $testVal = 'RecordIdentifier';

        $this->helper->setRecordKeyField($testVal);
        $value = $this->helper->getRecordKeyField();

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
        $this->assertEquals($this->helper->getRecordDescription(), $recordData['description']);
        $this->assertEquals($this->helper->getRecordPriority(), $recordData['priority']);
        $this->assertEquals($this->helper->getRecordKeyField(), $recordData['keyField']);
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

        // Discard the collection as we are not testing that here
        unset($recordDataNew['fieldCollection']);

        $this->assertTrue($recordData == $recordDataNew);
    }
}
