<?php
namespace FixedWidthFile;

use PHPUnit_Framework_TestCase,
    FixedWidthFile\Specification\Record as RecordSpecification,
    FixedWidthFile\Specification\TestSpecifications,
    FixedWidthFile\Collection\Record as RecordCollection;

class RecordCollectionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->helper = new RecordCollection;
        parent::setUp();
    }

    public function testAddArrayRecord()
    {
        // addRecord only allows array or TextFileParse\Specification\Field

        $recordSpecification = TestSpecifications::getRecordSpecification();

        $this->helper->addRecord($recordSpecification);
        $this->assertEquals(count($this->helper), 1);
    }

    public function testAddObjectField()
    {
        // addRecord only allows array of TextFileParse\Specification\Field

        $recordSpecification = TestSpecifications::getRecordSpecification();
        $record = new RecordSpecification($recordSpecification);

        $this->helper->addRecord($record);
        $this->assertEquals(count($this->helper), 1);
    }

    public function testRemoveRecord()
    {
        // addRecord only allows array of TextFileParse\Specification\Record

        $recordSpecification = TestSpecifications::getRecordSpecification();
        $this->helper->addRecord($recordSpecification);

        $this->helper->remove('NonExistantRecord');
        $this->assertEquals(count($this->helper), 1);

        $this->helper->remove('LINESPEC1');
        $this->assertEquals(count($this->helper), 0);
    }
}